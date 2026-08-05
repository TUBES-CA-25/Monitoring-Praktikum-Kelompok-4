Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3><?= e($data['title']) ?></h3> 
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= BASEURL?>">Home</a></li>
              <li class="breadcrumb-item active"><?= e($data['title']) ?></li>
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
          <div class="col-md-12">
            <!-- MAP & BOX PANE -->
            <div class="card">
              <div class="card-header">
                <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary button-style" onclick="add('Mentoring')">Tambah</a>
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
              <!-- /.card-header -->
               <div>
                  <div>
                  <div class="data-frekuensi d-flex flex-row justify-content-between mb-4">
                      <div class="column-1 d-flex flex-row gap-3">
                          <div class="frek-header d-flex flex-column">
                              <span>Kode Matakuliah</span> 
                              <span>Nama Matakuliah</span> 
                              <span>Frekuensi</span> 
                              <span>Hari / Jam</span> 
                          </div>
                          <div class="frek-value d-flex flex-column">
                              <span>Kode Matkul</span> 
                              <span>Nama Matkul</span> 
                              <span>Kelas</span> 
                              <span>Jadwal</span>
                          </div>
                      </div>
                      <div class="column-2 d-flex flex-row gap-3">
                          <div class="frek-header d-flex flex-column">
                              <span>Ruangan</span> 
                              <span>Dosen</span> 
                              <span>Asisten 1</span> 
                              <span>Asisten 2</span> 
                          </div>
                          <div class="frek-value d-flex flex-column">
                              <span>Nama Laboratorium</span> 
                              <span>Nama Dosen</span> 
                              <span>Nama Asisten 1</span> 
                              <span>Nama Asisten 2</span> 
                          </div>
                      </div>
                  </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="d-md-flex">
                      <div class="p-1 flex-fill" style="overflow: hidden">
                        <!-- Map ICLabs will be created here -->
                        <div id="world-map-markers">
                            <div class="col-md-12 mt-3 pb-3 mb-3">
                              <div class="overflow-auto">
                                <table id="example" class="table" style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                          <th scope="col" style="width:5%;" class="text-center">No</th>
                                          <th scope="col">Tanggal</th>
                                          <th scope="col">Uraian Materi</th>
                                          <th scope="col">Uraian Tugas</th>
                                          <th scope="col">Asisten Pengganti</th>
                                          <th scope="col" colspan="8" class="text-center">Jadwal Praktikum</th>
                                          <th scope="col" style="width:15%" class="text-center">Menu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php $no=0; foreach  ($data['mentoring'] as $mentoring) : $no++;?>
                                          <tr>
                                            <td class="text-middle" align="center"><?= e($no) ?></td>
                                            <td><?= e($mentoring['tanggal']) ?></td>
                                            <td><?= e($mentoring['uraian_materi']) ?></td>
                                            <td><?= e($mentoring['uraian_tugas']) ?></td>
                                            <td><?= e($mentoring['nama_asisten']) ?></td>
                                            <td><?= e($mentoring['kode_matkul']) ?></td>
                                            <td><?= e($mentoring['nama_matkul']) ?></td>
                                            <td><?= e($mentoring['frekuensi']) ?></td>
                                            <td><?= e($mentoring['jadwal']) ?></td>
                                            <td><?= e($mentoring['nama_ruangan']) ?></td>
                                            <td><?= e($mentoring['nama_dosen']) ?></td>
                                            <td><?= e($mentoring['nama_asisten']) ?></td>
                                            <td><?= e($mentoring['nama_asisten']) ?></td>
                                            <td align="center">
                                              <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Mentoring', '<?= e($mentoring['id_mentoring']) ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                              <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Mentoring', '<?= e($mentoring['id_mentoring']) ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
                                            </td>
                                          </tr>
                                      <?php endforeach; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                      </div>
                    diiv><!-- /.d-md-flex -->
                  </div>  
               </div>
              
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="importExcelModalLabel"><i class="fas fa-file-excel"></i> Import Data Monitoring</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= BASEURL; ?>/Mentoring/importExcel" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <a href="<?= BASEURL; ?>/Mentoring/downloadTemplate" class="btn btn-info btn-sm text-white">
                            <i class="fas fa-download"></i> Download Template CSV
                        </a>
                    </div>
                    <div class="form-group">
                        <label for="file_excel">Pilih File Data (.csv)</label>
                        <input type="file" class="form-control" name="file_excel" id="file_excel" accept=".csv" required>
                        <small class="form-text text-muted">Format kolom (A-J): ID Frekuensi, Tanggal (YYYY-MM-DD), Uraian Materi, Uraian Tugas, Hadir, Alpa, Dosen (Hadir/kosong), Asisten 1 (Hadir/kosong), Asisten 2 (Hadir/kosong), ID Asisten Pengganti. Baris pertama (header) akan diabaikan.</small>
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