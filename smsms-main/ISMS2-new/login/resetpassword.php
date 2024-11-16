<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="login.css">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- jquery library -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="form_validation.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <section class="header_container bg-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col-3 d-flex justify-content-center align-items-center">
                    <img src="pics/bsu_logo.png" alt="" class="img-fluid me-3">
                </div>
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <h1 class="text-center">ANNOUNCEMENTS</h1>
                </div>
                <div class="col-3 d-flex justify-content-center align-items-center">
                    <img src="pics/bsu_logo.png" alt="" class="img-fluid ms-3">
                </div>
            </div>
        </div>
    </section>

    <section class="login_container d-flex justify-content-center align-items-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <h2 class="fw-bold">Reset Password</h2>
                                <p class="text-muted mb-0">Please enter your new password</p>
                            </div>

                            <form id="new_password_form" method="POST" action="update_password.php">
                                <?php if (isset($_GET['message'])): ?>
                                    <div class="alert alert-danger py-2"><?php echo $_GET['message']; ?></div>
                                <?php endif; ?>

                                <div class="form-floating mt-3">
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control"
                                        placeholder="name@example.com"
                                        value="<?php echo htmlspecialchars($_GET['email']); ?>"
                                        readonly>
                                    <label for="email">Email address</label>
                                </div>

                                <div class="form-floating mt-3 position-relative">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Password"
                                        required>
                                    <label for="password">New Password</label>
                                    <i class="fas fa-eye position-absolute end-0 top-50 translate-middle-y me-3"
                                        id="togglePassword" style="cursor: pointer;"></i>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="text-muted small mt-2">
                                    *Password is case sensitive
                                </div>

                                <input type="hidden" name="type" value="<?php echo htmlspecialchars($_GET['type']); ?>">

                                <button type="submit" class="btn btn-danger w-100 py-2 mt-3">
                                    Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-black py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-8">
                    <h2 class="h5 text-white mb-2">BATANGAS STATE UNIVERSITY</h2>
                    <p class="text-white-50 mb-2">A premier national university that develops leaders in the global knowledge economy</p>
                    <p class="text-white-50 small mb-0">Copyright &copy; <?php echo date('Y'); ?></p>
                </div>
                <div class="col-4">
                    <div class="text-end">
                        <img
                            src="pics/redspartan-logo.png"
                            alt="Red Spartan Logo"
                            class="img-fluid"
                            width="150"
                            height="auto">
                    </div>
                </div>
            </div>
        </div>
    </footer>
    </div>
    <script src="password.js"></script>
    <script src="form_validation.js"></script>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>