<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include '../cdn/head.html'; ?>

    <script src="form_validation.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="header_container bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-3">
                    <a href="#" class="d-block">
                        <img
                            src="pics/brand.png"
                            alt="Brand Logo"
                            class="img-fluid"
                            width="150"
                            height="auto">
                    </a>
                </div>
                <div class="col-6">
                    <h1 class="text-center fw-bold m-0">ISMS ANNOUNCEMENTS</h1>
                </div>
                <div class="col-3 text-end">
                    <a href="#" class="d-block">
                        <img
                            src="pics/bsu_logo.png"
                            alt="BSU Logo"
                            class="img-fluid"
                            width="150"
                            height="auto">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section class="login_container d-flex justify-content-center align-items-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4"> <!-- Changed from p-5 to p-4 -->
                            <div class="text-center mb-3"> <!-- Changed from mb-4 to mb-3 -->
                                <h2 class="fw-bold">Welcome Back</h2>
                                <p class="text-muted mb-0">Please enter your credentials</p>
                            </div>

                            <form id="login_form" action="login_script.php" method="POST">
                                <?php if (isset($_GET['message'])): ?>
                                    <div class="alert alert-danger py-2"><?php echo $_GET['message']; ?></div>
                                    <script>
                                        $(document).ready(function() {
                                            setTimeout(function() {
                                                $(".alert").fadeOut('slow');
                                            }, 3000);
                                        });
                                    </script>
                                <?php endif; ?>

                                <div class="form-floating mt-3"> <!-- Kept mt-3 -->
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        class="form-control"
                                        placeholder="name@example.com"
                                        required>
                                    <label for="email">Email address</label>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-floating mt-3 position-relative">
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="form-control"
                                        placeholder="Password"
                                        required>
                                    <label for="password">Password</label>
                                    <i class="fas fa-eye position-absolute end-0 top-50 translate-middle-y me-3"
                                        id="togglePassword" style="cursor: pointer;"></i>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="small text-muted mt-3">
                                    *Password is case sensitive
                                </div>

                                <div class="d-flex justify-content-center mt-3">
                                    <div class="g-recaptcha" data-sitekey="6LfgN1kqAAAAAFS00KZj9_LgtXht8ISAUQgzU_YH"></div>
                                </div>

                                <button id="signin" type="submit" class="btn btn-danger w-100 py-2 mt-3">
                                    Sign in
                                </button>

                                <div class="text-center mt-3">
                                    <a href="#" id="resetPasswordBtn" class="text-decoration-none text-danger"
                                        data-bs-toggle="modal" data-bs-target="#otp-modal">
                                        Forgot Password?
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Structure -->
    <div id="resetPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Reset Password</h2>
            <form method="POST" action="send_otp.php">
                <label for="email">Enter your email:</label>
                <input type="email" name="email" required>
                <div class="button_container d-flex justify-content-center">
                    <button type="submit" class="btn btn-warning px-4 mb-2">Send OTP</button>
                </div>
            </form>
        </div>
    </div>

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

    <!-- otp modal -->
    <div class="modal fade" id="otp-modal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 px-2">
                    <h5 class="modal-title fw-bold" id="otpModalLabel">
                        <i class="fas fa-key me-2 text-danger"></i>Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 pb-4">
                    <p class="text-muted mb-4">Enter your email address and we'll send you an OTP to reset your password.</p>

                    <form method="POST" action="send_otp.php" id="otpForm">
                        <div class="form-floating">
                            <input
                                type="email"
                                name="email"
                                id="resetEmail"
                                class="form-control"
                                placeholder="name@example.com"
                                required>
                            <label for="resetEmail">Email address</label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-danger py-2">
                                <i class="fas fa-paper-plane me-2"></i>Send OTP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- recaptcha modal -->
    <div class="modal recaptcha-modal fade" id="recaptchaModal" tabindex="-1" aria-labelledby="recaptchaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <div class="mb-3">
                        <span class="text-danger fs-1">&#10060;</span>
                    </div>
                    <h5 class="modal-title mb-2" id="recaptchaModalLabel">Error</h5>
                    <p>Please Complete the Recaptcha First.</p>
                    <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="password.js"></script>
    <script src="form_validation.js"></script>
    <?php include '../cdn/body.html'; ?>
</body>

</html>