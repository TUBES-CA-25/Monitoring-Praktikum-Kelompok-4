<div class="content-wrapper">
    <?= Flasher::flash(); ?>
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
                        <table class="table table-bordered table-striped text-xs text-center">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th rowspan="2" style="vertical-align:middle">No</th>
                                    <th rowspan="2" style="vertical-align:middle">Prodi</th>
                                    <th rowspan="2" style="vertical-align:middle">Mata Kuliah</th>
                                    <th rowspan="2" style="vertical-align:middle">Kelas</th>
                                    <th rowspan="2" style="vertical-align:middle">Frekuensi</th>
                                    <th rowspan="2" style="vertical-align:middle">Jadwal</th>
                                    <th rowspan="2" style="vertical-align:middle">Ruangan</th>
                                    <th rowspan="2" style="vertical-align:middle">Dosen</th>
                                    <th rowspan="2" style="vertical-align:middle">Asisten 1</th>
                                    <th rowspan="2" style="vertical-align:middle">Asisten 2</th>
                                    <th rowspan="2" style="vertical-align:middle">Total Pert.</th>
                                    <th colspan="3">Dosen</th>
                                    <th colspan="3">Asisten 1</th>
                                    <th colspan="3">Asisten 2</th>
                                </tr>
                                <tr>
                                    <th>H</th><th>TH</th><th>%</th>
                                    <th>H</th><th>TH</th><th>%</th>
                                    <th>H</th><th>TH</th><th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($data['laporan'] as $row) : 
                                    // Inisialisasi Data dari Model
                                    $total = (int)$row['total_pertemuan'];
                                    $h_dosen = (int)$row['hadir_dosen'];
                                    $h_asis1 = (int)$row['hadir_asisten1'];
                                    $h_asis2 = (int)$row['hadir_asisten2'];

                                    // Hitung Tidak Hadir (TH)
                                    $th_dosen = $total - $h_dosen;
                                    $th_asis1 = $total - $h_asis1;
                                    $th_asis2 = $total - $h_asis2;

                                    // Hitung Persentase (%)
                                    $p_dosen = ($total > 0) ? ($h_dosen / $total) * 100 : 0;
                                    $p_asis1 = ($total > 0) ? ($h_asis1 / $total) * 100 : 0;
                                    $p_asis2 = ($total > 0) ? ($h_asis2 / $total) * 100 : 0;
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
                                    
                                    <td class="bg-light"><?= $h_dosen; ?></td>
                                    <td class="bg-light"><?= $th_dosen; ?></td>
                                    <td class="bg-light"><b><?= number_format($p_dosen, 0); ?>%</b></td>
                                    
                                    <td><?= $h_asis1; ?></td>
                                    <td><?= $th_asis1; ?></td>
                                    <td><b><?= number_format($p_asis1, 0); ?>%</b></td>
                                    
                                    <td class="bg-light"><?= $h_asis2; ?></td>
                                    <td class="bg-light"><?= $th_asis2; ?></td>
                                    <td class="bg-light"><b><?= number_format($p_asis2, 0); ?>%</b></td>
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