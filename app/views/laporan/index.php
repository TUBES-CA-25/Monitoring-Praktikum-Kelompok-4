<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $data['title']; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rekapitulasi Kehadiran Praktikum</h3>
<div class="card-tools">
    <form action="<?= BASEURL; ?>/Laporan" method="post" class="form-inline">
        <select name="id_tahun_filter" class="form-control form-control-sm mr-2">
            <option value="">-- Pilih Tahun Ajaran --</option>
            <?php foreach ($data['ajaranOptions'] as $ajaran) : ?>
                <option value="<?= $ajaran['id_tahun']; ?>" <?= ($data['tahun_aktif'] == $ajaran['id_tahun']) ? 'selected' : ''; ?>>
                    <?= $ajaran['tahun_ajaran']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-info btn-sm"><i class="fas fa-filter"></i> Filter</button>
        
        <?php if($data['tahun_aktif']) : ?>
            <button type="submit" name="export_excel" class="btn btn-success btn-sm ml-1">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        <?php endif; ?>
        
        <a href="<?= BASEURL; ?>/Laporan" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>
    </form>
</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-sm text-center">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Prodi</th>
                                    <th>Mata Kuliah</th>
                                    <th>Kelas</th>
                                    <th>Frekuensi</th>
                                    <th>Jadwal</th>
                                    <th>Ruangan</th>
                                    <th>Dosen</th>
                                    <th>Asisten 1</th>
                                    <th>Asisten 2</th>
                                    <th>Total Pert.</th>
                                    <th>Hadir Dosen</th>
                                    <th>Tdk Hadir Dosen</th>
                                    <th>% Dosen</th>
                                    <th>Hadir Asis 1</th>
                                    <th>Tdk Hadir Asis 1</th>
                                    <th>% Asis 1</th>
                                    <th>Hadir Asis 2</th>
                                    <th>Tdk Hadir Asis 2</th>
                                    <th>% Asis 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($data['laporan'] as $row) : 
                                    $total = $row['total_pertemuan'];
                                    
                                    // Hitung Tidak Hadir (Total - Hadir)
                                    $tdk_hadir_dosen = $total - $row['hadir_dosen'];
                                    $tdk_hadir_asis1 = $total - $row['hadir_asisten1'];
                                    $tdk_hadir_asis2 = $total - $row['hadir_asisten2'];

                                    // Hitung Persentase
                                    $p_dosen = ($total > 0) ? ($row['hadir_dosen'] / $total) * 100 : 0;
                                    $p_asis1 = ($total > 0) ? ($row['hadir_asisten1'] / $total) * 100 : 0;
                                    $p_asis2 = ($total > 0) ? ($row['hadir_asisten2'] / $total) * 100 : 0;
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['prodi']; ?></td>
                                    <td class="text-left"><?= $row['nama_matkul']; ?></td>
                                    <td><?= $row['kelas']; ?></td>
                                    <td><?= $row['frekuensi']; ?></td>
                                    <td><?= $row['hari']; ?>, <?= $row['jam_mulai']; ?>-<?= $row['jam_selesai']; ?></td>
                                    <td><?= $row['nama_ruangan']; ?></td>
                                    <td><?= $row['nama_dosen']; ?></td>
                                    <td><?= $row['asisten1']; ?></td>
                                    <td><?= $row['asisten2']; ?></td>
                                    <td><b><?= $total; ?></b></td>
                                    <td><?= $row['hadir_dosen']; ?></td>
                                    <td><?= $tdk_hadir_dosen; ?></td>
                                    <td><?= number_format($p_dosen, 0); ?>%</td>
                                    <td><?= $row['hadir_asisten1']; ?></td>
                                    <td><?= $tdk_hadir_asis1; ?></td>
                                    <td><?= number_format($p_asis1, 0); ?>%</td>
                                    <td><?= $row['hadir_asisten2']; ?></td>
                                    <td><?= $tdk_hadir_asis2; ?></td>
                                    <td><?= number_format($p_asis2, 0); ?>%</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>