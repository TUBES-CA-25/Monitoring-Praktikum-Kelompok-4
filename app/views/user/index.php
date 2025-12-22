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
              <li class="breadcrumb-item"><a href="<?= BASEURL?>">Home</a></li>
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
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <?php if ($_SESSION['role'] == 'Admin') : ?>
          <div class="col-md-12">
          <?php endif; ?>
          <?php if ($_SESSION['role'] == 'Asisten') : ?>
          <div class="col-md-4">
          <?php endif; ?>
            <!-- MAP & BOX PANE -->
            <div class="card">
              <div class="card-header">
                <?php if ($_SESSION['role'] == 'Admin') : ?>
                <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary button-style" onclick="add('User')">Tambah</a>
                <?php endif; ?>
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
                    <div id="world-map-markers">
                        <div class="col-md-12 mt-3 pb-3 mb-3">
                          <div class="overflow-auto">
                          <?php if ($_SESSION['role'] == 'Admin') : ?>
                            <table id="myTable" class="table" style="width:100%">
                              <thead class="table-light">
                                  <tr>
                                    <th scope="col" style="width:5%;" class="text-center">No</th>
                                    <th scope="col">Nama User</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Password</th>
                                    <?php if ($_SESSION['role'] == 'Admin') : ?>
                                    <th scope="col">Role</th>
                                    <?php endif; ?>
                                    <th scope="col"  style="width:15%" class="text-center">Menu</th>
                                  </tr>
                              </thead>                              
                              <tbody>
                                  <?php $no = 0; foreach ($data['user'] as $user) : $no++; ?>
                                      <tr>
                                          <td class="text-middle" align="center"><?= $no; ?></td>
                                          <td><?= $user['nama_user']; ?></td>
                                          <td><?= $user['username']; ?></td>
                                          <td>********</td>
                                          <td><?= $user['role']; ?></td>
                                          <td align="center">
                                              <a class="btn btn-primary btn-sm button-style text-center" onclick="change('User', '<?= $user['id_user']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                              <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('User', '<?= $user['id_user']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
                                          </td>
                                      </tr>
                                  <?php endforeach; ?>
                              </tbody>
                            </table>
                            <?php endif; ?>
                            <!-- BAGIAN ASISTEN -->
                            <?php if ($_SESSION['role'] == 'Asisten') : ?>
                            <?php foreach  ($data['asisten'] as $asisten) : ?>
                              <tr>
                                <td>StambuKK</td>
                                <td><?= $asisten['stambuk'];?></td>
                              </tr>
                              <tr>
                                <td><?= $asisten['nama_asisten'];?></td>
                              </tr>
                              <tr>
                                <td><?= $asisten['angkatan'];?></td>
                              </tr>
                              <tr>
                                <td><?= $asisten['status'];?></td>
                              </tr>
                              <tr>
                                <td><?= $asisten['jenis_kelamin'];?></td>
                              </tr>
                              <tr>
                                <td><?= $asisten['id_user'];?></td>
                              </tr>
                              <tr>
                                <td class="text-center"><img src="<?= BASEURL; ?>/<?= $asisten['photo_path'] ?>" alt="Foto" style="max-width: 100px; max-height: 100px;"></td>
                              </tr>
                              <tr>
                                <td align="center">
                                    <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Asisten', '<?= $asisten['id_asisten']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <!-- AKHIR BAGIAN ASISTEN -->
                          </div>
                        </div>
                    </div>
                    
                  </div>
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
          <?php if ($_SESSION['role'] == 'Asisten') : ?>     
          <!-- BAGIAN INDIVIDU -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <div class="card">
              <div class="card-header">
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
                    <div id="world-map-markers">
                        <div class="col-md-12 mt-3 pb-3 mb-3">
                          <div class="overflow-auto">
                            <!-- BAGIAN USER INDIVIDU -->
                            <?php if ($_SESSION['role'] == 'Asisten') : ?>                             
                              <table class="table table-hover table-borderless">
                                <tbody>
                                  <?php $no = 0; foreach ($data['user'] as $user) : $no++; ?>
                                      <tr>
                                        <td width="30%">Username</td>
                                        <td><?= $user['username']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>Stambuk</td>
                                        <td><?= $user['nama_user']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>Nama</td>
                                        <td><?= $user['nama_user']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>Angkatan</td>
                                        <td><?= $user['username']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>Jenis Kelamin</td>
                                        <td><?= $user['username']; ?></td>
                                      </tr>
                                      <tr>
                                        <td>Tanda Tangan</td>
                                        <td><?= $user['username']; ?></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2">
                                            <a class="btn btn-primary btn-sm button-style text-center" onclick="change('User', '<?= $user['id_user']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                        </td>
                                      </tr>
                                    <?php endforeach; ?>
                                </tbody>
                              </table>
                              <?php endif; ?>
                              <!-- AKHIR BAGIAN USER -->
                          </div>
                        </div>
                    </div>
                    
                  </div>
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        <!-- AKHIR BAGIAN INDIVIDU -->
        <?php endif; ?>

        
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

    
    
  </div>
  <!-- /.content-wrapper -->