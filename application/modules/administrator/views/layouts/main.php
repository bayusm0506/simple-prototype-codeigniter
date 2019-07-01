<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title?> | Administrator</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <!-- jQuery 3 -->
  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js1']?>"></script>

  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js18']?>"></script>
  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js19']?>"></script>
  <script type="text/javascript" src="<?=takeJsAdmin()['js21']?>"></script>
  <script type="text/javascript" src="<?=takeJsAdmin()['js22']?>"></script>
  <script type="text/javascript" src="<?=takeJsAdmin()['js23']?>"></script>
  <script type="text/javascript" src="<?=takeJsAdmin()['js24']?>"></script>
  <script type="text/javascript" src="<?=takeJsAdmin()['js25']?>"></script>

  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js9']?>"></script>
  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js27']?>"></script>
  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js28']?>"></script>
  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js30']?>"></script>
  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js31']?>"></script>

  <?php
    $_arrayCss = $cssFile;
    foreach ($_arrayCss as $p) {
        echo "<link rel='stylesheet' type='text/css' href='".$p."'> \n";
    }
  ?>
  <link rel='stylesheet' type='text/css' href='<?=base_url().takeCssAdmin()['css16']?>'>
  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
  
  <script src="<?php echo base_url() ?>themes/adminlte/dist/js/ajax.js"></script>
  <script src="<?php echo base_url() ?>themes/adminlte/dist/js/component.js"></script>
  <script src="<?php echo base_url() ?>themes/adminlte/ckeditor/ckeditor.js"></script>
  <script src="<?php echo base_url() ?>themes/adminlte/dist/sweetalert/sweetalert.min.js"></script>

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>themes/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>themes/adminlte/bower_components/datatables.net-bs/css/dataTables.colVis.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

  <style type="text/css">
    div.dataTables_wrapper div.dataTables_length label{
      float: right;
    }
  </style>

  <script>CKEDITOR.dtd.$removeEmpty['span'] = false;</script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="animationload">
    <div class="osahanloading"></div>
</div>
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?=base_url()?>administrator/dashboard" class="navbar-brand"><b>Admin</b>LTE</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
              <?php 
                $user_id = $this->session->userdata('user_id');
                $menu = $this->M_menu->menu($user_id)->result();
                foreach ($menu as $m) {
                    $subMenu = $this->M_menu->sub_menu($m->id);
                    if ($subMenu->num_rows() < 1) {
                      echo "<li><a href='#'>".$m->description."</a></li>";
                    }else{
                      echo "
                        <li class='dropdown'>
                          <a href='#' class='dropdown-toggle' data-toggle='dropdown'>".$m->description."<span class='caret'></span></a>
                          <ul class='dropdown-menu' role='menu'>";
                            foreach ($subMenu->result() as $sm) {
                               echo "<li><a href='".base_url().$sm->url."'>".$sm->title."</a></li>";
                            } 
                      echo "      
                          </ul>
                        </li>
                      ";
                    }
                }
              ?>
          </ul>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="<?=base_url()?>themes/adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?=ucwords($this->session->username)?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="<?=base_url()?>themes/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                  <p>
                    <?=ucwords($this->session->username)?>
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?=site_url('administrator/profile')?>" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?=site_url('administrator/auth/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <?=$contents?> 
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> <?=VERSION?>
      </div>
      <strong>Copyright &copy; 2015 - <?php echo date('Y'); ?> </strong>, Develop by : <a style='color:#000' href='#'><?=DEVELOPBY?></a>
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->
  <script type="text/javascript" src="<?=base_url().takeJsAdmin()['js3']?>"></script>
<?php
  $_arrayJs = $jsFile;
  foreach ($_arrayJs as $p) {
      echo "<script type='text/javascript' src='".$p."'></script>\n";
  }
?>
<script type="text/javascript">
  // To make Pace works on Ajax calls
  //$(document).ajaxStart(function() { Pace.restart(); });
    var url = window.location;
    // for sidebar menu entirely but not cover treeview
    $('ul.navbar-nav a').filter(function() {
      return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.dropdown-menu a').filter(function() {
      return this.href == url;
    }).closest('.dropdown').addClass('active');


    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $("document").ready(function(){
      $("button#remove-message").click(function(){
        $("div.message-container").hide();
      });
      $('.select2').select2();
    });
</script>
<script type="text/javascript">
  $(window).on('load', function() { // makes sure the whole site is loaded 
      $('.animationload').fadeOut(); // will first fade out the loading animation 
      $('.osahanloading').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
    });
</script>
</body>
</html>
