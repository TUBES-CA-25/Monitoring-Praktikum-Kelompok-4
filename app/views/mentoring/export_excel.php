<?php
// Menghilangkan error reporting agar file excel tidak korup oleh pesan warning
error_reporting(0);
?>
<table border="1">
    <thead>
        <tr>
            <th colspan="10" style="font-size: 14pt; font-weight: bold;">LAPORAN MONITORING PRAKTIKUM</th>
        </tr>
        <tr>
            <th colspan="10">Mata Kuliah: <?= $data['frekuensi']['nama_matkul']; ?> (<?= $data['frekuensi']['kode_matkul']; ?>)</th>
        </tr>
        <tr></tr> <tr style="background-color: #f2f2f2; font-weight: bold;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Uraian Materi</th>
            <th>Uraian Tugas</th>
            <th>Hadir</th>
            <th>Alpa</th>
            <th>Dosen</th>
            <th>Asisten 1</th>
            <th>Asisten 2</th>
            <th>Pengganti</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($data['mentoring'] as $m) : ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $m['tanggal']; ?></td>
            <td><?= $m['uraian_materi']; ?></td>
            <td><?= $m['uraian_tugas']; ?></td>
            <td align="center"><?= $m['hadir']; ?></td>
            <td align="center"><?= $m['alpa']; ?></td>
            <td align="center"><?= $m['status_dosen']; ?></td>
            <td align="center"><?= $m['status_asisten1']; ?></td>
            <td align="center"><?= $m['status_asisten2']; ?></td>
            <td><?= $m['nama_asisten_pengganti']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>