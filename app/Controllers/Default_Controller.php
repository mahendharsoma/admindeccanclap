<?php namespace App\Controllers;

class Default_Controller extends BaseController
{
    protected $helpers = [];
    protected $libraries = [];
    
    public function __construct()
    {
        helper(['url', 'form', 'deccan_helper','session']);
        $this->session = \Config\Services::session();
        
    }

    public function generateView($page, &$data, $include_navbar = true)
    {
        $data['header'] = 'header/header.php';

        if ($include_navbar)
        {
            $data['top_navi'] = 'nav/topnav.php';
            $data['sidebar'] = 'nav/sidenav.php';
        }

        $data['content'] = $page.'.php';
        $data['footer'] = 'footer/footer.php';
        $data['session'] = $this->session;
        return view('home', $data);
    }

    public function set_flash_error($message)
    {
        $message = '<div class="col-xl-12">
                        <div class="alert alert-primary overflow-hidden p-0" role="alert">
                            <div class="p-3 bg-primary text-fixed-white d-flex justify-content-between">
                                <h6 class="aletr-heading mb-0 text-fixed-white"><i class="fa-solid fa-circle-exclamation"></i> Alert!</h6>
                                <button type="button" class="btn-close p-0 text-fixed-white"
                                    data-bs-dismiss="alert" aria-label="Close"><i
                                        class="fas fa-xmark"></i></button>
                            </div>
                            <hr class="my-0">
                            <div class="p-3">
                                <p class="mb-0">'.$message.'</p>
                            </div>
                        </div>
                    </div>';

        $this->session->setFlashdata('message', $message);
    }

    public function set_flash_success($message)
    {
        $message = '<div class="col-xl-12">
                            <div class="alert alert-success overflow-hidden p-0" role="alert">
                                <div class="p-3 bg-success text-fixed-white d-flex justify-content-between">
                                    <h6 class="aletr-heading mb-0 text-fixed-white"><i class="fa-solid fa-circle-check"></i> Alert!</h6>
                                    <button type="button" class="btn-close p-0 text-fixed-white"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <i class="fas fa-xmark"></i>
                                    </button>
                                </div>
                                <hr class="my-0">
                                <div class="p-3">
                                    <p class="mb-0">'.$message.'</a></p>
                                </div>
                            </div>
                        </div>';

        $this->session->setFlashdata('message', $message);
    }

    function success_toast_message($messsage)
    {
        $message = '<div style="position: fixed; top: 20px; right: 10px; z-index: 1050;">
                        <div id="alert_toast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                            <div class="toast-header bg-success text-white border-0">
                                <i class="feather-check-circle me-2"></i>
                                <strong class="me-auto">Success Alert</strong>
                                <small class="text-light">Just now</small>
                                <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body text-dark">
                                <div class="fw-semibold mb-1">'.$messsage.'</div>
                            </div>
                        </div>
                    </div>
';

        return $message;
    }

    function failure_toast_message($messsage)
    {
        $temp_msg ='';
        if (is_array($messsage))
        {
            foreach ($messsage as $msg)
            {
                $temp_msg .= strip_tags($msg).'<br>';
            }
            $messsage = $temp_msg;
        }

        $final_message = '<div style="position: fixed; right: 10px;">
                                <div id="alert_toast" class="toast" data-delay="3000">
                                    <div class="toast-header bg-danger text-white border-0">
                                        <i class="feather-check-circle me-2"></i>
                                        <strong class="me-auto">Alert</strong>
                                        <small class="text-light">Just now</small>
                                        <button type="button" class="btn-close btn-close-white ms-2 mb-1" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    <div class="toast-body text-dark">
                                        <div class="fw-semibold mb-1">'.$messsage.'</div>
                                    </div>
                                </div>
                            </div>';

        return $final_message;
    }

    function ajax_success_response($message = SYSTEM_STATUS_MESSAGE_SUCCESS, $response_data = array(), $refresh_page = NO, $redirect_url = NULL)
    {
        $data['status_code'] = SYSTEM_STATUS_CODE_SUCCESS;
        $data['status_message'] = $this->success_toast_message($message);
        $data['response_data'] = $response_data;
        $data['refresh_page'] = $refresh_page;
        $data['redirect_url'] = $redirect_url;

        echo json_encode($data,JSON_PRETTY_PRINT);
    }

