<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptchaSecret = '6LfgN1kqAAAAAB1z-4A5lO592_X2thaBuTiWoZDn';
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            header("Location: login.php?error=Please complete the reCAPTCHA");
            exit();
        }
    } else {
        header("Location: login.php?error=ReCAPTCHA missing");
        exit();
    }

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = null;
        $user_type = null;

        // Check if the user is an admin
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $user_type = 'admin';
        } else {
            // Check if the user is a student
            $stmt = $pdo->prepare("SELECT * FROM student WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user) {
                $user_type = 'student';
            }
        }

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Store user info and user type in session
                $_SESSION['user'] = $user;
                $_SESSION['user_type'] = $user_type;
                if($user_type === 'admin'){
                    header("Location: ../admin/admin.php");
                    exit();
                } else {
                    header("Location: ../user/user.php");
                    exit();
                }
                
            } else {
                error_log("Invalid password for user: $email");
                header("Location: login.php?error=Invalid credentials");
                exit();
            }
        } else {
            error_log("No user found with email: $email");
            header("Location: login.php?error=Invalid credentials");
            exit();
        }
    } else {
        header("Location: login.php?error=Email and password are required");
        exit();
    }
}
