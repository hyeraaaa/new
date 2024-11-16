<?php
require_once '../login/dbh.inc.php'; // DATABASE CONNECTION
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/login.php");
    exit();
}

//Get info from student session
$user = $_SESSION['user'];
$student_id = $_SESSION['user']['student_id'];
$first_name = $_SESSION['user']['first_name'];
$last_name = $_SESSION['user']['last_name'];
$email = $_SESSION['user']['email'];
$contact_number = $_SESSION['user']['contact_number'];
$department_id = $_SESSION['user']['department_id'];
$year = $_SESSION['user']['year_level_id'];
$course = $_SESSION['user']['course_id'];
?>


<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include '../cdn/head.html'; ?>

    <link rel="stylesheet" href="user.css">

</head>

<body>
    <header>
        <?php include '../cdn/navbar.php' ?>
    </header>
    <main>
        <div class="container-fluid pt-5">
            <div class="row g-4">
                <!-- left sidebar -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="sticky-sidebar pt-5">
                        <div class="filter">
                            <div class="card">
                                <div class="card-body">
                                    <div class="posts">
                                        <h5 class="text-center card-title">Announcements Filter</h5>
                                        <form class="filtered_option d-flex flex-column" action="">
                                            <label>Choose Department</label>
                                            <div class="checkbox-group mb-3">
                                                <label><input type="checkbox" name="department_filter" value="1"> CECS</label><br>
                                                <label><input type="checkbox" name="department_filter" value="2"> CABE</label><br>
                                                <label><input type="checkbox" name="department_filter" value="3"> CAS</label><br>
                                            </div>

                                            <label>Select Year Level</label>
                                            <div class="checkbox-group">
                                                <label><input type="checkbox" name="year_level" value="1"> 1st Year</label><br>
                                                <label><input type="checkbox" name="year_level" value="2"> 2nd Year</label><br>
                                                <label><input type="checkbox" name="year_level" value="3"> 3rd Year</label><br>
                                                <label><input type="checkbox" name="year_level" value="4"> 4th Year</label><br>

                                            </div>
                                            <button type="button" class="btn btn-primary mt-3">Filter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 main-content pt-5 px-5">
                    <div class="feed-container">
                        <?php
                        require_once '../login/dbh.inc.php';

                        try {
                            // Query to get the announcements along with the year level, department, and course
                            $query = "
                            SELECT a.*, ad.first_name, ad.last_name,
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
                            GROUP BY a.announcement_id, ad.first_name, ad.last_name
                            ORDER BY a.updated_at DESC";

                            $stmt = $pdo->prepare($query);
                            $stmt->execute();

                            $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($announcements) {
                                foreach ($announcements as $row) {
                                    $announcement_id = $row['announcement_id'];
                                    $title = $row['title'];
                                    $description = $row['description'];
                                    $image = $row['image'];
                                    $announcement_admin_id = $row['admin_id'];
                                    $admin_first_name = $row['first_name'];
                                    $admin_last_name = $row['last_name'];
                                    $admin_name =  $admin_first_name . ' ' . $admin_last_name;
                                    $updated_at = date('F d, Y', strtotime($row['updated_at']));
                                    $year_levels = !empty($row['year_levels']) ? explode(',', $row['year_levels']) : [''];
                                    $departments = !empty($row['departments']) ? explode(',', $row['departments']) : [''];
                                    $courses = !empty($row['courses']) ? explode(',', $row['courses']) : [''];
                        ?>

                                    <div class="card mb-3">
                                        <div class="profile-container d-flex px-3 pt-3">
                                            <div class="profile-pic">
                                                <img class="img-fluid" src="img/test pic.jpg" alt="">
                                            </div>
                                            <p class="ms-1 mt-1"><?php echo htmlspecialchars($admin_name); ?></p>
                                            <div class="dropdown ms-auto">
                                                <span id="dropdownMenuButton<?php echo $announcement_id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $announcement_id; ?>">
                                                    <li><a class="dropdown-item" href="edit_announcement.php?id=<?php echo $announcement_id; ?>">Edit</a></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deletePost"
                                                            data-announcement-id="<?php echo $announcement_id; ?>">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="image-container mx-3">
                                            <a href="uploads/<?php echo htmlspecialchars($image); ?>" data-lightbox="image-<?php echo $announcement_id; ?>" data-title="<?php echo htmlspecialchars($title); ?>">
                                                <img src="../admin/uploads/<?php echo htmlspecialchars($image); ?>" alt="Post Image" class="img-fluid">
                                            </a>
                                        </div>

                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5>
                                            <div class="card-text">
                                                <p class="mb-2"><?php echo htmlspecialchars($description); ?></p>

                                                Tags:
                                                <?php

                                                $all_tags = array_merge($year_levels, $departments, $courses);


                                                foreach ($all_tags as $tag) : ?>
                                                    <span class="badge rounded-pill bg-danger mb-2"><?php echo htmlspecialchars(trim($tag)); ?></span>
                                                <?php endforeach; ?>
                                            </div>

                                            <small>Updated at <?php echo htmlspecialchars($updated_at); ?></small>
                                        </div>
                                    </div>

                        <?php
                                }
                            } else {
                                echo '<p class="text-center">No announcements found.</p>';
                            }
                        } catch (PDOException $e) {
                            // Handle any errors that occur during query execution
                            echo "Error: " . $e->getMessage();
                        }
                        ?>

                    </div>
                </div>

                <!-- right sidebar -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="sticky-sidebar pt-5">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-2">Recent Posts</h5>
                                <div class="posts px-4">
                                    <div class="d-flex">
                                        <i class="bi bi-star me-2"></i> <span>JPCS Membership Fee</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- offcanvas sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasSidebarsLabel">
            <div class="offcanvas-header d-flex">
                <img class="img-fluid w-100" src="img/brand.png" alt="">
                <h5 class="offcanvas-title" id="offcanvasSidebarsLabel">ISMS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-2">
                <form class="d-flex mx-2 mb-3" role="search">
                    <!-- <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button style="border: none; background: none;"><i class="bi bi-search"></i></i></button> -->
                </form>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-2">Recent Posts</h5>
                    </div>
                    <div class="posts px-4">
                        <div class="d-flex">
                            <i class="bi bi-star me-2"></i> <span>JPCS Membership Fee</span>
                        </div>
                    </div>
                </div>

                <div class="filter">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center card-title">Announcements Filter</p>
                            <div class="d-flex justify-content-center">
                                <form class="filtered_option d-flex flex-column" action="">
                                    <label>Choose Department</label>
                                    <div class="checkbox-group mb-3">
                                        <label><input type="checkbox" name="department_filter" value="1"> CECS</label><br>
                                        <label><input type="checkbox" name="department_filter" value="2"> CABE</label><br>
                                        <label><input type="checkbox" name="department_filter" value="3"> CAS</label><br>
                                    </div>

                                    <label>Select Year Level</label>
                                    <div class="checkbox-group">
                                        <label><input type="checkbox" name="year_level" value="1"> 1st Year</label><br>
                                        <label><input type="checkbox" name="year_level" value="2"> 2nd Year</label><br>
                                        <label><input type="checkbox" name="year_level" value="3"> 3rd Year</label><br>
                                        <label><input type="checkbox" name="year_level" value="4"> 4th Year</label><br>

                                    </div>
                                    <button class="btn btn-primary mt-3">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="user.js"></script>
    <footer>

    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <?php include '../cdn/body.html'; ?>
</body>

</html>