    function ajax_failure_response($message = SYSTEM_STATUS_MESSAGE_FAILURE, $response_data = array(), $refresh_page = YES, $redirect_url = NULL)
    {
        $data['status_code'] = SYSTEM_STATUS_CODE_FAILURE;
        $data['status_message'] = $this->failure_toast_message($message);
        $data['response_data'] = $response_data;
        $data['refresh_page'] = $refresh_page;
        $data['redirect_url'] = $redirect_url;

        echo json_encode($data,JSON_PRETTY_PRINT);
        return;
    }
    public function send_email($user_details,$order_id)
    {
        //   compose email and send
        $to = $user_details['user_email'];

        $message='';
        // To send HTML mail, the Content-type header must be set
        
        // Compose a simple HTML email message
        $message = '<html><body>';
        $message .= '<div style="text-align:center;">';
        $message .= '<h3 style="color:#000;text-align: left;margin:10px;padding:0px;">Shipping Confirmation</h3>';
        $message .= '<h3 style="color:#000;text-align: left;margin:10px;padding:0px;">Hi '.$user_details['user_name'].'</h3>';
        $message .= '<h5 style="color:#000;text-align: left;margin:10px;padding:0px;">We are happy to confirm that the following item(s) from your Gutcheck order '.$order_id.' has been shipped from St. John’s, Canada Your order is on its way and can no longer be changed.
        Standard Shipping applies to this order unless otherwise stated on the product page and please see your estimated arrival dates below.
         </h5>';
         $message .= '<h5 style="color:#000;text-align: left;margin:10px;padding:0px;">Here is tracking number that can be used to track your order: '.$order_id.'</h5>';
           
            $message .= '<h5 style="color:#000;text-align: left;margin:10px;padding:0px;">Please <a href="https://www.nucliqbio.ca/contact.html"><span style="color: #FF3E66 !important;">Contact our support team</span> </a>if you have any questions.</h5>';
            $message .= '<h5 style="color:#000;text-align: left;margin:10px;padding:0px;">Sincerely,</h5>';
            $message .= '<h5 style="color:#000;text-align: left;margin:10px;padding:0px;">Gutcheck Team</h5>';
           
           
        
        $message .= '</div></body></html>';

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $from = 'info@mygutcheck.ca';
        // Create email headers
        $header .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $subject='GutCheck: Your order '.$order_id.' has been shipped';
        
        
	   //    $retval = $this->send_email($to, $subject, $message, $header);
	   $retval = mail($to, $subject, $message, $header);
        // $retval = true;
        if ($retval== true) {
            log_message('error',__METHOD__.' email sent successfully');
        } else {
            log_message('error',__METHOD__.' could not send email, to: '.$to.', subject: '.print_r($subject,true).', message: '.print_r($message,true).', header: '.print_r($header,true));
        }


        return $retval ;
    }
    
    public function send_received_email($user_details, $barcode_details)
     {
        //   compose email and send
        $to = $user_details['user_email'];
        $barcode = $barcode_details['barcode'];
        //   $to = 'mahendharsoma@gmail.com';

        $message='';
        // To send HTML mail, the Content-type header must be set
        
        // Compose a simple HTML email message
         $message='
          <!DOCTYPE html>
            <html lang="en"> 
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    
                </head>
                <body>
                    <div class="section">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="text-center order_complete">
                                        <i class="fas fa-check-circle"></i>
                                        <div class="heading_s1">
                                            
                                            <h3>Dear '.$user_details['user_name'].'</h3>
                                        </div>
                                        
                                            <h5>We are writing to let you know that your sample (ID: '.$barcode.') has been received at our lab facility.</h5>
                                            <h5>We will send you an email notification once your sample is analyzed and the report is ready to view on your Gutcheck account. The turnaround time for the results is 4-6 weeks.</h5>
                                            <h5>We will keep you posted.</h5>
                                            <h5>Healthy gut, Healthy you.</h5>
                                            
                                            <h5>Thanks,
                                            
                                            <br>
                                            
                                            Gutcheck Team</h5>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>            
            </html>
        ';

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $from = 'info@mygutcheck.ca';
        // Create email headers
        $header .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $subject='Gutcheck - Sample received';
        
        
	   //    $retval = $this->send_email($to, $subject, $message, $header);
	   $retval = mail($to, $subject, $message, $header);
        // $retval = true;
        if ($retval== true) {
            log_message('error',__METHOD__.' email sent successfully');
        } else {
            log_message('error',__METHOD__.' could not send email, to: '.$to.', subject: '.print_r($subject,true).', message: '.print_r($message,true).', header: '.print_r($header,true));
        }


        return $retval ;   
     }

