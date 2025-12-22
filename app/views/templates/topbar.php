<?php
  session_start();
  $nama_user = isset($_SESSION['id_user']) ? $_SESSION['nama_user'] : '';
?>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- ANIMASI UNTUK LOADING -->
  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="<?= BASEURL?>/public/img/ICLabs.png" alt="ICLabs" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
      <li class="nav-item">
          <a class="nav-link" href="<?= BASEURL ?>" role="button" id="logoutLink">
              <i class="fas fa-sign-out-alt"></i> Logout
          </a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="<?= BASEURL; ?>/asisten">
              <i class="fas fa-user"></i> Profil
          </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->