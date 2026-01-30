<?php $no = 1; foreach ($data['laporan'] as $row) : 
    $total = (int)$row['total_pertemuan'];
    
    $h_dosen = (int)$row['hadir_dosen'];
    $th_dosen = $total - $h_dosen;
    $p_dosen = ($total > 0) ? ($h_dosen / $total) * 100 : 0;

    $h_asis1 = (int)$row['hadir_asisten1'];
    $th_asis1 = $total - $h_asis1;
    $p_asis1 = ($total > 0) ? ($h_asis1 / $total) * 100 : 0;

    $h_asis2 = (int)$row['hadir_asisten2'];
    $th_asis2 = $total - $h_asis2;
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