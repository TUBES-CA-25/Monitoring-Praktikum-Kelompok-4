<?php Flasher::flash(); ?>
<div class="content-wrapper">
    
  <?= Flasher::flash(); ?>

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3><?= e($data['title']) ?></h3> 
          </div><div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php if ($_SESSION['role'] == 'Admin') : ?>
              <li class="breadcrumb-item"><a href="<?= BASEURL?>">Home</a></li>
              <?php endif; ?>
              <li class="breadcrumb-item active"><?= e($data['title']) ?></li>
            </ol>
          </div></div></div></div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <?php if ($_SESSION['role'] == 'Asisten') : ?>
            <div class="col-md-12">
              <div class="card card-primary card-outline shadow-sm">
                  <div class="card-body">
                      <?php 
                          $a = isset($data['asisten'][0]) ? $data['asisten'][0] : null; 
                          $u = isset($data['user'][0]) ? $data['user'][0] : null; 
                      ?>
                      <?php if ($u && $a): ?>
                      <div class="row align-items-center">
                          <!-- Bagian Kiri: Foto Profil -->
                          <div class="col-md-4 text-center border-right">
                              <img class="profile-user-img img-fluid img-circle shadow-sm mb-3"
                                   src="<?= BASEURL; ?>/<?= e($a['photo_profil']) ?>" 
                                   alt="Foto Profil"
                                   style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%;">
                              <h3 class="profile-username" style="font-weight: 600;"><?= e($u['nama_user']) ?></h3>
                              <p class="text-muted"><span class="badge badge-primary px-3 py-2" style="font-size: 0.9rem;">Asisten Praktikum</span></p>
                          </div>
                          
                          <!-- Bagian Kanan: Detail Informasi -->
                          <div class="col-md-8 px-4">
                              <h4 class="mb-4 text-primary" style="font-weight: 600;"><i class="fas fa-info-circle"></i> Detail Informasi Asisten</h4>
                              <table class="table table-hover table-borderless">
                                  <tbody>
                                      <tr>
                                        <td width="30%" class="text-muted">Username / Email</td>
                                        <td style="font-weight: 500;"><?= e($u['username']) ?></td>
                                      </tr>
                                      <tr>
                                        <td class="text-muted">Stambuk</td>
                                        <td style="font-weight: 500;"><?= e($a['stambuk']) ?></td>
                                      </tr>
                                      <tr>
                                        <td class="text-muted">Nama Lengkap</td>
                                        <td style="font-weight: 500;"><?= e($a['nama_asisten']) ?></td>
                                      </tr>
                                      <tr>
                                        <td class="text-muted">Angkatan</td>
                                        <td style="font-weight: 500;"><?= e($a['angkatan']) ?></td>
                                      </tr>
                                      <tr>
                                        <td class="text-muted">Jenis Kelamin</td>
                                        <td style="font-weight: 500;"><?= e($a['jenis_kelamin']) ?></td>
                                      </tr>
                                      <tr>
                                        <td class="text-muted align-middle">Tanda Tangan Digital</td>
                                        <td>
                                          <?php if (!empty($a['photo_path'])): ?>
                                              <img src="<?= BASEURL; ?>/<?= e($a['photo_path']) ?>" alt="Foto TTD" class="img-thumbnail shadow-sm" style="max-height: 80px;">
                                          <?php else: ?>
                                              <span class="badge bg-secondary">Tidak ada</span>
                                          <?php endif; ?>
                                        </td>
                                      </tr>
                                  </tbody>
                              </table>
                              <div class="text-right mt-4 pt-3 border-top">
                                  <a class="btn btn-primary px-4 text-white" onclick="change('User', '<?= e($u['id_user']) ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <i class="fa fa-edit mr-1"></i> Edit Profil
                                  </a>
                              </div>
                          </div>
                      </div>
                      <?php endif; ?>
                  </div>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($_SESSION['role'] == 'Admin') : ?>
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                  <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary button-style" onclick="add('Asisten')"><i class="fas fa-plus"></i> Tambah</a>
                  <a data-bs-toggle="modal" data-bs-target="#importExcelModal" class="btn btn-success button-style"><i class="fas fa-file-excel"></i> Import Excel</a>
                
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden">
                    <div id="world-map-markers">
                        <div class="col-md-12 mt-3 pb-3 mb-3">
                          <div class="overflow-auto">
                            <table id="myTable" class="table" style="width:100%">
                              <thead class="table-light">
                                <tr>
                                  <th scope="col" style="width:5%;" class="text-center">No</th>
                                  <th scope="col" class="text-center">Stambuk</th>
                                  <th scope="col">Nama Asisten</th>
                                  <th scope="col" class="text-center">Angkatan</th>
                                  <th scope="col">Status</th>
                                  <th scope="col" class="text-center">Jenis Kelamin</th>
                                  <th scope="col">Nama User</th>
                                  <th scope="col" class="text-center">Foto Profil</th>
                                  <th scope="col" class="text-center">Tanda Tangan</th>
                                  <th scope="col"  style="width:15%" class="text-center">Menu</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php $no=0; foreach  ($data['asisten'] as $asisten) : $no++;?>
                                    <tr>
                                      <td class="text-middle" align="center"><?= e($no) ?></td>
                                      <td class="text-center"><?= e($asisten['stambuk']) ?></td>
                                      <td><?= e($asisten['nama_asisten']) ?></td>
                                      <td class="text-center"><?= e($asisten['angkatan']) ?></td>
                                      <td><?= e($asisten['status']) ?></td>
                                      <td class="text-center"><?= e($asisten['jenis_kelamin']) ?></td>
                                      <td><?= e($asisten['username']) ?></td>                                     
                                      
                                      <td class="text-center">
                                          <img src="<?= BASEURL; ?>/<?= e($asisten['photo_profil']) ?>" 
                                               alt="Foto" 
                                               style="width: 90px; height: 120px; object-fit: cover; border-radius: 5px;">
                                      </td>
                                      
                                      <td class="text-center"><img src="<?= BASEURL; ?>/<?= e($asisten['photo_path']) ?>" alt="Foto" style="max-width: 100px; max-height: 100px;"></td>                                     
                                      
                                      <td align="center">
                                        <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Asisten', '<?= e($asisten['id_asisten']) ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Asisten', '<?= e($asisten['id_asisten']) ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
                  </div>
                </div></div>
              </div>
          </div>
          <?php endif; ?>
          </div>
          </div>
        </div></section>
        
        <!-- Modal Import Excel -->
        <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="importExcelModalLabel"><i class="fas fa-file-excel"></i> Import Data Asisten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="<?= BASEURL; ?>/Asisten/importExcel" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <div class="form-group mb-3">
                    <a href="<?= BASEURL; ?>/Asisten/downloadTemplate" class="btn btn-info btn-sm text-white">
                        <i class="fas fa-download"></i> Download Template CSV
                    </a>
                  </div>
                  <div class="form-group">
                    <label for="file_excel">Pilih File Data (.csv)</label>
                    <input type="file" class="form-control" name="file_excel" id="file_excel" accept=".csv" required>
                    <small class="form-text text-muted">Format kolom (A-F): Stambuk, Nama Asisten, Angkatan, Status (Asisten/Calon Asisten), Jenis Kelamin (Pria/Wanita), Username (Email). Baris pertama akan diabaikan (sebagai header).</small>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Import</button>
                </div>
              </form>
            </div>
          </div>
        </div>

    </div>