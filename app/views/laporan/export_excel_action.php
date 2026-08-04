<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap_Kehadiran_".$data['tahun_aktif'].".xls");
?>

<center>
    <h3>REKAPITULASI KEHADIRAN PRAKTIKUM</h3>
</center>

<table border="1">
    <thead>
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
            <th>Hadir Asisten 1</th>
            <th>Tdk Hadir Asisten 1</th>
            <th>% Asisten 1</th>
            <th>Hadir Asisten 2</th>
            <th>Tdk Hadir Asisten 2</th>
            <th>% Asisten 2</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data['laporan'] as $row) : 
            $total = $row['total_pertemuan'];
            $th_dosen = $total - $row['hadir_dosen'];
            $th_asis1 = $total - $row['hadir_asisten1'];
            $th_asis2 = $total - $row['hadir_asisten2'];

            $p_dosen = ($total > 0) ? ($row['hadir_dosen'] / $total) * 100 : 0;
            $p_asis1 = ($total > 0) ? ($row['hadir_asisten1'] / $total) * 100 : 0;
            $p_asis2 = ($total > 0) ? ($row['hadir_asisten2'] / $total) * 100 : 0;
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= e($row['prodi']) ?></td>
            <td><?= e($row['nama_matkul']) ?></td>
            <td><?= e($row['kelas']) ?></td>
            <td><?= e($row['frekuensi']) ?></td>
            <td><?= e($row['hari']) ?>, <?= e($row['jam_mulai']) ?></td>
            <td><?= e($row['nama_ruangan']) ?></td>
            <td><?= e($row['nama_dosen']) ?></td>
            <td><?= e($row['asisten1']) ?></td>
            <td><?= e($row['asisten2']) ?></td>
            <td><?= e($total) ?></td>
            <td><?= e($row['hadir_dosen']) ?></td>
            <td><?= e($th_dosen) ?></td>
            <td><?= number_format($p_dosen, 0); ?>%</td>
            <td><?= e($row['hadir_asisten1']) ?></td>
            <td><?= e($th_asis1) ?></td>
            <td><?= number_format($p_asis1, 0); ?>%</td>
            <td><?= e($row['hadir_asisten2']) ?></td>
            <td><?= e($th_asis2) ?></td>
            <td><?= number_format($p_asis2, 0); ?>%</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>