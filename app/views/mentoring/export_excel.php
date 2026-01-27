<?php 
error_reporting(0); 
function getImgBase64($path) {
    $absPath = $_SERVER['DOCUMENT_ROOT'] . '/monitoring-praktikum/' . $path;
    if (!empty($path) && file_exists($absPath)) {
        return 'data:image/png;base64,' . base64_encode(file_get_contents($absPath));
    }
    return '';
}
?>
<table border="1">
    <thead>
        <tr><th colspan="10" style="font-size: 14pt; font-weight: bold; text-align: center;">MONITORING PRAKTIKUM</th></tr>
        <tr><th colspan="10" style="text-align: center;">Mata Kuliah: <?= $data['detail']['nama_matkul']; ?> (<?= $data['detail']['kode_matkul']; ?>)</th></tr>
        <tr><th colspan="10" style="text-align: center;">Semester/Tahun: <?= $data['detail']['tahun_ajaran']; ?></th></tr>
        <tr></tr> <tr style="background-color: #f2f2f2; font-weight: bold;">
            <th rowspan="2">NO</th><th rowspan="2">TANGGAL</th><th rowspan="2">URAIAN MATERI</th><th rowspan="2">URAIAN TUGAS</th>
            <th colspan="2">KEHADIRAN</th><th colspan="4">TTD</th>
        </tr>
        <tr style="background-color: #f2f2f2; font-weight: bold;">
            <th>H</th><th>A</th><th>DOSEN</th><th>ASISTEN 1</th><th>ASISTEN 2</th><th>PENGGANTI</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 0;
        foreach($data['mentoring'] as $m) : $no++; ?>
        <tr>
            <td align="center"><?= $no; ?></td>
            <td align="center"><?= $m['tanggal']; ?></td>
            <td><?= $m['uraian_materi']; ?></td>
            <td><?= $m['uraian_tugas']; ?></td>
            <td align="center"><?= $m['hadir']; ?></td>
            <td align="center"><?= $m['alpa']; ?></td>
            <td align="center"><?php if($m['status_dosen'] == 'Hadir'): ?><img src="<?= getImgBase64($data['detail']['photo_path']); ?>" width="60"><?php endif; ?></td>
            <td align="center"><?php if($m['status_asisten1'] == 'Hadir'): ?><img src="<?= getImgBase64($data['detail']['photo_path_asisten1']); ?>" width="60"><?php endif; ?></td>
            <td align="center"><?php if($m['status_asisten2'] == 'Hadir'): ?><img src="<?= getImgBase64($data['detail']['photo_path_asisten2']); ?>" width="60"><?php endif; ?></td>
            <td><?= $m['nama_asisten_pengganti']; ?></td>
        </tr>
        <?php endforeach; ?>
        <?php for ($i = $no + 1; $i <= 12; $i++): ?>
            <tr><td align="center"><?= $i; ?></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        <?php endfor; ?>
    </tbody>
</table>