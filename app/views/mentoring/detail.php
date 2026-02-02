<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?= $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><?= $data['title']; ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($_SESSION['role'] == 'Admin') : ?>
                        <li class="breadcrumb-item"><a href="<?= BASEURL?>">Home</a></li>
                        <?php endif; ?>
                        <li class="breadcrumb-item"><a href="<?= BASEURL ?>/frekuensi">Jadwal Praktikum</a></li>
                        <li class="breadcrumb-item active"><?= $data['title']; ?></li>
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
                            <a data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary shadow-sm" onclick="add('Mentoring', '<?= $data['frekuensi']['id_frekuensi']; ?>')">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                            <?php if ($_SESSION['role'] == 'Admin') : ?>
                                <!-- <a href="<?= BASEURL; ?>/mentoring/export_excel/<?= $data['frekuensi']['id_frekuensi']; ?>" class="btn btn-success shadow-sm ml-2">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </a> -->
                                <a href="<?= BASEURL; ?>/mentoring/export_pdf/<?= $data['detail']['id_frekuensi']; ?>" target="_blank" class="btn btn-danger shadow-sm ml-2">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="overflow-auto">
                            <div class="data-title d-flex justify-content-center align-items-center text-center" style="background: white; padding: 20px;">
                                <div>
                                    <img src="<?= BASEURL; ?>/public/img/UMI-logo.png" alt="Logo UMI" style="max-width: 80px; max-height: 80px;">
                                </div>
                                <div style="margin: 0 20px; width: 100%;">
                                    <strong>MONITORING PRAKTIKUM</strong><br>
                                    <strong>LABORATORIUM KOMPUTER - FAKULTAS ILMU KOMPUTER</strong><br>
                                    <strong>SEMESTER: <span><?= $data['detail']['semester']; ?> <?= $data['detail']['tahun_ajaran']; ?></span></strong>
                                </div>
                                <div>
                                    <img src="<?= BASEURL; ?>/public/img/ICLabs-logo.png" alt="Logo ICLabs" style="max-width: 80px; max-height: 80px;">
                                </div>
                            </div>
                                <!-- <div class="data-title d-flex flex-column justify-content-center align-items-center text-center">
                                    <img src="<?= BASEURL; ?>/public/img/UMI-logo.png" alt="Logo UMI" style="max-width: 80px; max-height: 80px;">
                                    <strong>MONITORING PRAKTIKUM</strong>
                                    <strong>LABORATORIUM KOMPUTER - FAKULTAS ILMU KOMPUTER</strong>
                                    <strong>SEMESTER <span>: <?= $data['detail']['semester']; ?> <?= $data['detail']['tahun_ajaran']; ?></span></strong>
                                    <img src="<?= BASEURL; ?>/public/img/ICLabs-logo.png" alt="Logo ICLabs" style="max-width: 80px; max-height: 80px;">
                                </div> -->
                                <!-- <br> -->
                                <div class="data-frekuensi d-flex flex-row justify-content-between mb-4 text-bold">
                                    <div class="column-1 d-flex flex-row gap-3">
                                        <div class="frek-header d-flex flex-column">
                                            <span>Kode Matakuliah</span> 
                                            <span>Nama Matakuliah</span> 
                                            <span>Frekuensi</span> 
                                            <span>Hari / Jam</span> 
                                        </div>
                                        <div class="frek-value d-flex flex-column">
                                            <span>: <?= $data['detail']['kode_matkul']; ?></span> 
                                            <span>: <?= $data['detail']['nama_matkul']; ?></span> 
                                            <span>: <?= $data['detail']['frekuensi']; ?></span> 
                                            <span>: <?= $data['detail']['hari']; ?>/<?= date('H:i', strtotime($data['detail']['jam_mulai'])); ?>-<?= date('H:i', strtotime($data['detail']['jam_selesai'])); ?></span>
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
                                            <span>: <?= $data['detail']['nama_ruangan']; ?></span> 
                                            <span>: <?= $data['detail']['nama_dosen']; ?></span> 
                                            <span>: <?= $data['detail']['asisten_1']; ?></span> 
                                            <span>: <?= $data['detail']['asisten_2']; ?></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="data-mentoring">
                                    <!-- <table id="example" class="table table-bordered"> -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center">
                                                <th style="text-align: center;" rowspan="2">NO</th>
                                                <th style="text-align: center;" rowspan="2">TANGGAL</th>
                                                <th style="text-align: center;" rowspan="2">URAIAN MATERI</th>
                                                <th style="text-align: center;" rowspan="2">URAIAN TUGAS</th>
                                                <th style="text-align: center;" colspan="2">KEHADIRAN</th>
                                                <th style="text-align: center;" colspan="4">TTD</th>
                                                <th style="text-align: center;" rowspan="2" class="d-print-none">AKSI</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td style="text-align: center;"><b>H</b></td>
                                                <td style="text-align: center;"><b>A</b></td>
                                                <td style="text-align: center;"><b>DOSEN</b></td>
                                                <td style="text-align: center;"><b>ASISTEN 1</b></td>
                                                <td style="text-align: center;"><b>ASISTEN 2</b></td>
                                                <td style="text-align: center;"><b>PENGGANTI</b></td>
                                            </tr>
                                        </thead>
                                            <tbody>
                                            <?php 
                                            $no = 0;
                                            if (!empty($data['mentoring'])): 
                                                foreach ($data['mentoring'] as $mentoring): 
                                                    $no++;?>
                                                    <tr class="table-row">
                                                        <td class="text-center"><?= $no;?></td>
                                                        <td class="text-center"><?= $mentoring['tanggal']; ?></td>
                                                        <td><?= $mentoring['uraian_materi']; ?></td>
                                                        <td><?= $mentoring['uraian_tugas']; ?></td>
                                                        <td class="text-center"><?= $mentoring['hadir']; ?></td>
                                                        <td class="text-center"><?= $mentoring['alpa']; ?></td>
                                                        
                                                        <td class="text-center">
                                                            <?php if ($mentoring['status_dosen'] === 'Hadir'): ?>
                                                                <img src="<?= BASEURL; ?>/<?= $data['detail']['photo_path'] ?>" alt="Foto" style="max-width: 80px; max-height: 80px;">
                                                            <?php else: ?>
                                                                <span>-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        
                                                        <td class="text-center">
                                                            <?php if ($mentoring['status_asisten1'] === 'Hadir'): ?>
                                                                <img src="<?= BASEURL; ?>/<?= $data['detail']['photo_path_asisten1'] ?>" alt="Foto" style="max-width: 80px; max-height: 80px;">
                                                            <?php else: ?>
                                                                <span>-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        
                                                        <td class="text-center">
                                                            <?php if ($mentoring['status_asisten2'] === 'Hadir'): ?>
                                                                <img src="<?= BASEURL; ?>/<?= $data['detail']['photo_path_asisten2'] ?>" alt="Foto" style="max-width: 80px; max-height: 80px;">
                                                            <?php else: ?>
                                                                <span>-</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        
                                                        <td class="text-center"><?= $mentoring['nama_asisten_pengganti']; ?></td>

                                                        <!-- PENAMBAHAN AKSI UBAH DAN HAPUS (rafli) -->

                                                        <td class="text-center d-print-none" style="white-space: nowrap;">
                                                            <a href="javascript:void(0);" 
                                                            class="btn btn-success btn-sm modalUbah me-1 mb-1"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#myModal"
                                                            data-id="<?= $mentoring['id_mentoring']; ?>"
                                                            onclick="change('Mentoring', <?= $mentoring['id_mentoring']; ?>)"
                                                            title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                            </a>

                                                            <a href="javascript:void(0);" 
                                                            class="btn btn-danger btn-sm me-1 mb-1"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#myModal"
                                                            onclick="hapusMentoring('<?= $mentoring['id_mentoring']; ?>', '<?= $data['detail']['id_frekuensi']; ?>')"
                                                            title="Hapus"> 
                                                            <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>

                                                        
                                                    </tr>
                                                <?php endforeach; 
                                            endif;  
                                            for ($i = $no + 1; $i <= 12; $i++): ?>
                                                <tr class="table-row">
                                                    <td class="text-center"><?= $i; ?></td>
                                                    <td class="text-center"></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center d-print-none"></td> 
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
