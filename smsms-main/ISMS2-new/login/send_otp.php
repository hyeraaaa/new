<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'dbh.inc.php';
require '../admin/features/config.php';
require '../admin/features/log.php';

// function sendMessage($contact_number, $message)
// {
//     $infobip_url = "https://wg43qy.api.infobip.com/sms/2/text/advanced";
//     $api_key = INFOPB_API_KEY;

//     $data = [
//         "messages" => [
//             [
//                 "from" => "447491163443",
//                 "destinations" => [
//                     ["to" => $contact_number]
//                 ],
//                 "text" => $message
//             ]
//         ]
//     ];

//     $headers = [
//         "Authorization: App $api_key",
//         "Content-Type: application/json",
//         "Accept: application/json"
//     ];

//     $options = [
//         'http' => [
//             'header'  => implode("\r\n", $headers),
//             'method'  => 'POST',
//             'content' => json_encode($data),
//         ],
//     ];

//     $context = stream_context_create($options);
//     $result = file_get_contents($infobip_url, false, $context);
//     if ($result === FALSE) {
//         error_log("Failed to send SMS to $contact_number");
//         return false;
//     }
//     error_log("Sent SMS to $contact_number: $result");
//     return json_decode($result, true);
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $user_found = false;
    $user_type = '';
    $first_name = '';
    $contact_number = '';
    $display_email = $email;

    $stmt_student = $pdo->prepare("SELECT * FROM student WHERE email = :email");
    $stmt_student->execute(['email' => $email]);
    $result_student = $stmt_student->fetch(PDO::FETCH_ASSOC);

    if (isset($_GET['email'])) {
        $display_email = $_GET['email'];
    }

    if ($result_student) {
        $user_found = true;
        $user_type = 'student';
        $contact_number = $result_student['contact_number'];
        $first_name =  $result_student['first_name'];
    }

    $stmt_staff = $pdo->prepare("SELECT * FROM admin WHERE email = :email");
    $stmt_staff->execute(['email' => $email]);
    $result_staff = $stmt_staff->fetch(PDO::FETCH_ASSOC);

    if ($result_staff) {
        $user_found = true;
        $user_type = 'admin';
        $contact_number = $result_staff['contact_number'];
        $first_name =  $result_staff['first_name'];
    }

    if ($user_found) {
        $otp = rand(100000, 999999);
        $otp_expiry = gmdate("Y-m-d H:i:s", strtotime('+10 minutes'));

        if ($user_type == 'student') {
            $update_stmt = $pdo->prepare("UPDATE student SET otp = :otp, otp_expiry = :otp_expiry WHERE email = :email");
        } else {
            $update_stmt = $pdo->prepare("UPDATE admin SET otp = :otp, otp_expiry = :otp_expiry WHERE email = :email");
        }

        $update_stmt->execute([
            'otp' => $otp,
            'otp_expiry' => $otp_expiry,
            'email' => $email
        ]);



        // Send Email with OTP
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ismsbatstateu@gmail.com';
            $mail->Password = 'vkfy htwr ldkd qoav';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('ismsbatstateu@gmail.com', 'ISMS - BSU Announcement Portal');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->addEmbeddedImage('pics/brand.png', 'brand_logo');
            $mail->Subject = 'Your Password Reset OTP';
            $mail->Body = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>OTP</title>
            </head>
            <body style="margin: 0;">
                <div style="width: 500px; background-color: #ffffff; border-radius: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); padding: 30px; margin: 20px auto; font-family: Arial, sans-serif;">
                    <div style="background-color: #f9f9f9; border-radius: 15px; padding: 20px;">
                        <div style="display: flex; flex-direction: row; align-items: center; margin-bottom: 20px;">
                            <img src="cid:brand_logo" alt="" style="height: 70px;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <h2 style="margin: 20px 0 10px; font-size: 20px;">Hello ' . htmlspecialchars($first_name) . ',</h2>
                            <p style="font-size: 16px; color: #555; margin: 10px 0;">We received a request to reset your password. To proceed, please use the following One-Time Password (OTP):</p>
                        </div>
            
                        <div style="text-align: center; margin: 15px 0;">
                            <div style="font-size: 36px; font-weight: bold; background-color: #ffffff; padding: 15px 25px; border: 2px solid rgb(182, 29, 29); border-radius: 5px; display: inline-block;">
                                ' . htmlspecialchars($otp) . '
                            </div>
                        </div>
            
                        <p style="font-size: 16px; color: #555; margin: 10px 0;">This code is valid for 10 minutes.</p>
                        <p style="font-size: 16px; color: #555; margin: 10px 0;">If you did not request a password reset, please ignore this email.</p>
                        <div style="margin-top: 20px; font-size: 14px; color: #777;">
                            <p>Best regards,</p>
                            <p>I-SMS Team</p>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            ';

            $mail->send();

            // Send SMS with OTP
            // $smsMessage = "Your OTP is: $otp. It is valid for 10 minutes.";
            // sendMessage($contact_number, $smsMessage);

?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Validation OTP</title>
                <?php include '../cdn/head.html'; ?>

                <link rel="stylesheet" href="login.css">
            </head>

            <body class="d-flex flex-column min-vh-100">
                <header class="header_container bg-white">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <a href="#" class="d-block">
                                    <img
                                        src="pics/brand.png"
                                        alt="Brand Logo"
                                        class="img-fluid"
                                        width="150"
                                        height="auto">
                                </a>
                            </div>
                            <div class="col-6">
                                <h1 class="text-center fw-bold m-0">ISMS ANNOUNCEMENTS</h1>
                            </div>
                            <div class="col-3 text-end">
                                <a href="#" class="d-block">
                                    <img
                                        src="pics/bsu_logo.png"
                                        alt="BSU Logo"
                                        class="img-fluid"
                                        width="150"
                                        height="auto">
                                </a>
                            </div>
                        </div>
                    </div>
                </header>


                <section class="login_container flex-grow-1 d-flex justify-content-center align-items-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6 col-lg-5">
                                <div class="card shadow-lg border-0">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <h2 class="fw-bold">Verify OTP</h2>
                                            <p class="text-muted mb-0">Please check your email for the OTP code</p>
                                        </div>

                                        <form id="otp_form" method="POST" action="validate_otp.php">
                                            <?php if (isset($_GET['message'])): ?>
                                                <div class="alert alert-danger py-2"><?php echo $_GET['message']; ?></div>
                                            <?php endif; ?>

                                            <div class="form-floating mt-3">
                                                <input
                                                    type="email"
                                                    name="email"
                                                    id="email"
                                                    class="form-control"
                                                    placeholder="name@example.com"
                                                    value="<?php echo htmlspecialchars($display_email); ?>"
                                                    readonly
                                                    required>

                                                <label for="email">Email address</label>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="mt-3">
                                                <label class="form-label">Enter OTP Code</label>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <input type="text" class="form-control text-center otp-input" maxlength="1" data-index="1" style="width: 45px; height: 45px; padding: 0;">
                                                    <input type="text" class="form-control text-center otp-input" maxlength="1" data-index="2" style="width: 45px; height: 45px; padding: 0;">
                                                    <input type="text" class="form-control text-center otp-input" maxlength="1" data-index="3" style="width: 45px; height: 45px; padding: 0;">
                                                    <input type="text" class="form-control text-center otp-input" maxlength="1" data-index="4" style="width: 45px; height: 45px; padding: 0;">
                                                    <input type="text" class="form-control text-center otp-input" maxlength="1" data-index="5" style="width: 45px; height: 45px; padding: 0;">
                                                    <input type="text" class="form-control text-center otp-input" maxlength="1" data-index="6" style="width: 45px; height: 45px; padding: 0;">
                                                </div>
                                                <input type="hidden" name="otp" id="otp">
                                                <div class="invalid-feedback text-center"></div>
                                            </div>

                                            <button type="submit" class="btn btn-danger w-100 py-2 mt-3">
                                                Verify OTP
                                            </button>

                                            <div class="text-center text-danger mt-3">
                                                <button type="button" id="resendOTP" class="btn btn-link text-decoration-none p-0" disabled>
                                                    Resend OTP (10s)
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <footer class="bg-black py-3">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h2 class="h5 text-white mb-2">BATANGAS STATE UNIVERSITY</h2>
                                <p class="text-white-50 mb-2">A premier national university that develops leaders in the global knowledge economy</p>
                                <p class="text-white-50 small mb-0">Copyright &copy; <?php echo date('Y'); ?></p>
                            </div>
                            <div class="col-4">
                                <div class="text-end">
                                    <img
                                        src="pics/redspartan-logo.png"
                                        alt="Red Spartan Logo"
                                        class="img-fluid"
                                        width="150"
                                        height="auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <?php include '../cdn/body.html'; ?>
                <script src="resend-otp.js"></script>
            </body>

            </html>
<?php
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email does not exist in either student or school staff records.";
    }
}
