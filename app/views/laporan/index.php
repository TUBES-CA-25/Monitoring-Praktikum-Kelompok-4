<div class="content-wrapper">
    <?php if (class_exists('Flasher')) { Flasher::flash(); } ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= htmlspecialchars($data['title'] ?? 'Laporan'); ?></h1>
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
                        <div class="form-inline">
                            <select name="id_tahun_filter" id="tahun_filter" class="form-control form-control-sm mr-2">
                                <option value="">-- Semua Tahun Ajaran --</option>
                                <?php if (!empty($data['ajaranOptions']) && is_array($data['ajaranOptions'])): ?>
                                    <?php foreach ($data['ajaranOptions'] as $ajaran) : ?>
                                        <option value="<?= htmlspecialchars($ajaran['id_tahun'] ?? ''); ?>" <?= (($data['tahun_aktif'] ?? null) == ($ajaran['id_tahun'] ?? null)) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($ajaran['tahun_ajaran'] ?? ''); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            
                            <button type="button" id="btn_export" class="btn btn-success btn-sm ml-1">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            
                            <a href="<?= BASEURL; ?>/Laporan" class="btn btn-secondary btn-sm ml-1"><i class="fas fa-sync"></i> Reset</a>
                        </div>
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
                            <tbody id="laporan_body">
                                <?php if (!empty($data['laporan']) && is_array($data['laporan'])): ?>
                                    <?php include 'table_body.php'; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="21" class="text-center">Data laporan tidak ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>