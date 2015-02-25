<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link rel="icon" href="favicon.ico">-->

    <title><?php echo $pageTitle;?></title>

    <!-- Bootflat CSS -->
    <link href="<?php echo base_url();?>public/bootflat/css/site.min.css" rel="stylesheet">

    <!-- Sweetalert CSS -->
    <link href="<?php echo base_url();?>public/sweetalert-master/lib/sweet-alert.css" rel="stylesheet">
    
    <!-- Generator CSS -->
    <link href="<?php echo base_url();?>public/css/generator.css" rel="stylesheet">

    <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery-1.11.1.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top navbar-custom" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
            <li>
              <a href="<?php echo site_url("generator");?>" title="Manage table">
                <strong>Home</strong>
              </a>
            </li>
            <li>
              <a href="<?php echo site_url("generator/manage");?>" title="Manage controller or table">
                <strong>Manage</strong>
              </a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong>Result</strong> <b class="caret"></b></a>
              <ul class="dropdown-menu" role="menu">
                <?php $this->load->view('layouts/partial/menu');?>
              </ul>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="http://nipstudio.com" target="_blank" title="About Nip Stdio.">
                <strong>Nip Stdio.</strong>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url()."user_guide/index.html";?>" title="Documentation">
                <strong>Help</strong>
              </a>
            </li>
            <?php if($this->session->userdata("user_id")):?>
            <li>
              <a href="<?php echo site_url("auth/logout");?>">
                <strong>Logout</strong>
              </a>
            </li>
            <?php endif;?>
          
          </ul>
        </div>
      </div>
    </div>

    
    <!--Content here..-->
    <?php echo $pageContent;?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url();?>public/bootflat/js/site.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/js/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/sweetalert-master/lib/sweet-alert.min.js"></script>
   
  </body>
</html>
