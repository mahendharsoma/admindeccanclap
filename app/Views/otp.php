<!-- Main Wrapper -->
<div class="main-wrapper">

    <div class="account-content">
        <div class="d-flex flex-wrap w-100 vh-100 overflow-hidden ">
            <div
                class="d-flex align-items-center justify-content-center flex-wrap vh-100 overflow-auto p-4 w-100 bg-backdrop">
                <div class="mx-auto mw-450">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-6 mb-4 w-50">
                            <img src="<?php echo base_url('assets/img/logo/cyberabad_police_logo.png') ?>" class="img-fluid" alt="Logo">
                        </div>
                        <div class="col-6 mb-4 w-50">
                            <img src="<?php echo base_url('assets/img/logo/scsc.png') ?>" class="img-fluid" alt="Logo">
                        </div>
                    </div>
                    <?= $this->include('nav/flash_message_view') ?>
                    <div class="mb-4">
                        <h4 class="mb-2 fs-20 text-center">Mobile Verification</h4>
                        <p>Enter your Mobile Number to access admin panel.</p>
                        <a href="<?php echo base_url('otp_generate');?>" id="opt_generate_url" style="display:none"></a>
                        <a href="<?php echo base_url('otp_submit');?>" id="opt_verifcation_url" style="display:none"></a>
                    </div>
                    <form id="mobileForm" method="post">
                        <div class="form-group" id="mobileInputGroup">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" class="form-control mb-0" name="mobile_number" id="mobile_number" placeholder="Enter mobile number" required>
                        </div>

                        <div class="form-group d-none" id="otpInputGroup">
                            <label for="otp">Enter OTP</label>
                            <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP" required>
                        </div>

                        <div class="d-inline-block w-100 mt-3 mb-3">
                            <button type="button" id="sendOtpBtn" class="btn btn-primary float-right w-100">Send OTP</button>
                            <button type="button" id="verifyOtpBtn" class="btn btn-success float-right w-100 d-none">Verify OTP</button>
                        </div>
                    </form>
                    <!-- <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-check form-check-md d-flex align-items-center">
                            <input class="form-check-input" type="checkbox" value="" id="checkebox-md"
                                checked="">
                            <label class="form-check-label" for="checkebox-md">
                                Remember Me
                            </label>
                        </div>
                        <div class="text-end">
                            <a href="forgot-password.html" class="text-primary fw-medium link-hover">Forgot
                                Password?</a>
                        </div>
                    </div> -->
                    
                    <!-- <div class="form-set-login or-text mb-3">
                        <h4>OR</h4>
                    </div>
                    <div class="mb-3">
                        <h6>New on our platform?<a href="register.html" class="text-purple link-hover"> Create
                                an account</a></h6>
                    </div> -->
                    <!-- <div class="d-flex align-items-center justify-content-center flex-wrap mb-3">
                        <div class="text-center me-2 flex-fill">
                            <a href="javascript:void(0);"
                                class="br-10 p-2 px-4 btn bg-pending  d-flex align-items-center justify-content-center">
                                <img class="img-fluid m-1" src="assets/img/icons/facebook-logo.svg"
                                    alt="Facebook">
                            </a>
                        </div>
                        <div class="text-center me-2 flex-fill">
                            <a href="javascript:void(0);"
                                class="br-10 p-2 px-4 btn bg-white d-flex align-items-center justify-content-center">
                                <img class="img-fluid  m-1" src="assets/img/icons/google-logo.svg"
                                    alt="Facebook">
                            </a>
                        </div>
                        <div class="text-center flex-fill">
                            <a href="javascript:void(0);"
                                class="bg-dark br-10 p-2 px-4 btn btn-dark d-flex align-items-center justify-content-center">
                                <img class="img-fluid  m-1" src="assets/img/icons/apple-logo.svg" alt="Apple">
                            </a>
                        </div>
                    </div> -->
                    <div class="text-center">
                        <p class="fw-medium text-gray">Copyright &copy; 2025 - Inrisoft Pvt Ltd.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /Main Wrapper -->