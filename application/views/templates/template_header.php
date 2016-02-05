<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="robots" content="index, follow">
        <meta name='rating' content='General'>
        <meta name="description" content="" >
        <meta name="keywords" content="">
        
        <link type="text/plain" rel="author" href="" />

        <META NAME="copyright" CONTENT="">
        <META NAME="revisit-after" CONTENT="10">
        <meta name="viewport" content="width=device-width, user-scalable=no" >

        <meta name="geo.region" content="AR" />
        <meta name="geo.placename" content="Buenos Aires" />
        <meta name="geo.position" content="-34.597725;-58.423321" />
        <meta name="ICBM" content="-34.597725, -58.423321" />

        <title>Integrapp | HOME </title>

        <link rel="icon" href="<?php echo base_url(); ?>Resources/img/favicon.png" type="image/x-icon">


        <link href="<?php echo base_url(); ?>Resources/styles/animate.css" rel="stylesheet">
         
        <link href="<?php echo base_url(); ?>Resources/fontawesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>Resources/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>Resources/bootstrap/css/sb-admin.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>Resources/styles/dropzone.css" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>Resources/styles/main_style.css" rel="stylesheet">

        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/scripts/modernizr.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/scripts/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/scripts/dropzone.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/scripts/typeahead.bundle.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>Resources/scripts/main_script.js"></script>     

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <?php if (isset($googleMapsScripts)) $this->load->view('templates/scripts/google_maps_scripts');?>
        <?php if (isset($locatePointsScripts)) $this->load->view('templates/scripts/locate_points_scripts');?>
        <?php if (isset($tableScripts)) $this->load->view('templates/scripts/table_scripts'); ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-70129314-1', 'auto');
          ga('send', 'pageview');

        </script>
    </head>
    