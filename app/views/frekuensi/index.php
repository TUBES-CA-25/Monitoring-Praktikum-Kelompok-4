<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3><?= $data['title']; ?></h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <?php if ($_SESSION['role'] == 'Admin') : ?>
              <li class="breadcrumb-item"><a href="<?= BASEURL ?>">Home</a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active"><?= $data['title']; ?></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <?php if ($_SESSION['role'] == 'Asisten') : ?>
          <li class="nav-item">
            <a class="nav-link active" id="jadwal-frekuensi-tab" data-toggle="tab" href="#jadwal-frekuensi" role="tab" aria-controls="jadwal-frekuensi" aria-selected="true">Jadwal Frekuensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="jadwal-frekuensi2-tab" data-toggle="tab" href="#jadwal-frekuensi2" role="tab" aria-controls="jadwal-frekuensi2" aria-selected="false">Jadwal Frekuensi Keseluruhan</a>
          </li>
        <?php elseif ($_SESSION['role'] == 'Admin') : ?>
          <li class="nav-item">
            <a class="nav-link active" id="jadwal-frekuensi2-tab" data-toggle="tab" href="#jadwal-frekuensi2" role="tab" aria-controls="jadwal-frekuensi2" aria-selected="true">Jadwal Frekuensi Keseluruhan</a>
          </li>
        <?php endif; ?>
      </ul>
      <div class="tab-content" id="myTabContent">
        <?php if ($_SESSION['role'] == 'Asisten') : ?>
          <div class="tab-pane fade show active" id="jadwal-frekuensi" role="tabpanel" aria-labelledby="jadwal-frekuensi-tab">
            <!-- Konten untuk Jadwal Frekuensi -->
            <div class="row">
              <div class="col-md-12">
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
                                    <th scope="col" class="text-center">Frekuensi</th>
                                    <th scope="col" class="text-center">Kode Matakuliah</th>
                                    <th scope="col" class="text-center">Nama Matakuliah</th>
                                    <th scope="col" class="text-center">Tahun Ajaran</th>
                                    <th scope="col" class="text-center">Kelas</th>
                                    <th scope="col" class="text-center">Hari / Jam</th>
                                    <th scope="col" class="text-center">Ruangan</th>
                                    <th scope="col" class="text-center">Dosen</th>
                                    <th scope="col" class="text-center">Asisten 1</th>
                                    <th scope="col" class="text-center">Asisten 2</th>
                                    <th scope="col" style="width:15%" class="text-center">Menu</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no=0; foreach ($data['frekuensi_asisten'] as $frekuensi) : $no++; ?>
                                    <tr>
                                      <td class="text-center"><?= $no; ?></td>
                                      <td class="text-center"><?= $frekuensi['frekuensi']; ?></td>
                                      <td class="text-center"><?= $frekuensi['kode_matkul']; ?></td>
                                      <td><?= $frekuensi['nama_matkul']; ?></td>
                                      <td class="text-center"><?= $frekuensi['tahun_ajaran']; ?></td>
                                      <td class="text-center"><?= $frekuensi['kelas']; ?></td>
                                      <td><?= $frekuensi['hari']; ?>/<?= date('H:i', strtotime($frekuensi['jam_mulai'])); ?>-<?= date('H:i', strtotime($frekuensi['jam_selesai'])); ?></td>
                                      <td><?= $frekuensi['nama_ruangan']; ?></td>
                                      <td><?= $frekuensi['nama_dosen']; ?></td>
                                      <td><?= $frekuensi['asisten_1']; ?></td>
                                      <td><?= $frekuensi['asisten_2']; ?></td>
                                      <td align="center">
                                        <?php if ($_SESSION['role'] == 'Admin') : ?>
                                        <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Frekuensi', '<?= $frekuensi['id_frekuensi']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Frekuensi', '<?= $frekuensi['id_frekuensi']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
                                        <?php endif; ?>
                                        <a class="btn btn-primary btn-sm button-style text-center" href="<?= BASEURL ?>/frekuensi/detail/<?= $frekuensi['id_frekuensi']; ?>" role="button"><i class="fa fa-list"></i></a>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="jadwal-frekuensi2" role="tabpanel" aria-labelledby="jadwal-frekuensi2-tab">
            <!-- Konten untuk Jadwal Frekuensi Keseluruhan UNTUK ASISTEN-->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                  <?php if ($_SESSION['role'] == 'Admin') : ?>
                    <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary button-style" onclick="add('Frekuensi')">Tambah</a>
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
                  <div class="card-body p-0">
                    <div class="d-md-flex">
                      <div class="p-1 flex-fill" style="overflow: hidden">
                        <div id="world-map-markers">
                          <div class="col-md-12 mt-3 pb-3 mb-3">
                            <div class="overflow-auto">
                              <table id="example2" class="table" style="width:100%">
                                <thead class="table-light">
                                  <tr>
                                    <th scope="col" style="width:5%;" class="text-center">No</th>
                                    <th scope="col" class="text-center">Frekuensi</th>
                                    <th scope="col" class="text-center">Kode Matakuliah</th>
                                    <th scope="col" class="text-center">Nama Matakuliah</th>
                                    <th scope="col" class="text-center">Tahun Ajaran</th>
                                    <th scope="col" class="text-center">Kelas</th>
                                    <th scope="col" class="text-center">Hari / Jam</th>
                                    <th scope="col" class="text-center">Ruangan</th>
                                    <th scope="col" class="text-center">Dosen</th>
                                    <th scope="col" class="text-center">Asisten 1</th>
                                    <th scope="col" class="text-center">Asisten 2</th>
                                    <th scope="col" style="width:15%" class="text-center">Menu</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no=0; foreach ($data['frekuensi'] as $frekuensi) : $no++; ?>
                                    <tr>
                                      <td class="text-center"><?= $no; ?></td>
                                      <td class="text-center"><?= $frekuensi['frekuensi']; ?></td>
                                      <td class="text-center"><?= $frekuensi['kode_matkul']; ?></td>
                                      <td><?= $frekuensi['nama_matkul']; ?></td>
                                      <td class="text-center"><?= $frekuensi['tahun_ajaran']; ?></td>
                                      <td class="text-center"><?= $frekuensi['kelas']; ?></td>
                                      <td><?= $frekuensi['hari']; ?>/<?= date('H:i', strtotime($frekuensi['jam_mulai'])); ?>-<?= date('H:i', strtotime($frekuensi['jam_selesai'])); ?></td>
                                      <td><?= $frekuensi['nama_ruangan']; ?></td>
                                      <td><?= $frekuensi['nama_dosen']; ?></td>
                                      <td><?= $frekuensi['asisten_1']; ?></td>
                                      <td><?= $frekuensi['asisten_2']; ?></td>
                                      <td align="center">
                                        <?php if ($_SESSION['role'] == 'Admin') : ?>
                                        <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Frekuensi', '<?= $frekuensi['id_frekuensi']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Frekuensi', '<?= $frekuensi['id_frekuensi']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
                                        <?php endif; ?>
                                        <a class="btn btn-primary btn-sm button-style text-center" href="<?= BASEURL ?>/frekuensi/detail/<?= $frekuensi['id_frekuensi']; ?>" role="button"><i class="fa fa-list"></i></a>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php elseif ($_SESSION['role'] == 'Admin') : ?>
          <div class="tab-pane fade show active" id="jadwal-frekuensi2" role="tabpanel" aria-labelledby="jadwal-frekuensi2-tab">
            <!-- Konten untuk Jadwal Frekuensi Keseluruhan -->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary button-style" onclick="add('Frekuensi')">Tambah</a>
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
                                    <th scope="col" class="text-center">Frekuensi</th>
                                    <th scope="col" class="text-center">Kode Matakuliah</th>
                                    <th scope="col" class="text-center">Nama Matakuliah</th>
                                    <th scope="col" class="text-center">Tahun Ajaran</th>
                                    <th scope="col" class="text-center">Kelas</th>
                                    <th scope="col" class="text-center">Hari / Jam</th>
                                    <th scope="col" class="text-center">Ruangan</th>
                                    <th scope="col" class="text-center">Dosen</th>
                                    <th scope="col" class="text-center">Asisten 1</th>
                                    <th scope="col" class="text-center">Asisten 2</th>
                                    <th scope="col" style="width:15%" class="text-center">Menu</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no=0; foreach ($data['frekuensi'] as $frekuensi) : $no++; ?>
                                    <tr>
                                      <td class="text-center"><?= $no; ?></td>
                                      <td class="text-center"><?= $frekuensi['frekuensi']; ?></td>
                                      <td class="text-center"><?= $frekuensi['kode_matkul']; ?></td>
                                      <td><?= $frekuensi['nama_matkul']; ?></td>
                                      <td class="text-center"><?= $frekuensi['tahun_ajaran']; ?></td>
                                      <td class="text-center"><?= $frekuensi['kelas']; ?></td>
                                      <td><?= $frekuensi['hari']; ?>/<?= date('H:i', strtotime($frekuensi['jam_mulai'])); ?>-<?= date('H:i', strtotime($frekuensi['jam_selesai'])); ?></td>
                                      <td><?= $frekuensi['nama_ruangan']; ?></td>
                                      <td><?= $frekuensi['nama_dosen']; ?></td>
                                      <td><?= $frekuensi['asisten_1']; ?></td>
                                      <td><?= $frekuensi['asisten_2']; ?></td>
                                      <td align="center">
                                        <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Frekuensi', '<?= $frekuensi['id_frekuensi']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Frekuensi', '<?= $frekuensi['id_frekuensi']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
                                        <a class="btn btn-primary btn-sm button-style text-center" href="<?= BASEURL ?>/frekuensi/detail/<?= $frekuensi['id_frekuensi']; ?>" role="button"><i class="fa fa-list"></i></a>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
</div>
