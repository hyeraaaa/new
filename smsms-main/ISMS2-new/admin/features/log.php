<?php
// Function to log actions in the logs table
function logAction($pdo, $user_id, $user_type, $action, $affected_table, $affected_record_id = null, $description = '') {
    $query = "INSERT INTO logs (user_id, user_type, action, affected_table, affected_record_id, description) 
              VALUES (:user_id, :user_type, :action, :affected_table, :affected_record_id, :description)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':user_id' => $user_id,
        ':user_type' => $user_type,
        ':action' => $action,
        ':affected_table' => $affected_table,
        ':affected_record_id' => $affected_record_id,
        ':description' => $description
    ]);
}

// Existing function to log SMS status in the database
function logSmsStatus($pdo, $announcement_id, $student_id, $status) {
    $query = "INSERT INTO sms_log (announcement_id, student_id, status) VALUES (:announcement_id, :student_id, :status)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':announcement_id' => $announcement_id,
        ':student_id' => $student_id,
        ':status' => $status
    ]);
    // Log the SMS status action
    logAction($pdo, $student_id, 'student', 'SEND_SMS', 'sms_log', null, "SMS $status for announcement ID $announcement_id");
}
