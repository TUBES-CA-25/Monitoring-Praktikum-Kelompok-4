<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3><?= $data['title'];?></h3> 
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><?= $data['title'];?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
        <?php if ($_SESSION['role'] == 'Admin') : ?>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-clipboard"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Monitoring</span>
                <span class="info-box-number"><?php echo $data['jumlahDataMentoring']; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data User</span>
                <span class="info-box-number"><?php echo $data['jumlahDataUser']; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <!-- <div class="clearfix hidden-md-up"></div> -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Dosen</span>
                <span class="info-box-number"><?php echo $data['jumlahDataDosen']; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Asisten</span>
                <span class="info-box-number"><?php echo $data['jumlahDataAsisten']; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <?php endif; ?>
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <?php if ($_SESSION['role'] == 'Admin') : ?>
          <div class="col-md-8">
          <?php endif; ?>
          <?php if ($_SESSION['role'] == 'Asisten') : ?>
            <div class="col-md-12">
          <?php endif; ?>
            <!-- MAP & BOX PANE -->
          <?php if ($_SESSION['role'] == 'Admin') : ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">ICLabs Monitoring</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden">
                    <!-- Map ICLabs will be created here -->
                    <div id="world-map-markers" style="height: 325px; overflow: hidden">
                        <div style="text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                            <img src="<?= BASEURL?>/public/img/ICLabs-logo.png" alt="ICLabs" height="150" width="150" style="margin-bottom: 20px;">
                            <p>Integrated Computer Laboratories</p>
                            <p>Jl. Urip Sumoharjo KM. 5 Makassar, Sulawesi Selatan 902311234</p>
                        </div>
                    </div>
                  </div>
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <?php endif; ?>
          <?php if ($_SESSION['role'] == 'Asisten') : ?>
          <div class="row">
            <!-- ================= LEFT : KALENDER ================= -->
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-calendar-alt"></i> Kalender Monitoring Praktikum
                  </h3>
                </div>

                <div class="card-body">
                  <!-- FULLCALENDAR -->
                  <div id="calendar-monitoring" style="min-height:420px;"></div>

                  <!-- LEGEND -->
                  <div class="mt-3">
                    <span class="badge bg-success">Monitoring Selesai</span>
                    <span class="badge bg-danger">Belum Diisi</span>
                    <span class="badge bg-warning">Hari Ini</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                  <div class="card-header bg-warning">
                      <h3 class="card-title"><i class="fas fa-clock"></i> Monitoring Hari Ini</h3>
                  </div>
                  <div class="card-body">
                      <?php if (!empty($data['monitoringHariIni'])) : ?>
                          <?php foreach ($data['monitoringHariIni'] as $index => $jadwal) : ?>
                              <div class="monitoring-item <?= $index > 0 ? 'mt-3 pt-3 border-top' : ''; ?>">
                                  <p class="mb-1">
                                      <strong>Mata Kuliah:</strong><br>
                                      <?= $jadwal['nama_matkul']; ?> (<?= $jadwal['kelas']; ?> - <?= $jadwal['frekuensi']; ?>)
                                  </p>
                                  
                                  <p class="mb-1"><strong>Jam:</strong><br>
                                      <span class="badge badge-secondary">
                                          <i class="fas fa-clock"></i> <?= substr($jadwal['jam_mulai'], 0, 5); ?> - <?= substr($jadwal['jam_selesai'], 0, 5); ?>
                                      </span>
                                  </p>
                                  
                                  <p class="mb-2"><strong>Laboratorium:</strong><br>
                                      <i class="fas fa-map-marker-alt"></i> <?= $jadwal['ruangan']; ?>
                                  </p>

                                  <a href="<?= BASEURL; ?>/frekuensi/detail/<?= $jadwal['id_jadwal']; ?>" class="btn btn-primary btn-sm btn-block">
                                      <i class="fas fa-edit"></i> Isi Monitoring
                                  </a>
                              </div>
                          <?php endforeach; ?>
                      <?php else : ?>
                          <p class="text-muted text-center py-3">Tidak ada jadwal hari ini</p>
                      <?php endif; ?>
                  </div>
              </div>

              <div class="card mt-3">
                <div class="card-header bg-info">
                  <h3 class="card-title">
                    <i class="fas fa-history"></i> Aktivitas Terakhir
                  </h3>
                </div>

                <div class="card-body p-0">
                  <ul class="list-group list-group-flush">
                    <?php if (!empty($data['aktivitasTerakhir'])) : ?>
                      <?php foreach ($data['aktivitasTerakhir'] as $a) : ?>
                        <li class="list-group-item">
                          <div class="d-flex justify-content-between align-items-center">
                            <div>
                              <strong><?= $a['nama_matkul']; ?> (<?= $a['kelas']; ?>)</strong><br>
                              <small class="text-muted">
                                <i class="fas fa-map-marker-alt"></i> <?= $a['ruangan']; ?> • 
                                <i class="fas fa-clock"></i> <?= substr($a['jam_mulai'], 0, 5); ?> - <?= substr($a['jam_selesai'], 0, 5); ?>
                              </small><br>
                              <small class="text-primary font-weight-bold">
                                <i class="fas fa-calendar-day"></i> <?= $a['tanggal']; ?>
                              </small>
                            </div>
                            <span class="badge bg-success">Selesai</span>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <li class="list-group-item text-muted text-center py-3">
                        Belum ada aktivitas
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
          </div>
          <?php endif; ?>
          <!-- /.col -->
          <?php if ($_SESSION['role'] == 'Admin') : ?>
          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Matakuliah</span>
                <span class="info-box-number"><?php echo $data['jumlahDataMatakuliah']; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-building"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Laboratorium</span>
                <span class="info-box-number"><?php echo $data['jumlahDataRuangan']; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-chalkboard-teacher"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Kelas</span>
                <span class="info-box-number"><?php echo $data['jumlahDataKelas']; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fas fa-graduation-cap"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Data Jurusan</span>
                <span class="info-box-number"><?php echo $data['jumlahDataJurusan']; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <!-- /.card -->
          </div>
          <?php endif; ?>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->