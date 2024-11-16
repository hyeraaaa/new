<?php
require_once '../login/dbh.inc.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/login.php");
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

// Initialize filter arrays
$selected_departments = [];
$selected_year_levels = [];
$selected_courses = [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ISMS Portal</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include '../cdn/head.html'; ?>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/modals.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/feeds-card.css">
    <link rel="stylesheet" href="../admin/css/bsu-bg.css">
    <link rel="stylesheet" href="css/filter-modal.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-white text-black fixed-top mb-5" style="border-bottom: 1px solid #e9ecef; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <div class="container-fluid">
                <div class="user-left d-flex">
                    <div class="d-md-none ms-0 mt-2 me-3">
                        <button type="button" class="btn btn-filter" data-bs-toggle="modal" data-bs-target="#filterModal"
                            style="border-radius: 50%; outline: none !important; box-shadow: none !important; border: none !important;"
                            onmousedown="this.style.outline='none'"
                            onfocus="this.style.outline='none'">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>

                    <a class="navbar-brand d-flex align-items-center" href="#"><img src="img/brand.png" class="img-fluid branding" alt=""></a>
                </div>

                <div class="search-container">
                    <form id="searchForm" class="d-flex align-items-center gap-2">
                        <!-- Filter Button -->
                        <button type="button" class="btn btn-light filter-btn" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-funnel"></i>
                        </button>

                        <!-- Search Input Group -->
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text"
                                name="search"
                                class="form-control border-start-0 ps-0"
                                placeholder="Search announcements..."
                                aria-label="Search announcements">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2 d-none d-md-inline"></i>Search
                            </button>
                        </div>
                    </form>
                </div>

                <div class="user-right d-flex align-items-center justify-content-center">
                    <p class="username d-flex align-items-center m-0"><?php echo $first_name ?></p>
                    <div class="user-profile">
                        <div class="dropdown">
                            <button class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" style="border: none; background: none; padding: 0;">
                                <img class="img-fluid w-100" src="img/test pic.jpg" alt="">
                            </button>
                            <ul class="dropdown-menu mt-3" style="left: auto; right:1px;">
                                <li><a class="dropdown-item text-center" href="#">Settings</a></li>
                                <li><a class="dropdown-item text-center" onclick="alert('Logged Out Successfully')" href="../login/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        </nav>
        <nav class="navbar nav-bottom fixed-bottom d-block d-md-none mt-5">
            <div class="container-fluid justify-content-around">
                <a href="admin.php" class="btn nav-bottom-btn active">
                    <i class="bi bi-house"></i>
                    <span class="icon-label">Home</span>
                </a>

                <a class="btn nav-bottom-btn" href="features/manage.php">
                    <i class="bi bi-kanban"></i>
                    <span class="icon-label">Manage</span>
                </a>

                <a class="btn nav-bottom-btn" href="features/create.php">
                    <i class="bi bi-megaphone"></i>
                    <span class="icon-label">Create</span>
                </a>

                <a class="btn nav-bottom-btn" href="features/logPage.php">
                    <i class="bi bi-clipboard"></i>
                    <span class="icon-label">Logs</span>
                </a>

                <a class="btn nav-bottom-btn" href="features/manage_student.php">
                    <i class="bi bi-person-plus"></i>
                    <span class="icon-label">Students</span>
                </a>

            </div>
        </nav>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
    </header>

    <main>
        <div class="container-fluid pt-5">
            <div class="row g-4">
                <!-- Left sidebar -->
                <div class="col-lg-2 sidebar sidebar-left d-none d-lg-block">
                    <div class="sticky-sidebar">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href=""><i class="fas fa-chart-line me-2"></i>Dashboard</a>
                            </li>

                            <li class="nav-item">
                                <a class="active" href="admin.php"><i class="fas fa-newspaper me-2"></i>Feed</a>
                            </li>

                            <li class="nav-item">
                                <a href="features/manage.php"><i class="fas fa-user me-2"></i>My Profile</a>
                            </li>

                            <li class="nav-item">
                                <a href="features/create.php"><i class="fas fa-bullhorn me-2"></i>Create Announcement</a>
                            </li>

                            <li class="nav-item">
                                <a href="features/logPage.php"><i class="fas fa-clipboard-list me-2"></i>Logs</a>
                            </li>

                            <li class="nav-item">
                                <a href="features/manage_student.php"><i class="fas fa-users-cog me-2"></i>Manage Accounts</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Main content -->
                <div class="col-12 col-xxl-10 col-lg-8 main-content pt-4 px-5">
                    <div class="row g-0">
                        <div class="col-xxl-7 col-lg-12 feed-container mt-4">
                            <div id="loading" style="display: none;" class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <?php include 'filter_announcements.php'; ?>
                        </div>

                        <div class="col-lg-5 announcement-card d-none d-xxl-block">
                            <?php
                            require_once '../login/dbh.inc.php';

                            try {
                                $query = "SELECT a.*, b.first_name, b.last_name 
                                FROM announcement a 
                                JOIN admin b ON a.admin_id = b.admin_id 
                                ORDER BY a.updated_at DESC 
                                LIMIT 3";


                                $stmt = $pdo->prepare($query);
                                $stmt->execute();

                                $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                                <div class="sticky-recent-post mt-3">
                                    <div class="filter">
                                        <div class="card latest-card p-2">
                                            <div class="card-body">
                                                <p class="card-title mb-3">RECENT POSTS</p>
                                                <div class="posts">
                                                    <?php
                                                    if ($announcements) {
                                                        $announcementCount = count($announcements);
                                                        foreach ($announcements as $index => $row) {
                                                            $id = $row['announcement_id'];
                                                            $title = $row['title'];
                                                            $image = $row['image'];
                                                            $admin_first_name = $row['first_name'];
                                                            $admin_last_name = $row['last_name'];
                                                            $admin_name =  $admin_first_name . ' ' . $admin_last_name;
                                                    ?>
                                                            <div class="d-flex flex-column recent mb-2">
                                                                <div class="row">
                                                                    <div class="col-md-8 recent-profile-container">
                                                                        <div class="recent-container d-flex">
                                                                            <img class="profile-picture" src="../admin/img/test pic.jpg" alt="">
                                                                            <p class="mt-1 ms-2"><?php echo htmlspecialchars($admin_name) ?></p>
                                                                        </div>
                                                                        <div class="title-container mt-0">
                                                                            <a style="color:black; text-decoration: none;" href="try.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4 post-img">
                                                                        <div class="post-img-container">
                                                                            <img class="post-image" src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Post Image" class="img-fluid">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
                                                            // Only display <hr> if it's not the last announcement
                                                            if ($index < $announcementCount - 1) {
                                                                echo '<hr>';
                                                            }
                                                        }
                                                    } else {
                                                        echo '<p class="text-center">No announcements found.</p>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } catch (PDOException $e) {
                                // Handle any errors that occur during query execution
                                echo "Error: " . htmlspecialchars($e->getMessage());
                            }
                            ?>

                        </div>
                    </div>

                </div>


            </div>
        </div>


        <!-- The Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">
                            <i class="bi bi-funnel-fill me-2"></i>Announcements Filter
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="filtered_option" id="filterForm">
                            <!-- Department Section -->
                            <div class="filter-section">
                                <h6 class="filter-title">Choose Department</h6>
                                <div class="filter-options">
                                    <label class="filter-chip">
                                        <input type="checkbox" name="department_filter[]" value="CICS">
                                        <span>CICS</span>
                                    </label>
                                    <label class="filter-chip">
                                        <input type="checkbox" name="department_filter[]" value="CABE">
                                        <span>CABE</span>
                                    </label>
                                    <label class="filter-chip">
                                        <input type="checkbox" name="department_filter[]" value="CAS">
                                        <span>CAS</span>
                                    </label>
                                    <label class="filter-chip">
                                        <input type="checkbox" name="department_filter[]" value="CIT">
                                        <span>CIT</span>
                                    </label>
                                    <label class="filter-chip">
                                        <input type="checkbox" name="department_filter[]" value="CTE">
                                        <span>CTE</span>
                                    </label>
                                    <label class="filter-chip">
                                        <input type="checkbox" name="department_filter[]" value="CE">
                                        <span>CE</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Year Level Section -->
                            <div class="filter-section">
                                <h6 class="filter-title"> Select Year Level</h6>
                                <div class="filter-options">
                                    <label class="filter-chip">
                                        <input type="checkbox" name="year_level[]" value="1st Year">
                                        <span>1st Year</span>
                                    </label>
                                    <label class="filter-chip">
                                        <input type="checkbox" name="year_level[]" value="2nd Year">
                                        <span>2nd Year</span>
                                    </label>
                                    <label class="filter-chip">
                                        <input type="checkbox" name="year_level[]" value="3rd Year">
                                        <span>3rd Year</span>
                                    </label>
                                    <label class="filter-chip">
                                        <input type="checkbox" name="year_level[]" value="4th Year">
                                        <span>4th Year</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Courses Section -->
                            <div class="filter-section">
                                <h6 class="filter-title">Courses</h6>
                                <div class="filter-options">
                                    <label class="filter-chip" title="Bachelor of Science in Business Accounting">
                                        <input type="checkbox" name="course[]" value="BSBA" <?php if (in_array('BSBA', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSBA</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Science in Management Accounting">
                                        <input type="checkbox" name="course[]" value="BSMA" <?php if (in_array('BSMA', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSMA</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Science in Psychology">
                                        <input type="checkbox" name="course[]" value="BSP" <?php if (in_array('BSP', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSP</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Arts in Communication">
                                        <input type="checkbox" name="course[]" value="BAC" <?php if (in_array('BAC', $selected_courses)) echo 'checked'; ?>>
                                        <span>BAC</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Science in Industrial Engineering">
                                        <input type="checkbox" name="course[]" value="BSIE" <?php if (in_array('BSIE', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSIE</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Industrial Technology - Computer Technology">
                                        <input type="checkbox" name="course[]" value="BSIT-CE" <?php if (in_array('BSIT-CE', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSIT-CE</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Industrial Technology - Electrical Technology">
                                        <input type="checkbox" name="course[]" value="BSIT-Electrical" <?php if (in_array('BSIT-Electrical', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSIT-E</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Industrial Technology - Electronics Technology">
                                        <input type="checkbox" name="course[]" value="BSIT-Electronic" <?php if (in_array('BSIT-Electronic', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSIT-ET</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Industrial Technology - Instrumentation and Control Technology">
                                        <input type="checkbox" name="course[]" value="BSIT-ICT" <?php if (in_array('BSIT-ICT', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSIT-ICT</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Science in Information Technology">
                                        <input type="checkbox" name="course[]" value="BSIT" <?php if (in_array('BSIT', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSIT</span>
                                    </label>
                                    <label class="filter-chip" title="Bachelor of Secondary Education">
                                        <input type="checkbox" name="course[]" value="BSE" <?php if (in_array('BSE', $selected_courses)) echo 'checked'; ?>>
                                        <span>BSE</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" form="filterForm">
                            <i class="bi bi-x-circle me-2"></i>Clear Filters
                        </button>
                        <button type="submit" class="btn btn-primary" form="filterForm">
                            <i class="bi bi-check2-circle me-2"></i>Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/blur.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.querySelector('#filterForm');
            const searchForm = document.querySelector('#searchForm');
            const searchInput = searchForm.querySelector('input[name="search"]');
            const loadingIndicator = document.getElementById('loading');
            const feedContainer = document.querySelector('.feed-container');

            function fetchAnnouncements(form) {
                loadingIndicator.style.display = 'block';
                feedContainer.style.opacity = '0.5';

                const formData = new FormData(form);

                fetch('filter_announcements.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        feedContainer.innerHTML = data;
                        feedContainer.style.opacity = '1';
                        loadingIndicator.style.display = 'none';

                        applyBlurBackground();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingIndicator.style.display = 'none';
                        feedContainer.style.opacity = '1';
                    });
            }

            // Handle filter form submit
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                fetchAnnouncements(this);
            });

            // Handle search form submit
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                fetchAnnouncements(this);
            });

            // Handle reset button on filter form
            filterForm.addEventListener('reset', function(e) {
                setTimeout(() => {
                    searchInput.value = ''; // Clear the search input
                    fetchAnnouncements(filterForm);
                }, 10);
            });
        });
    </script>
    <script src="js/admin.js"></script>

    <?php include '../cdn/body.html'; ?>
</body>

</html>