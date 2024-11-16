<?php
require_once '../login/dbh.inc.php';
$admin_id = $_SESSION['user']['admin_id'] ?? null;

$filters = [];
$filterParams = [];

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

// Split the search term into individual words and add each word as a condition
if ($searchTerm !== '') {
    $searchWords = preg_split('/\s+/', $searchTerm); // Split by spaces into an array of words
    $searchConditions = [];

    foreach ($searchWords as $word) {
        $searchConditions[] = "(LOWER(a.title) LIKE ? OR LOWER(a.description) LIKE ?)";
        $filterParams[] = '%' . strtolower($word) . '%';
        $filterParams[] = '%' . strtolower($word) . '%';
    }

    // Join all individual word conditions with OR
    $filters[] = '(' . implode(' OR ', $searchConditions) . ')';
}

// Get filter values
$selected_departments = isset($_POST['department_filter']) ? $_POST['department_filter'] : [];
$selected_year_levels = isset($_POST['year_level']) ? $_POST['year_level'] : [];
$selected_courses = isset($_POST['course']) ? $_POST['course'] : [];

// Department filter
if (!empty($selected_departments)) {
    $placeholders = str_repeat('?,', count($selected_departments) - 1) . '?';
    $filters[] = "d.department_name IN ($placeholders)";
    $filterParams = array_merge($filterParams, $selected_departments);
}

// Year level filter
if (!empty($selected_year_levels)) {
    $placeholders = str_repeat('?,', count($selected_year_levels) - 1) . '?';
    $filters[] = "yl.year_level IN ($placeholders)";
    $filterParams = array_merge($filterParams, $selected_year_levels);
}

// Course filter
if (!empty($selected_courses)) {
    $placeholders = str_repeat('?,', count($selected_courses) - 1) . '?';
    $filters[] = "c.course_name IN ($placeholders)";
    $filterParams = array_merge($filterParams, $selected_courses);
}

// Combine filters into a WHERE clause
$whereClause = count($filters) > 0 ? "WHERE " . implode(" AND ", $filters) : '';

$query = "
    SELECT DISTINCT a.*, ad.first_name, ad.last_name,
        STRING_AGG(DISTINCT yl.year_level, ', ') AS year_levels,
        STRING_AGG(DISTINCT d.department_name, ', ') AS departments,
        STRING_AGG(DISTINCT c.course_name, ', ') AS courses
    FROM announcement a
    JOIN admin ad ON a.admin_id = ad.admin_id
    LEFT JOIN announcement_year_level ayl ON a.announcement_id = ayl.announcement_id
    LEFT JOIN year_level yl ON ayl.year_level_id = yl.year_level_id
    LEFT JOIN announcement_department adp ON a.announcement_id = adp.announcement_id
    LEFT JOIN department d ON adp.department_id = d.department_id
    LEFT JOIN announcement_course ac ON a.announcement_id = ac.announcement_id
    LEFT JOIN course c ON ac.course_id = c.course_id
    $whereClause
    GROUP BY a.announcement_id, ad.first_name, ad.last_name
    ORDER BY a.updated_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($filterParams);
$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display filtered results
if ($announcements) {
    foreach ($announcements as $row) {
        include 'announcement_card.php';
    }
} else {
    echo '<p class="text-center">No announcements found matching the selected filters.</p>';
}
