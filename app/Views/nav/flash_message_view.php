<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <?php
        if (isset($errors)){

            foreach ($errors as $error) {
                echo '<div class="alert text-white bg-danger" role="alert">
                              <div class="iq-alert-icon">
                                 <i class="ri-information-line"></i>
                              </div>
                              <div class="iq-alert-text">'.$error.'</div>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <i class="ri-close-line"></i>
                              </button>
                           </div>';
            }
        }
        ?>


        <?php echo !empty($session->getFlashdata('message')) ? $session->getFlashdata('message') : ''; ?>
    </div>
</div>

<!-- Wrapping element -->
<div id="toast_message" style="position: fixed; z-index: 999999; min-width: 500px; rigth:10px;">

</div>

<div id="process_toast_message_div" style="position: fixed; z-index: 99999; min-width: 500px; right: 1px;0px;">
    <div style="position: absolute; top: 0; right: 0;">
        <div id="processing_toast_message" class="toast hide" data-delay="3000">
            <div class="col-xl-12">
                <div class="alert alert-secondary overflow-hidden p-0" role="alert">
                    <div
                        class="p-3 bg-secondary text-fixed-white d-flex justify-content-between">
                        <h6 class="aletr-heading mb-0 text-fixed-white">Request Processing!</h6>
                        <button type="button" class="btn-close p-0 text-fixed-white"
                            data-bs-dismiss="alert" aria-label="Close"><i
                                class="fas fa-xmark"></i></button>
                    </div>
                    <hr class="my-0">
                    <div class="p-3">
                        we are processing your request Please wait...
                        <img src="<?php echo base_url('/assets/img/spinner.gif')?>" height="20" width="20">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>