     public function send_report_generated_email($user_details, $barcode_details)
     {
        //   compose email and send
        $to = $user_details['user_email'];
        $barcode = $barcode_details['barcode'];
        //   $to = 'mahendharsoma@gmail.com';

        $message='';
        // To send HTML mail, the Content-type header must be set
        
        // Compose a simple HTML email message
         $message='
          <!DOCTYPE html>
            <html lang="en"> 
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    
                </head>
                <body>
                    <div class="section">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="text-center order_complete">
                                        <i class="fas fa-check-circle"></i>
                                        <div class="heading_s1">
                                            
                                            <h3>Dear '.$user_details['user_name'].'</h3>
                                        </div>
                                        
                                            <h5>We are excited to let you know that your Gutcheck report (ID: '.$barcode.') is ready. Please login to your Gutcheck account to view or download the results.</h5>
                                            <h5>Please let us know if you have any difficulty in viewing or downloading the PDF report.</h5>
                                            <h5>We are looking forward to hearing from you.</h5>
                                            <h5>Healthy gut, Healthy you.</h5>
                                            
                                            <h5>Thanks,
                                            
                                            <br>
                                            
                                            Gutcheck Team</h5>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>            
            </html>
        ';

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $from = 'info@mygutcheck.ca';
        // Create email headers
        $header .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $subject='Your Gutcheck Report is ready!';
        
        
	   //    $retval = $this->send_email($to, $subject, $message, $header);
	   $retval = mail($to, $subject, $message, $header);
        // $retval = true;
        if ($retval== true) {
            log_message('error',__METHOD__.' email sent successfully');
        } else {
            log_message('error',__METHOD__.' could not send email, to: '.$to.', subject: '.print_r($subject,true).', message: '.print_r($message,true).', header: '.print_r($header,true));
        }


        return $retval ;   
     }
     
     public function send_order_mail($user_details)
     {
        //   compose email and send
         $to = $user_details['user_email'];
    //   $to = 'mahendharsoma@gmail.com';

        $message='';
        // To send HTML mail, the Content-type header must be set
        
        // Compose a simple HTML email message
         $message='
          <!DOCTYPE html>
            <html lang="en"> 
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    
                </head>
                <body>
                    <div class="section">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="text-center order_complete">
                                        <i class="fas fa-check-circle"></i>
                                        <div class="heading_s1">
                                            
                                            <h3>Dear '.$user_details['user_name'].'</h3>
                                        </div>
                                        
                                            <h5>We have received your sample submission! You can track the progress of our scientific analysis here.</h5>
                                            <h5>You can expect to receive your results in approximately 4-6 weeks.</h5>
                                            <h5>Need help? <a href="https://www.nucliqbio.ca/contact.html"><span style="color: #FF3E66 !important;">Contact our support team</span></h5>
                                            
                                            <h5>Sincerely,
                                            
                                            <br>
                                            
                                            Gutcheck Team</h5>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>            
            </html>
        ';

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $from = 'info@mygutcheck.ca';
        // Create email headers
        $header .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $subject='Gutcheck status update: You are a step closer!';
        
        
	   //    $retval = $this->send_email($to, $subject, $message, $header);
	   $retval = mail($to, $subject, $message, $header);
        // $retval = true;
        if ($retval== true) {
            log_message('error',__METHOD__.' email sent successfully');
        } else {
            log_message('error',__METHOD__.' could not send email, to: '.$to.', subject: '.print_r($subject,true).', message: '.print_r($message,true).', header: '.print_r($header,true));
        }


        return $retval ;   
     }
     
