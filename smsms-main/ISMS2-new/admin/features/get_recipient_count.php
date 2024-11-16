<?php
require_once '../../login/dbh.inc.php'; // Adjust this path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $yearLevels = $_POST['year_levels'] ?? [];
    $departments = $_POST['departments'] ?? [];
    $courses = $_POST['courses'] ?? [];

    // Construct the query
    $query = "SELECT COUNT(DISTINCT s.student_id) as count
              FROM student s
              WHERE s.year_level_id IN (SELECT year_level_id FROM year_level WHERE year_level IN (" . implode(',', array_fill(0, count($yearLevels), '?')) . "))
              AND s.department_id IN (SELECT department_id FROM department WHERE department_name IN (" . implode(',', array_fill(0, count($departments), '?')) . "))
              AND s.course_id IN (SELECT course_id FROM course WHERE course_name IN (" . implode(',', array_fill(0, count($courses), '?')) . "))";

    $stmt = $pdo->prepare($query);
    $params = array_merge($yearLevels, $departments, $courses);
    $stmt->execute($params);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $result['count'];
}