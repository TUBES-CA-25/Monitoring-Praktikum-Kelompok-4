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
          <div class="col-md-12">
            <!-- MAP & BOX PANE -->
            <div class="card">
              <div class="card-header">
                <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary button-style" onclick="add('Ajaran')">Tambah</a>
                
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
                                  <th scope="col">Tahun Ajaran</th>
                                        <th scope="col"  style="width:15%" class="text-center">Menu</th>
                                      </tr>
                                </thead>
                                <tbody>
                                    <?php $no=0; foreach  ($data['ajaran'] as $ajaran) : $no++;?>
                                        <tr>
                                            <td class="text-middle" align="center"><?= $no;?></td>
                                            <td><?= $ajaran['tahun_ajaran'];?></td>
                                            <td align="center">
                                              <!-- <div class="btn" aria-label="Basic outlined example"> -->
                                                <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Ajaran', '<?= $ajaran['id_tahun']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Ajaran', '<?= $ajaran['id_tahun']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
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
  </div>
  <!-- /.content-wrapper -->