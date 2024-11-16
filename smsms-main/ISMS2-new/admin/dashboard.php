<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/modals.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/feeds-card.css">
    <link rel="stylesheet" href="css/filter-modal.css">
</head>

<body>


    <div class="analytics-section">
        <h5 class="analytics-title">Analytics</h5>

        <!-- Counters for Active Users -->
        <div>
            <p>Active Students: <span id="activeStudents"></span></p>
            <p>Active Admins: <span id="activeAdmins"></span></p>
        </div>

        <!-- Bar Charts -->
        <canvas id="departmentChart"></canvas>
        <canvas id="courseChart"></canvas>
        <canvas id="yearLevelChart"></canvas>

        <!-- Pie Chart for Admins -->
        <canvas id="adminChart"></canvas>

    </div>
</body>

</html>