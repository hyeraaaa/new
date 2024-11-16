<nav class="navbar navbar-expand-lg bg-white text-black fixed-top" style="border-bottom: 1px solid #e9ecef; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
    <div class="container-fluid">
        <div class="user-left d-flex">
            <div class="d-md-none ms-0 mt-2 me-3">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <a class="navbar-brand d-flex align-items-center" href="#"><img src="../img/brand.png" class="img-fluid branding" alt=""></a>
        </div>

        <div class="user-right d-flex align-items-center justify-content-center">
            <p class="username d-flex align-items-center m-0"><?php echo $first_name ?></p>
            <div class="user-profile">
                <div class="dropdown">
                    <button class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" style="border: none; background: none; padding: 0;">
                        <img class="img-fluid w-100" src="../img/test pic.jpg" alt="">
                    </button>
                    <ul class="dropdown-menu mt-3" style="left: auto; right:1px;">
                        <li><a class="dropdown-item text-center" href="#">Settings</a></li>
                        <li><a class="dropdown-item text-center" onclick="alert('Logged Out Successfully')" href="../../login/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
</nav>