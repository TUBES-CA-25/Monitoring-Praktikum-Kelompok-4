<style>
    @media print {
        /* Sembunyikan elemen navigasi AdminLTE */
        .main-sidebar, .main-header, .main-footer, .breadcrumb, .btn, .card-header {
            display: none !important;
        }
        /* Hilangkan margin/padding bawaan template agar konten memenuhi kertas */
        .content-wrapper {
            margin-left: 0 !important;
            padding-top: 0 !important;
            background-color: white !important;
        }
        @page {
            size: landscape; /* Mengatur orientasi landscape sesuai Control+P */
            margin: 10mm;
        }
        /* Pastikan tabel memiliki garis hitam yang jelas untuk hasil print */
        .table-bordered th, .table-bordered td {
            border: 1px solid #000 !important;
        }
    }
    /* Tambahan agar gambar TTD tidak terpotong saat di-print */
    img {
        max-width: 60px;
        max-height: 60px;
    }
</style>

<script>
    // Langsung memicu dialog Control + P saat halaman terbuka
    window.print();
    // Otomatis menutup tab setelah selesai print
    window.onafterprint = function() { window.close(); };
</script>

<div class="container-fluid">
    <div class="data-title d-flex justify-content-center align-items-center text-center mb-4">
        <img src="<?= BASEURL; ?>/public/img/UMI-logo.png" width="80">
        <div style="width: 100%;">
            <strong>MONITORING PRAKTIKUM</strong><br>
            <strong>LABORATORIUM KOMPUTER - FAKULTAS ILMU KOMPUTER</strong><br>
            <strong>SEMESTER: <?= $data['detail']['tahun_ajaran']; ?></strong>
        </div>
        <img src="<?= BASEURL; ?>/public/img/ICLabs-logo.png" width="80">
    </div>

    <div class="row mb-3" style="font-weight: bold;">
        <div class="col-6">
            Kode Matakuliah : <?= $data['detail']['kode_matkul']; ?><br>
            Nama Matakuliah : <?= $data['detail']['nama_matkul']; ?><br>
            Frekuensi : <?= $data['detail']['frekuensi']; ?>
        </div>
        <div class="col-6 text-right">
            Ruangan : <?= $data['detail']['nama_ruangan']; ?><br>
            Dosen : <?= $data['detail']['nama_dosen']; ?><br>
            Jadwal : <?= $data['detail']['hari']; ?>/<?= date('H:i', strtotime($data['detail']['jam_mulai'])); ?>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="text-center" style="background-color: #f2f2f2 !important;">
            <tr>
                <th rowspan="2" style="vertical-align: middle;">NO</th>
                <th rowspan="2" style="vertical-align: middle;">TANGGAL</th>
                <th rowspan="2" style="vertical-align: middle;">URAIAN MATERI</th>
                <th rowspan="2" style="vertical-align: middle;">URAIAN TUGAS</th>
                <th colspan="2">KEHADIRAN</th>
                <th colspan="4">TTD</th>
            </tr>
            <tr>
                <th>H</th>
                <th>A</th>
                <th>DOSEN</th>
                <th>ASISTEN 1</th>
                <th>ASISTEN 2</th>
                <th>PENGGANTI</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 0; 
            if (!empty($data['mentoring'])):
                foreach($data['mentoring'] as $m) : 
                    $no++; ?>
                <tr>
                    <td class="text-center"><?= $no; ?></td>
                    <td class="text-center"><?= $m['tanggal']; ?></td>
                    <td><?= $m['uraian_materi']; ?></td>
                    <td><?= $m['uraian_tugas']; ?></td>
                    <td class="text-center"><?= $m['hadir']; ?></td>
                    <td class="text-center"><?= $m['alpa']; ?></td>
                    <td class="text-center">
                        <?php if($m['status_dosen']=='Hadir'): ?>
                            <img src="<?= BASEURL.'/'.$data['detail']['photo_path']; ?>">
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($m['status_asisten1']=='Hadir'): ?>
                            <img src="<?= BASEURL.'/'.$data['detail']['photo_path_asisten1']; ?>">
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($m['status_asisten2']=='Hadir'): ?>
                            <img src="<?= BASEURL.'/'.$data['detail']['photo_path_asisten2']; ?>">
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?= $m['nama_asisten_pengganti']; ?></td>
                </tr>
                <?php endforeach; 
            endif; ?>

            <?php for($i = $no + 1; $i <= 12; $i++) : ?>
                <tr style="height: 45px;">
                    <td class="text-center"><?= $i; ?></td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <div class="mt-4 float-right text-center" style="width: 250px;">
        Makassar, <?= date('d F Y'); ?><br>
        Mengetahui,<br>
        Koordinator Laboratorium<br><br><br><br><br>
        ( _________________________ )
    </div>
</div>