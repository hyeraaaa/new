<?php
require_once '../login/dbh.inc.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/login.php");
    exit();
}

//Get info from student session
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
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg bg-white text-black fixed-top mb-5">
        <div class="container-fluid">
            <div class="user-left d-flex">
                <div class="d-md-none ms-0 mt-2 me-3">
                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <a class="navbar-brand d-flex align-items-center" href="#"><img src="img/brand.png" class="img-fluid branding" alt=""></a>
            </div>

            <div class="search-container mb-4">
                <form id="searchForm" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Search announcements..." />
                    <button type="submit" class="btn btn-primary ms-2">Search</button>
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
    </header>
    
    <main>
        <div class="container-fluid pt-5">
            <div class="row g-4">
                <!-- Right sidebar with filters -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="sticky-sidebar pt-5">
                        <div class="filter">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-center card-title">Announcements Filter</h5>
                                    <form class="filtered_option d-flex flex-column" id="filterForm">
                                        <label>Choose Department</label>
                                        <div class="checkbox-group mb-3">
                                            <label><input type="checkbox" name="department_filter[]" value="CICS"> CICS</label><br>
                                            <label><input type="checkbox" name="department_filter[]" value="CABE"> CABE</label><br>
                                            <label><input type="checkbox" name="department_filter[]" value="CAS"> CAS</label><br>
                                            <label><input type="checkbox" name="department_filter[]" value="CIT"> CIT</label><br>
                                            <label><input type="checkbox" name="department_filter[]" value="CTE"> CTE</label><br>
                                            <label><input type="checkbox" name="department_filter[]" value="CE"> CE</label><br>
                                        </div>

                                        <label>Select Year Level</label>
                                        <div class="checkbox-group mb-3">
                                            <label><input type="checkbox" name="year_level[]" value="1st Year"> 1st Year</label><br>
                                            <label><input type="checkbox" name="year_level[]" value="2nd Year"> 2nd Year</label><br>
                                            <label><input type="checkbox" name="year_level[]" value="3rd Year"> 3rd Year</label><br>
                                            <label><input type="checkbox" name="year_level[]" value="4th Year"> 4th Year</label><br>
                                        </div>

                                        <label>Courses</label>
                                        <div class="checkbox-group">
                                            <label><input type="checkbox" id="BSBA" name="course[]" value="BSBA" <?php if (in_array('BSBA', $selected_courses)) echo 'checked'; ?>>Bachelor of Science in Business Accounting</label>
                                            <label><input type="checkbox" id="BSMA" name="course[]" value="BSMA" <?php if (in_array('BSMA', $selected_courses)) echo 'checked'; ?>>Bachelor of Science in Management Accounting</label>
                                            <label><input type="checkbox" id="BSP" name="course[]" value="BSP" <?php if (in_array('BSP', $selected_courses)) echo 'checked'; ?>>Bachelor of Science in Psychology</label>
                                            <label><input type="checkbox" id="BAC" name="course[]" value="BAC" <?php if (in_array('BAC', $selected_courses)) echo 'checked'; ?>>Bachelor of Arts in Communication</label>
                                            <label><input type="checkbox" id="BSIE" name="course[]" value="BSIE" <?php if (in_array('BSIE', $selected_courses)) echo 'checked'; ?>>Bachelor of Science in Industrial Engineering</label>
                                            <label><input type="checkbox" id="BSIT-CE" name="course[]" value="BSIT-CE" <?php if (in_array('BSIT-CE', $selected_courses)) echo 'checked'; ?>>Bachelor of Industrial Technology - Computer Technology</label>
                                            <label><input type="checkbox" id="BSIT-Electrical" name="course[]" value="BSIT-Electrical" <?php if (in_array('BSIT-Electrical', $selected_courses)) echo 'checked'; ?>>Bachelor of Industrial Technology - Electrical Technology</label>
                                            <label><input type="checkbox" id="BSIT-Electronic" name="course[]" value="BSIT-Electronic" <?php if (in_array('BSIT-Electronic', $selected_courses)) echo 'checked'; ?>>Bachelor of Industrial Technology - Electronics Technology</label>
                                            <label><input type="checkbox" id="BSIT-ICT" name="course[]" value="BSIT-ICT" <?php if (in_array('BSIT-ICT', $selected_courses)) echo 'checked'; ?>>Bachelor of Industrial Technology - Instrumentation and Control Technology</label>
                                            <label><input type="checkbox" id="BSIT" name="course[]" value="BSIT" <?php if (in_array('BSIT', $selected_courses)) echo 'checked'; ?>>Bachelor of Science in Information Technology</label>
                                            <label><input type="checkbox" id="BSE" name="course[]" value="BSE" <?php if (in_array('BSE', $selected_courses)) echo 'checked'; ?>>Bachelor of Secondary Education</label>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                                            <button type="reset" class="btn btn-secondary">Clear Filters</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <div class="col-md-6 main-content pt-5 px-5">
                    <div class="feed-container">
                        <div id="loading" style="display: none;" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <?php include 'filter_announcements.php'; ?>
                    </div>
                </div>

                
            </div>
        </div>
    </main>

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
    <script src="user.js"></script>

    <?php include '../cdn/body.html'; ?>
</body>
</html>