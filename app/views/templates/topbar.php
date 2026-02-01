<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $nama_user = isset($_SESSION['nama_user']) ? $_SESSION['nama_user'] : '';
?>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item">
          <a class="nav-link" id="dark-mode-toggle" href="#" role="button">
              <i class="fas fa-moon"></i>
          </a>
      </li>

      <li class="nav-item">
        <?php $role = isset($_SESSION['role']) ? $_SESSION['role'] : ''; ?>
        <?php if ($role == 'Asisten') : ?>
            <a class="nav-link" href="<?= BASEURL; ?>/asisten">
                <i class="fas fa-user-circle"></i> Profil Asisten
            </a>
        <?php else : ?>
            <a class="nav-link" href="<?= BASEURL; ?>/user/profil">
                <i class="fas fa-user-circle"></i> Profil Admin
            </a>
        <?php endif; ?>
      </li>

      <li class="nav-item">
          <a class="nav-link text-danger" href="<?= BASEURL ?>" role="button" id="logoutLink">
              <i class="fas fa-sign-out-alt"></i> Logout
          </a>
      </li>
    </ul>
  </nav>