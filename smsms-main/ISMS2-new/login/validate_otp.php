<?php
include 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $user_found = false;
    $user_type = '';

    $stmt_student = $pdo->prepare("SELECT * FROM student WHERE email = :email AND otp = :otp AND otp_expiry > CURRENT_TIMESTAMP AT TIME ZONE 'UTC'");
    $stmt_student->execute(['email' => $email, 'otp' => $otp]);
    $result_student = $stmt_student->fetch(PDO::FETCH_ASSOC);

    if ($result_student) {
        $user_found = true;
        $user_type = 'student';
    }

    $stmt_staff = $pdo->prepare("SELECT * FROM admin WHERE email = :email AND otp = :otp AND otp_expiry > CURRENT_TIMESTAMP AT TIME ZONE 'UTC'");
    $stmt_staff->execute(['email' => $email, 'otp' => $otp]);
    $result_staff = $stmt_staff->fetch(PDO::FETCH_ASSOC);

    if ($result_staff) {
        $user_found = true;
        $user_type = 'admin';
    }

    if ($user_found) {
        header("Location: resetpassword.php?email=$email&type=$user_type");
    } else {
        echo "Invalid or expired OTP.";
    }
}
?>
