<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description"
		content="Streamline your business with our advanced CRM template. Easily integrate and customize to manage sales, support, and customer interactions efficiently. Perfect for any business size">
	<meta name="keywords"
		content="Advanced CRM template, customer relationship management, business CRM, sales optimization, customer support software, CRM integration, customizable CRM, business tools, enterprise CRM solutions">
	<meta name="author" content="Dreams Technologies">
	<meta name="robots" content="index, follow">

    <!-- SITE TITLE -->
    <title>
        <?php echo isset($brand_name)? $brand_name : 'DECCAN CLAP' ?>
    </title>

    <!--Header-->
    <?php isset($header) ? include($header) : '' ?>

</head>

<body class="header-top-bgcolor">

    <!-- loader Start -->
   <!-- <div class="preloader">
        <span class=""><img src="<?php //echo base_url('assets/img/logo/cctv.gif'); ?>" width="100" alt=""></span>
    </div>-->
        <!--Sidebar-->
        <?php (isset($sidebar)) ? include($sidebar) : ''; ?>

        <!--Top Navigation-->
        <?php (isset($top_navi)) ? include($top_navi) : ''; ?>

        <!--Content-->
        <?php (isset($content)) ? include($content) : ''; ?>
        

    <!--Footer-->
    <?php (isset($footer)) ? include($footer) : ''; ?>

</body>

</html>