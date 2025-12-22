<?php
  session_start();
  $nama_user = isset($_SESSION['id_user']) ? $_SESSION['nama_user'] : '';
  $current_page = $_SERVER['REQUEST_URI'];
?>

<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <span href="" class="brand-link">
      <img src="<?= BASEURL ?>/public/img/ICLabs.png" alt="ICLabs" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Monitoring Praktikum</span>
    </span>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= BASEURL ?>/public/img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <?php if ($_SESSION['role'] == 'Admin') : ?>
          <a href="<?= BASEURL ?>/user" style="text-decoration:none;"><?= $nama_user ?></a>
          <?php endif; ?>
          <?php if ($_SESSION['role'] == 'Asisten') : ?>
          <a href="<?= BASEURL ?>/asisten" style="text-decoration:none;"><?= $nama_user ?></a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= BASEURL ?>/home" class="nav-link <?= strpos($current_page, '/home') !== false ? 'active' : '' ?>">
                <i class="nav-icon fas fa-home"></i>
                <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MENU UTAMA</li>
          <li class="nav-item">
            <a href="<?= BASEURL ?>/frekuensi" class="nav-link <?= strpos($current_page, '/frekuensi') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-clipboard"></i>
              <p>Monitoring</p>
            </a>
          </li>
          <?php if ($_SESSION['role'] == 'Admin') : ?>
          <li class="nav-header">DATA</li>            
          <li class="nav-item">
            <a href="<?= BASEURL ?>/dosen" class="nav-link <?= strpos($current_page, '/dosen') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>Data Dosen</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= BASEURL ?>/asisten" class="nav-link <?= strpos($current_page, '/asisten') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Data Asisten</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= BASEURL ?>/user" class="nav-link <?= strpos($current_page, '/user') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>Data User</p>
            </a>
          </li>
          <li class="nav-header">MENU LAINNYA</li>
          <li class="nav-item">
            <a href="<?= BASEURL ?>/matakuliah" class="nav-link <?= strpos($current_page, '/matakuliah') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-book"></i>
              <p>Matakuliah</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= BASEURL ?>/ruangan" class="nav-link <?= strpos($current_page, '/ruangan') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-building"></i>
              <p>Laboratorium</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= BASEURL ?>/kelas" class="nav-link <?= strpos($current_page, '/kelas') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Kelas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= BASEURL ?>/jurusan" class="nav-link <?= strpos($current_page, '/jurusan') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>Jurusan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= BASEURL ?>/ajaran" class="nav-link <?= strpos($current_page, '/ajaran') !== false ? 'active' : '' ?>">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>Tahun Ajaran</p>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
