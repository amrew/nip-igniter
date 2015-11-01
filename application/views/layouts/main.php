<?php 
  $ci = &get_instance();
  $ci->load->model(array("Auth"));
  $user = $ci->Auth->user();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $pageTitle;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php echo base_url();?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <!-- <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" /> -->
        <!-- Theme style -->
        <link href="<?php echo base_url();?>public/theme/admin-lte/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url();?>public/theme/admin-lte/css/iCheck/all.css" rel="stylesheet" type="text/css" />
        <!-- Sweetalert CSS -->
        <link href="<?php echo base_url();?>public/sweetalert-master/lib/sweet-alert.css" rel="stylesheet">
        <!-- JquerTe -->
        <link href="<?php echo base_url();?>public/jqueryte/jquery-te-1.4.0.css" rel="stylesheet">
        
        <link href="<?php echo base_url();?>public/css/pnotify.custom.min.css" rel="stylesheet">

        <link href="<?php echo base_url();?>public/eternicode-datepicker/css/datepicker.css" rel="stylesheet">

        <link href="<?php echo base_url();?>public/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet">

        <!-- Jcrop css -->
        <link href="<?php echo base_url();?>public/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet">
        
        <script src="<?php echo base_url();?>public/js/jquery-1.11.1.min.js"></script>

        <style type="text/css">
        .breadcrumb{
            margin-bottom: 0;
        }
        .jcrop-holder>div>div>img{
          visibility: hidden !important;
        }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url();?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Nip Igniter
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <?php $this->load->view("layouts/partial/user-panel", array("user"=>$user));?>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <?php $this->load->view("layouts/partial/small-user-panel", array("user"=>$user));?>
                    <!-- search form -->
                    <br>
                    <!-- <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form> -->
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <!-- <li>
                            <a href="<?php echo base_url();?>public/theme/admin-lte/index.html">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li> -->
                        
                        <?php $this->load->view('layouts/partial/menu');?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                
                <?php echo $pageContent;?>

                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="modal-global" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Details</h4>
              </div>
              <div class="modal-body" id="modal-body">
                Loading content...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <script src="<?php echo base_url();?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url();?>public/theme/admin-lte/js/AdminLTE/app.js" type="text/javascript"></script>

        <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.form.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/eternicode-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/js/jquery.typing-0.2.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/jcrop/js/jquery.Jcrop.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/jqueryte/jquery-te-1.4.0.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/sweetalert-master/lib/sweet-alert.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/js/pnotify.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>public/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

        <script src="<?php echo base_url();?>public/js/main.js" type="text/javascript"></script>
    </body>
</html>