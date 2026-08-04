<?php if (!empty($data['laporan']) && is_array($data['laporan'])) : ?>
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
        <td><?= e($row['prodi']) ?></td>
        <td class="text-left"><?= e($row['nama_matkul']) ?></td>
        <td><?= e($row['kelas']) ?></td>
        <td><?= e($row['frekuensi']) ?></td>
        <td><?= e($row['hari']) ?>, <?= e($row['jam_mulai']) ?>-<?= e($row['jam_selesai']) ?></td>
        <td><?= e($row['nama_ruangan']) ?></td>
        <td><?= e($row['nama_dosen']) ?></td>
        <td><?= e($row['asisten1']) ?></td>
        <td><?= e($row['asisten2']) ?></td>
        <td><b><?= e($total) ?></b></td>
        
        <td class="bg-light"><?= e($h_dosen) ?></td>
        <td class="bg-light"><?= e($th_dosen) ?></td>
        <td class="bg-light"><b><?= number_format($p_dosen, 0); ?>%</b></td>
        
        <td><?= e($h_asis1) ?></td>
        <td><?= e($th_asis1) ?></td>
        <td><b><?= number_format($p_asis1, 0); ?>%</b></td>
        
        <td class="bg-light"><?= e($h_asis2) ?></td>
        <td class="bg-light"><?= e($th_asis2) ?></td>
        <td class="bg-light"><b><?= number_format($p_asis2, 0); ?>%</b></td>
    </tr>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="21" class="text-center">Data tidak ditemukan</td>
    </tr>
<?php endif; ?>