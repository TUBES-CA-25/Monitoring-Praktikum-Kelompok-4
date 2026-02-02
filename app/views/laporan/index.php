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
                        <div class="form-inline">
                            <select name="id_tahun_filter" id="tahun_filter" class="form-control form-control-sm mr-2">
                                <option value="">-- Semua Tahun Ajaran --</option>
                                <?php foreach ($data['ajaranOptions'] as $ajaran) : ?>
                                    <option value="<?= $ajaran['id_tahun']; ?>" <?= ($data['tahun_aktif'] == $ajaran['id_tahun']) ? 'selected' : ''; ?>>
                                        <?= $ajaran['tahun_ajaran']; ?>
                                    </option>
                                <?php endforeach; ?>
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
                                <?php include 'table_body.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('#tahun_filter').on('change', function() {
        const idTahun = $(this).val() || 'null';
        
        $('#laporan_body').html('<tr><td colspan="20" class="text-center">Sedang memuat data...</td></tr>');

        $.ajax({
            url: '<?= BASEURL; ?>/Laporan/getTableByTahun/' + idTahun,
            type: 'GET',
            success: function(data) {
                $('#laporan_body').html(data);
            },
            error: function() {
                alert('Gagal mengambil data laporan.');
            }
        });
    });

    $('#btn_export').on('click', function() {
        const idTahun = $('#tahun_filter').val();
        
        const form = $('<form>', {
            method: 'POST',
            action: '<?= BASEURL; ?>/Laporan'
        });
        
        form.append($('<input>', { type: 'hidden', name: 'id_tahun_filter', value: idTahun }));
        form.append($('<input>', { type: 'hidden', name: 'export_excel', value: 'true' }));
        
        $('body').append(form);
        form.submit();
        form.remove();
    });
});
</script>