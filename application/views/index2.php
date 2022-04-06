<!DOCTYPE html>
<html lang="<?php echo $lang;?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title;?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/summernote/summernote-bs4.min.css">
  <!--jconfirm-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <!--Toogle-->
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <?php 
    for($i=0;$i<count($css);$i++){
      echo '<link href="'.base_url().'assets/css/'.$css[$i].'.css?'.mt_rand().'" rel="stylesheet" />';
    }
  ?>
  <style>
    html{
        -webkit-touch-callout: none;
      -webkit-user-select: none;
      -khtml-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo base_url();?>assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="text-muted mt-1 d-block">Estado <input  class="mt-n1" type="checkbox" <?php echo $user["business_active"]==1 ? "checked" : "";?> disabled data-on="Activo" data-off="Inactivo" data-style="ios" data-onstyle="success" data-offstyle="danger" data-size="small" data-toggle="toggle"></span>
      </li>
      <li class="nav-item">
        <a class="nav-link">
            <!-- <div class="image">
                <img src="<?php echo base_url();?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-4" alt="User Image">
            </div> -->
            <?php echo ucwords($user["user_firstname"]);?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="<?php echo base_url();?>assets/#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bg-danger elevation-4">
     <!-- Brand Logo -->
    <a href="<?php echo base_url();?>assets/index3.html" class="brand-link">
      <!-- <img src="<?php echo base_url();?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      
      <span class="brand-text font-weight-light"><?php  echo ucwords($user["business_type_denomination_".$lang]);?> <?php echo ucwords($user["business_name"]);?></span>
    </a> 
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
          <?php if($user["business_type_id"]==1 || $user["business_type_id"]==2){ ?>
          <li class="nav-item">
            <a href="<?php echo base_url();?>dashboard_mostrador" class="nav-link">
              <i class="text-white fas fa-tv"></i>
              <p class="text-white">
                Mostrador
              </p>
            </a>
          </li>
          <?php }  ?>
          <?php if($user["business_type_id"]==1){ ?>
          <li class="nav-item">
            <a href="<?php echo base_url();?>assets/#" class="nav-link">
              <i class="text-white fas fa-motorcycle"></i>
              <p class="text-white">
                Delivery
              </p>
            </a>
          </li>
          <?php }  ?>
          <li class="nav-item">
            <a href="<?php echo base_url();?>assets/#" class="nav-link">
              <i class="text-white fas fa-cog"></i>
              <p class="text-white">
                Configuración
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_mi_establecimiento" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Mi establecimiento</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_cajas" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Cajas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>#" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Mesas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_usuarios" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Usuarios</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>assets/#" class="nav-link">
              <i class="fas fa-utensils text-white"></i>
              <p class="text-white">
                Inventario
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_categorias" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Categorias</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_articulos" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Articulos o Productos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_insumos_principales_marcas" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Insumos principales o marcas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_presentaciones" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Presentaciones</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>assets/#" class="nav-link">
              <i class="fas fa-cash-register text-white"></i>
              <p class="text-white">
                Ventas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>#" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Arqueo de caja</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>#" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Movimiento de cajas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_ventas" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>#" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Detalle de ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>#" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Reportes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>assets/#" class="nav-link">
            <i class="fas fa-shopping-cart text-white"></i>
              <p class="text-white">
                Compras
                <i class="fas fa-angle-left right"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_categorias" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Categorias</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_articulos" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Articulos o Productos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_insumos_princiapales" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Insumos principales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url();?>dashboard_presentaciones" class="nav-link">
                  &nbsp;&nbsp;&nbsp;
                  <p class="text-white">Presentaciones</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo base_url();?>assets/#" class="nav-link">
              <i class="text-white fas fa-sign-out-alt"></i> 
              <p class="text-white">
                Cerrar sesión
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
     
    </div>
    <!-- /.sidebar -->
     </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $section_title;?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>assets/#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $section_root;?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php echo $content;?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy;2021 <a href="<?php echo base_url();?>assets/https://maabisoftwaresolutions.com">maabisoftwaresolutions.com |  Módulo <?php  echo ucwords($user["business_type_denomination_plural_".$lang]);?>
</a>.</strong>
    Todos los derechos reservacions.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url();?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url();?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url();?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url();?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url();?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url();?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables  & Plugins
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script> -->
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url();?>assets/dist/js/pages/dashboard.js"></script>
<!--jconfirm--->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<!--toogle-->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.4/dist/loadingoverlay.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.datetimepicker.js<?php echo '?'.mt_rand(); ?>"></script>
<script src="<?php echo base_url();?>assets/js/jquery.datetimepicker.full.min.js<?php echo '?'.mt_rand(); ?>"></script>
<script src="<?php echo base_url();?>assets/js/loading.js<?php echo '?'.mt_rand(); ?>"></script>
</script>
  
  <script src="https://www.gstatic.com/firebasejs/7.21.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.21.1/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.21.1/firebase-firestore.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.21.1/firebase-database.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.21.1/firebase-storage.js"></script>
  <script>
    const firebaseConfig = {
      apiKey: "AIzaSyA7R9Ov-_IV_HgEX2jMWVhToY7i4umi5nY",
      authDomain: "maabiapp.firebaseapp.com",
      databaseURL: "https://maabiapp.firebaseio.com",
      projectId: "maabiapp",
      storageBucket: "maabiapp.appspot.com",
      messagingSenderId: "114419472427",
      appId: "1:114419472427:web:3f3960aa1b7e2a4005726e",
      measurementId: "G-XKR53DSW68"
    };
    firebase.initializeApp(firebaseConfig);
  </script>
</body>
</html>
