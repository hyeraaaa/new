<?php
require_once '../../login/dbh.inc.php'; // Database connection
require 'log.php';
//Get info from admin session
session_start();
$user = $_SESSION['user'];
$admin_id = $_SESSION['user']['admin_id'];

// Check if the announcement ID is set
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    // Perform the deletion
    try {
        $query = "DELETE FROM student WHERE student_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $student_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            logAction($pdo, $admin_id, 'admin', 'delete', 'student', $student_id, 'Deleted a student record');
            echo "<script>
            window.location.href = 'manage_student.php?deleted=true';
                </script>";
        } else {
            logAction($pdo, $admin_id, 'admin', 'delete', 'student', $student_id, 'Failed to delete a student record');
            echo "<script>
                alert('There was an error in deleting the student data.');
                window.location.href = 'manage_student.php';
                </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = 'manage_student.php';
            </script>";
    }
} else {
    echo "<script>
        alert('No student ID provided.');
        window.location.href = 'manage_student.php';
        </script>";
}
