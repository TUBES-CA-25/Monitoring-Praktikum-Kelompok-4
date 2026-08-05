<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <?php Flasher::flash(); ?>
    
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
                <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary button-style" onclick="add('Matakuliah')"><i class="fas fa-plus"></i> Tambah</a>
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
              <div class="card-body p-0">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden">
                    <!-- Map ICLabs will be created here -->
                    <div id="world-map-markers">
                        <div class="col-md-12 mt-3 pb-3 mb-3">
                          <div class="overflow-auto">
                            <table id="myTable" class="table" style="width:100%">
                              <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width:5%;" class="text-center">No</th>
                                        <th scope="col">Kode Matakuliah</th>
                                        <th scope="col">Matakuliah</th>
                                        <th class="text-center" scope="col">Singkatan</th>
                                        <th class="text-center" scope="col">Semester</th>
                                        <th class="text-center" scope="col">SKS</th>
                                        <th class="text-center" scope="col">Jurusan</th>
                                        <th scope="col"  style="width:15%" class="text-center">Menu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=0; foreach  ($data['matakuliah'] as $matakuliah) : $no++;?>
                                        <tr>
                                            <td align="center"><?= e($no) ?></td>
                                            <td><?= e($matakuliah['kode_matkul']) ?></td>
                                            <td><?= e($matakuliah['nama_matkul']) ?></td>
                                            <td align="center"><?= e($matakuliah['singkatan']) ?></td>
                                            <td align="center"><?= e($matakuliah['semester']) ?></td>
                                            <td align="center"><?= e($matakuliah['sks']) ?></td>
                                            <td align="center"><?= e($matakuliah['jurusan']) ?></td>
                                            <td align="center">
                                                <!-- <div class="btn" aria-label="Basic outlined example"> -->
                                                    <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Matakuliah', '<?= e($matakuliah['id_matkul']) ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Matakuliah', '<?= e($matakuliah['id_matkul']) ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
                                                <!-- </div> -->
                                            </td>
                                        </tr>
                                      <?php endforeach; ?>
                                    </tbody>
                                  </table>
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
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="importExcelModalLabel"><i class="fas fa-file-excel"></i> Import Data Matakuliah</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="<?= BASEURL; ?>/Matakuliah/importExcel" method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group mb-3">
                <a href="<?= BASEURL; ?>/Matakuliah/downloadTemplate" class="btn btn-info btn-sm text-white">
                    <i class="fas fa-download"></i> Download Template CSV
                </a>
              </div>
              <div class="form-group">
                <label for="file_excel">Pilih File Data (.csv)</label>
                <input type="file" class="form-control" name="file_excel" id="file_excel" accept=".csv" required>
                <small class="form-text text-muted">Format kolom (A-F): Kode Matkul, Matakuliah, Singkatan, ID Jurusan, Semester, SKS. Baris pertama akan diabaikan (header).</small>
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
  <!-- /.content-wrapper -->