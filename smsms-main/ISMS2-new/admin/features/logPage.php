<?php
require_once '../../login/dbh.inc.php'; // DATABASE CONNECTION
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../../login/login.php");
    exit();
}

//Get info from admin session
$user = $_SESSION['user'];
$admin_id = $_SESSION['user']['admin_id'];
$first_name = $_SESSION['user']['first_name'];
$last_name = $_SESSION['user']['last_name'];
$email = $_SESSION['user']['email'];
$contact_number = $_SESSION['user']['contact_number'];
$department_id = $_SESSION['user']['department_id'];
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- head CDN links -->
    <?php include '../../cdn/head.html'; ?>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/tables.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>
    <header>
        <?php include '../../cdn/navbar.php'; ?>
        <nav class="navbar nav-bottom fixed-bottom d-block d-md-none mt-5">
            <div class="container-fluid justify-content-around">
                <a href="../admin.php" class="btn nav-bottom-btn">
                    <i class="bi bi-house"></i>
                    <span class="icon-label">Home</span>
                </a>

                <a class="btn nav-bottom-btn" href="manage.php">
                    <i class="bi bi-kanban"></i>
                    <span class="icon-label">Manage</span>
                </a>

                <a class="btn nav-bottom-btn" href="create.php">
                    <i class="bi bi-megaphone"></i>
                    <span class="icon-label">Create</span>
                </a>

                <a class="btn nav-bottom-btn active" href="logPage.php">
                    <i class="bi bi-clipboard"></i>
                    <span class="icon-label">Logs</span>
                </a>

                <a class="btn nav-bottom-btn" href="manage_student.php">
                    <i class="bi bi-person-plus"></i>
                    <span class="icon-label">Students</span>
                </a>

            </div>
        </nav>
    </header>
    <main>
        <div class="container-fluid pt-5">
            <div class="row g-4">
                <!-- left sidebar -->
                <div class="col-lg-2 sidebar sidebar-left d-none d-lg-block" id="sidebar">
                    <div class="sticky-sidebar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="dashboard.php">
                                    <i class="fas fa-chart-line me-2"></i>
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="../admin.php">
                                    <i class="fas fa-newspaper me-2"></i>
                                    <span class="menu-text">Feed</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="manage.php">
                                    <i class="fas fa-user me-2"></i>
                                    <span class="menu-text">My Profile</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="create.php">
                                    <i class="fas fa-bullhorn me-2"></i>
                                    <span class="menu-text">Create Announcement</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="active" href="logPage.php">
                                    <i class="fas fa-clipboard-list me-2"></i>
                                    <span class="menu-text">Logs</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="manage_student.php">
                                    <i class="fas fa-users-cog me-2"></i>
                                    <span class="menu-text">Manage Accounts</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- main content -->
                <div class="col-md-10 main-content pt-5 px-5">
                    <h3 class="text-left mb-4"><b>Admin Logs</b></h3>

                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive log-table">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="bg-primary text-white">
                                            <th class="align-middle">Log ID</th>
                                            <th class="align-middle">User ID</th>
                                            <th class="align-middle">User Type</th>
                                            <th class="align-middle">Action</th>
                                            <th class="align-middle">Affected Table</th>
                                            <th class="align-middle">Affected Record ID</th>
                                            <th class="align-middle">Description</th>
                                            <th class="align-middle">Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once '../../login/dbh.inc.php';

                                        try {
                                            $query = "SELECT * FROM logs ORDER BY timestamp DESC";
                                            $stmt = $pdo->query($query);

                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $log_id = htmlspecialchars($row['log_id'] ?? '');
                                                $user_id = htmlspecialchars($row['user_id'] ?? '');
                                                $user_type = strtoupper(htmlspecialchars($row['user_type'] ?? ''));
                                                $action = strtoupper(htmlspecialchars($row['action'] ?? ''));
                                                $affected_table = htmlspecialchars($row['affected_table'] ?? '');
                                                $affected_record_id = htmlspecialchars($row['affected_record_id'] ?? '');
                                                $description = htmlspecialchars($row['description'] ?? '');
                                                $timestamp = htmlspecialchars($row['timestamp'] ?? '');
                                        ?>
                                                <tr>
                                                    <td class="align-middle"><?= $log_id ?></td>
                                                    <td class="align-middle"><?= $user_id ?></td>
                                                    <td class="align-middle">
                                                        <span class="badge bg-info text-dark"><?= $user_type ?></span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="badge <?= getActionBadgeClass($action) ?>"><?= $action ?></span>
                                                    </td>
                                                    <td class="align-middle"><?= $affected_table ?></td>
                                                    <td class="align-middle"><?= $affected_record_id ?></td>
                                                    <td class="align-middle"><?= $description ?></td>
                                                    <td class="align-middle"><?= formatTimestamp($timestamp) ?></td>
                                                </tr>
                                        <?php
                                            }
                                        } catch (PDOException $e) {
                                            echo '<tr><td colspan="8" class="text-center text-danger">Error fetching logs: ' . $e->getMessage() . '</td></tr>';
                                        }

                                        function getActionBadgeClass($action)
                                        {
                                            switch (strtolower($action)) {
                                                case 'create':
                                                    return 'bg-success';
                                                case 'update':
                                                    return 'bg-warning text-dark';
                                                case 'delete':
                                                    return 'bg-danger';
                                                default:
                                                    return 'bg-secondary';
                                            }
                                        }

                                        function formatTimestamp($timestamp)
                                        {
                                            return date('M d, Y h:i A', strtotime($timestamp));
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>>
                <script src="../js/create.js"></script>
            </div>
        </div>
    </main>
    <!-- Body CDN links -->
    <?php include '../../cdn/body.html'; ?>
</body>

</html>