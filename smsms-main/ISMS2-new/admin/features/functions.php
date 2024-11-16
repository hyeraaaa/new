<?php
require '../../login/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $toName, $subject, $body, $altBody = '', $from = 'ismsbatstateu@gmail.com', $fromName = 'ISMS-Portal')
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'ismsbatstateu@gmail.com';             // SMTP username
        $mail->Password   = 'vkfy htwr ldkd qoav';                      // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption
        $mail->Port       = 587;                                   // TCP port to connect to

        // Recipients
        $mail->setFrom($from, $fromName);                          // Set the sender's email and name
        $mail->addAddress($to, $toName);                           // Add a recipient

        // Content
        $mail->isHTML(true);                                      // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody ? $altBody : strip_tags($body); // Use provided alt body or strip HTML tags from body

        $mail->send();
        return true; // Return true if the email is sent successfully
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; // Return error message
    }
}

// Function to get the corresponding ID from a table based on a name field
function getIdByName($pdo, $table, $column, $value, $id)
{
    $sql = "SELECT $id FROM $table WHERE $column = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$value]);
    $result = $stmt->fetchColumn();
    error_log("getIdByName for $table: Column $column, Value $value, Result: $result");
    return (int) $result;
}


function getIdByNameForStudentInfo($pdo, $table, $column1, $column2, $value, $id)
{
    $sql = "SELECT y.$column1 FROM $table y
            JOIN student s ON y.$column1 = s.$column1
            WHERE s.student_id = :student_id AND y.$column2 = :value;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':student_id', $id);
    $stmt->bindParam(':value', $value);
    $stmt->execute();
    $result = $stmt->fetchColumn();
    error_log("getIdByName for $table: Column1 $column1, Column2 $column2, ID $id, Result: $result");
    return (int) $result;
}

