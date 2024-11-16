<?php
require_once '../../login/dbh.inc.php'; // Database connection
require 'log.php';
//Get info from admin session
session_start();
$user = $_SESSION['user'];
$admin_id = $_SESSION['user']['admin_id'];

// Check if the announcement ID is set
if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];
    // Perform the deletion
    try {
        $query = "DELETE FROM announcement WHERE announcement_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $announcement_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            logAction($pdo, $admin_id, 'admin', 'delete', 'announcements', $announcement_id, 'Deleted an announcement');
            echo "<script>
            window.location.href = '../admin.php?deleted=true';
                </script>";
        } else {
            logAction($pdo, $admin_id, 'admin', 'delete', 'announcements', $announcement_id, 'Failed to delete an announcement');
            echo "<script>
                alert('There was an error in deleting the announcement.');
                window.location.href = '../admin.php';
                </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = '../admin.php';
            </script>";
    }
} else {
    echo "<script>
        alert('No announcement ID provided.');
        window.location.href = '../admin.php';
        </script>";
}
