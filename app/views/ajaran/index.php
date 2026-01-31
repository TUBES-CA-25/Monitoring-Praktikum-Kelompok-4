<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3><?= $data['title'];?></h3> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= BASEURL?>">Home</a></li>
              <li class="breadcrumb-item active"><?= $data['title'];?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">

        <div class="row">

          <div class="col-md-12">

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
                                                <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Ajaran', '<?= $ajaran['id_tahun']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Ajaran', '<?= $ajaran['id_tahun']; ?>')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
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
    </section>
  </div>
