<style>
    .image-border {
    border-left: 6px solid rgba(255,255,255,0.2);
    border-radius: 12px 0 0 12px;
}

</style>
<!-- Main Wrapper -->
<div class="main-wrapper">
    <div class="account-content">
        <div class="container-fluid">
            <div class="row vh-100">

                <!-- LEFT SIDE -->
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center p-4 bg-backdrop overflow-auto">
                    <form action="<?php echo base_url('/') ?>" method="post" class="flex-fill" style="max-width:450px;">
                        <div class="text-center mb-4 w-50 mx-auto">
                            <img src="assets/img/authentication/deccan_logo.png" class="img-fluid" alt="Logo">
                        </div>
                        <?= $this->include('nav/flash_message_view') ?>
                        <div class="mb-4">
                            <h4 class="mb-2 fs-20">Sign In</h4>
                            <p>Access the CRMS panel using your email and passcode.</p>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label">Email Address</label>
                            <div class="position-relative">
                                <span class="input-icon-addon"><i class="ti ti-mail"></i></span>
                                <input type="text" class="form-control" name="user_email">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label">Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" name="user_password">
                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                        </div>

                        <!-- <div class="d-flex justify-content-between mb-3">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" type="checkbox" checked>
                                <label class="form-check-label">Remember Me</label>
                            </div>
                            <a href="forgot-password.html" class="text-primary fw-medium">Forgot Password?</a>
                        </div> -->

                        <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>

                        <!-- <h6 class="text-center mb-3">
                            New on our platform?
                            <a href="register.html" class="text-purple">Create an account</a>
                        </h6> -->

                        <!-- <div class="or-text text-center mb-3"><h4>OR</h4></div> -->

                        <!-- <div class="d-flex gap-2 mb-3">
                            <a href="#" class="btn bg-pending flex-fill">
                                <img src="assets/img/icons/facebook-logo.svg" height="20">
                            </a>
                            <a href="#" class="btn bg-white flex-fill">
                                <img src="assets/img/icons/google-logo.svg" height="20">
                            </a>
                            <a href="#" class="btn btn-dark flex-fill">
                                <img src="assets/img/icons/apple-logo.svg" height="20">
                            </a>
                        </div> -->

                        <p class="text-center text-gray">&copy; 2025 - Deccan Clap</p>
                    </form>
                </div>

                <!-- RIGHT SIDE IMAGE (Hidden on mobile & tablet) -->
                <div class="col-lg-6 d-none d-lg-block account-bg-01 image-border">
                </div>

            </div>
        </div>
    </div>

</div>
