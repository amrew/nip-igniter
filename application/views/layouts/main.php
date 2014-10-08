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

    <!-- Eternicode Datepicker CSS -->
    <link href="<?php echo base_url();?>public/eternicode-datepicker/css/datepicker.css" rel="stylesheet">

    <!-- Animate css -->
    <link href="<?php echo base_url();?>public/css/animate.css" rel="stylesheet">
    <!-- Dashboard css from Bootstrap -->
    <link href="<?php echo base_url();?>public/bootstrap/css/dashboard.css" rel="stylesheet">
    <!-- Jcrop css -->
    <link href="<?php echo base_url();?>public/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet">
    <!-- JquerTe -->
    <link href="<?php echo base_url();?>public/jqueryte/jquery-te-1.4.0.css" rel="stylesheet">
    <!-- Sweetalert CSS -->
    <link href="<?php echo base_url();?>public/sweetalert-master/lib/sweet-alert.css" rel="stylesheet">
    
    <!-- Custom styles -->
    <link href="<?php echo base_url();?>public/css/main.css" rel="stylesheet">

    <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/js/main.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url();?>">Nip Igniter</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>

            <?php if($this->session->userdata("user_id")):?>
              <li><a href="<?php echo site_url("auth/logout");?>">Logout</a></li>
            <?php endif;?>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <!--.row-->
      <div class="row">
        <!--.col-sm-3-->
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <?php $this->load->view('partial/menu');?>
          </ul>
        </div>
        <!--/.col-sm-3-->

        <!--.col-sm-9-->
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h3 class="page-header"><?php echo $this->pageTitle;?></h3>

          <!--Content here..-->
          <?php echo $pageContent;?>
          
        </div>
        <!--/.col-sm-9-->
      </div>
      <!--/.row-->
    </div>

    <div id="loading">
      <ul class="bokeh">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>

    <div id="error-message"></div>

    <!-- Modal -->
    <div class="modal fade" id="modal-global" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Details</h4>
          </div>
          <div class="modal-body" id="modal-body">
            Content Here...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url();?>public/bootflat/js/site.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/eternicode-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.typing-0.2.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/jcrop/js/jquery.Jcrop.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/jqueryte/jquery-te-1.4.0.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>public/sweetalert-master/lib/sweet-alert.min.js"></script>

  </body>
</html>