function getNameById($pdo, $table, $id_column, $name_column, $id)
{
    $sql = "SELECT $name_column FROM $table WHERE $id_column = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}


//  Function to get student contact information for an announcement
function getStudentsForAnnouncement($pdo, $year_levels, $departments, $courses)
{
    // Convert descriptive names to their corresponding IDs for filtering
    $year_level_ids = [];
    foreach ($year_levels as $year_level_name) {
        $year_level_id = getIdByName($pdo, 'year_level', 'year_level', $year_level_name, 'year_level_id');
        if ($year_level_id !== null) {
            $year_level_ids[] = $year_level_id; // Store the integer ID
        }
    }

    $department_ids = [];
    foreach ($departments as $department_name) {
        $department_id = getIdByName($pdo, 'department', 'department_name', $department_name, 'department_id');
        if ($department_id !== null) {
            $department_ids[] = $department_id; // Store the integer ID
        }
    }

    $course_ids = [];
    foreach ($courses as $course_name) {
        $course_id = getIdByName($pdo, 'course', 'course_name', $course_name, 'course_id');
        if ($course_id !== null) {
            $course_ids[] = $course_id; // Store the integer ID
        }
    }

    // Construct the query using IN clauses for filtering
    $query = "SELECT DISTINCT s.student_id, s.contact_number
              FROM student s
              WHERE s.year_level_id IN (" . implode(',', array_fill(0, count($year_level_ids), '?')) . ")
              AND s.department_id IN (" . implode(',', array_fill(0, count($department_ids), '?')) . ")
              AND s.course_id IN (" . implode(',', array_fill(0, count($course_ids), '?')) . ")";

    // Prepare the statement
    $stmt = $pdo->prepare($query);

    // Bind the values for year_levels, departments, and courses
    $params = array_merge($year_level_ids, $department_ids, $course_ids);
    $stmt->execute($params);

    // Fetch and return the results
    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log('Result: ' . print_r($output, true));

    return $output;
}

// Replaces sendSmsToStudents function, using a working sendMessage function
function sendMessage($contact_number, $message)
{
    $infobip_url = "https://wg43qy.api.infobip.com/sms/2/text/advanced";
    $api_key = INFOPB_API_KEY;

    $data = [
        "messages" => [
            [
                "from" => "447491163443",
                "destinations" => [
                    ["to" => $contact_number]
                ],
                "text" => $message
            ]
        ]
    ];

    $headers = [
        "Authorization: App $api_key",
        "Content-Type: application/json",
        "Accept: application/json"
    ];

    $options = [
        'http' => [
            'header'  => implode("\r\n", $headers),
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($infobip_url, false, $context);
    if ($result === FALSE) {
        error_log("Failed to send SMS to $contact_number");

        return false;
    }
    error_log("Sent SMS to $contact_number: $result");
    return json_decode($result, true);
}

function addNewStudent($s_first_name, $s_last_name, $s_email, $s_contact_number, $s_year, $s_dept, $s_course)
{
    global $pdo;

    // Check if email already exists in the student table
    $checkEmailQuery = "SELECT COUNT(*) FROM student WHERE email = :email";
    $checkStmt = $pdo->prepare($checkEmailQuery);
    $checkStmt->bindParam(':email', $s_email);
    $checkStmt->execute();

    $emailExists = $checkStmt->fetchColumn();

    if ($emailExists > 0) {
        echo "<script>alert('Error: This email address is already registered.');</script>";
        return;
    } else {
        // Check if email exists in the admin table
        $checkEmailQuery = "SELECT COUNT(*) FROM admin WHERE email = :email";
        $checkStmt = $pdo->prepare($checkEmailQuery);
        $checkStmt->bindParam(':email', $s_email);
        $checkStmt->execute();

        $emailExists = $checkStmt->fetchColumn();
        if ($emailExists > 0) {
            echo "<script>alert('Error: This email address is already registered.');</script>";
            return;
        }
    }

    // Generate a password using first name and last 4 digits of the contact number
    $formattedFirstName = ucfirst(strtolower($s_first_name));
    $lastFourDigits = substr($s_contact_number, -4); // Extract last four digits
    $password = $formattedFirstName . $lastFourDigits;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement with the generated password
    $sql = "INSERT INTO student (password, first_name, last_name, email, contact_number, year_level_id, department_id, course_id) 
            VALUES (:password, :first_name, :last_name, :email, :contact_number, :ylevel, :dept, :course)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':first_name', $s_first_name);
    $stmt->bindParam(':last_name', $s_last_name);
    $stmt->bindParam(':email', $s_email);
    $stmt->bindParam(':contact_number', $s_contact_number);
    $stmt->bindParam(':ylevel', $s_year);
    $stmt->bindParam(':dept', $s_dept);
    $stmt->bindParam(':course', $s_course);

    if ($stmt->execute()) {
        // Send email with password setup link
        $mail = new PHPMailer(true);
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ismsbatstateu@gmail.com';
        $mail->Password = 'vkfy htwr ldkd qoav';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('ismsbatstateu@gmail.com', 'ISMS - BSU Announcement Portal');
        $mail->addAddress($s_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Account for the ISMS Portal was created successfully';
        $setupLink = "localhost/I-SMS/login/login.php";
        $mail->Body = "Your account was created successfully. <br> 
                        You can login using your email address and your password will be your first name + the last four digits of your contact number. <br>
                        Example: if first name is 'John' and contact number is '09635242249', password will be 'John2249' <br>
                        Note: The first letter of of your first name is uppercase. 
                        Log in to the website by clicking on the link below.<br>
                        <a href='" . $setupLink . "'>Login Here</a>";

        $mail->send();

        // Send SMS notification
        $smsMessage = "Welcome to ISMS Portal. Your account has been created. Login with your email and password:" . $s_first_name  . "+ last 4 digits of your contact number.";
        sendMessage($s_contact_number, $smsMessage);

        echo "<script>alert('New record created successfully.');</script>";
    } else {
        echo "<script>alert('Error: Could not add student.');</script>";
    }
}
