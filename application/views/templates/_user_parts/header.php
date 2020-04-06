<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME ?></title>
    <meta name="description" content="<?php echo APP_NAME ?>" />
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url().FAVICON_IMAGE;?>"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <!-- Bootstrap 3.3.7 -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
 <!-- Font Awesome -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css">
 <!-- Ionicons -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/Ionicons/css/ionicons.min.css">
 <!-- Theme style -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css">
 <!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/skins/_all-skins.min.css">
 <!-- Morris chart -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/morris.js/morris.css">
 <!-- jvectormap -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/jvectormap/jquery-jvectormap.css">
 <!-- Date Picker -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
 <!-- Daterange picker -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
 <!-- bootstrap wysihtml5 - text editor -->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- <body class="hold-transition skin-blue sidebar-mini" onload="menuActive('<?php echo $this->uri->segment(2); ?>')" > -->
<body class="hold-transition skin-blue sidebar-mini" onload="menuActive('<?php echo $this->router->fetch_class() ?>', '<?php echo $this->router->fetch_method() ?>')" >
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="<?php echo site_url(  );?>" class="logo">
      <img  src="<?php echo base_url().FAVICON_IMAGE ?>" alt="Jason's Photo" height="35px" />
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><?php echo APP_NAME ?></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><?php echo APP_NAME ?></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img class="user-image" src="<?php  echo $a =  ( !($this->session->userdata('user_image')) ) ?  base_url(FAVICON_IMAGE)  : base_url('uploads/users_photo/').$this->session->userdata('user_image') ?>">
                <?php echo $this->session->userdata('user_profile_name')?>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img class="nav-user-photo" src="<?php  echo $a =  ( !($this->session->userdata('user_image')) ) ?  base_url(FAVICON_IMAGE)  : base_url('uploads/users_photo/').$this->session->userdata('user_image') ?>">
                  <p>
                    <?php echo $this->session->userdata('user_profile_name')?>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo site_url('user/profile')?>" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo site_url('auth/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