     public function send_sample_collection_notification_email($user_details, $order_id)
     {
        //   compose email and send
         $to = $user_details['user_email'];
        //   $to = 'mahendharsoma@gmail.com';

        $message='';
        // To send HTML mail, the Content-type header must be set
        
        // Compose a simple HTML email message
         $message='
          <!DOCTYPE html>
            <html lang="en"> 
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body>
                    <div class="section">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="text-center order_complete">
                                        <i class="fas fa-check-circle"></i>
                                        <div class="heading_s1">
                                            <h3>Dear '.$user_details['user_name'].'</h3>
                                        </div>
                                        
                                            <h5>Thank you for your Gutcheck test purchase.</h5>
                                            <h5>You are receiving this email because our records indicate that you have not yet sent your stool sample to our laboratory.</h5>
                                            <h5>If you have any questions regarding how to use the stool collection kit or how to mail your collected sample to us, please do not hesitate to contact our team!</h5>
                                            <h5>Sample collection instructions video: <a href="https://mygutcheck.ca/videos"><span style="color: #FF3E66 !important;">https://mygutcheck.ca/videos</span> </a></h5>
                                            <h5>We are excited to be a part of your gut health journey!</h5>
                                            
                                            <h5>Thank you, <br/>
                                                Nucliq Bio
                                            </h5>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>            
            </html>
        ';

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $from = 'info@mygutcheck.ca';
        // Create email headers
        $header .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $subject='Sample Collection Reminder! (Gutcheck)';
        
        
	    // $retval = $this->send_email($to, $subject, $message, $header);
	    $retval = mail($to, $subject, $message, $header);
        // $retval = true;
        if ($retval== true) {
            log_message('error',__METHOD__.' email sent successfully');
        } else {
            log_message('error',__METHOD__.' could not send email, to: '.$to.', subject: '.print_r($subject,true).', message: '.print_r($message,true).', header: '.print_r($header,true));
        }


        return $retval ;   
     }
     
     public function send_activation_notification_email($user_details, $order_id)
     {
        //   compose email and send
         $to = $user_details['user_email'];

        $message='';
        // To send HTML mail, the Content-type header must be set
        
        // Compose a simple HTML email message
        $message='
          <!DOCTYPE html>
            <html lang="en"> 
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body>
                    <div class="section">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="text-center order_complete">
                                        <i class="fas fa-check-circle"></i>
                                        <div class="heading_s1">
                                            <h3>Dear '.$user_details['user_name'].'</h3>
                                        </div>
                                        
                                            <h5>We are writing to let you know that your Gutcheck test sample has been received at our lab facility.</h5>
                                            <h5>But we have noticed that you haven&#39;t activated your kit yet. Please check your instructions manual for kit activation or visit <a href="https://www.mygutcheck.ca"><span style="color: #FF3E66 !important;">www.mygutcheck.ca</span> </a> to activate your kit.</h5>
                                            <h5>Please let us know if you have any questions.</h5>

                                            <h5>
                                                Thank you, <br/>
                                                Gutcheck Team
                                            </h5>

                                            <h5>Healthy gut, Healthy you.</h5>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>            
            </html>
        ';

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $from = 'info@mygutcheck.ca';
        // Create email headers
        $header .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $subject='Activation Reminder!(Gutcheck)';
        
        
	    // $retval = $this->send_email($to, $subject, $message, $header);
	    $retval = mail($to, $subject, $message, $header);
        // $retval = true;
        if ($retval== true) {
            log_message('error',__METHOD__.' email sent successfully');
        } else {
            log_message('error',__METHOD__.' could not send email, to: '.$to.', subject: '.print_r($subject,true).', message: '.print_r($message,true).', header: '.print_r($header,true));
        }


        return $retval ;   
     }
}