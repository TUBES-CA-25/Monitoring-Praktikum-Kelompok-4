<?php

$rows = $data['restore'] ?? [];
$title = $data['title'] ?? 'Restore Data';
?>
<div class="container mt-4">
    <h1 class="mb-3"><?= htmlspecialchars($title) ?></h1>

    <?php if (class_exists('Flasher')) { Flasher::flash(); } ?>

    <?php if (!empty($rows)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama Data</th>
                        <th scope="col">Jenis Data</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col">Deleted By</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r): ?>
                        <?php if (is_object($r)) { $r = (array) $r; } ?>
                        <tr>
                            <td><?= htmlspecialchars($r['id'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['nama_data'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['jenis_data'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['deleted_at'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['deleted_by'] ?? '') ?></td>
                            <td>
                                <a href="<?= htmlspecialchars(BASEURL . '/restore/restore/' . rawurlencode($r['id'] ?? '')) ?>"
                                   class="btn btn-sm btn-success"
                                   onclick="return confirm('Restore data ini?')">Restore</a>

                                <a href="<?= htmlspecialchars(BASEURL . '/restore/deletePermanent/' . rawurlencode($r['id'] ?? '')) ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Hapus permanen data ini?')">Hapus Permanen</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Tidak ada data restore.</div>
    <?php endif; ?>
</div>
```// filepath: /Applications/XAMPP/xamppfiles/htdocs/monitoring-praktikum/app/views/restore/index.php
<?php

$rows = $data['restore'] ?? [];
$title = $data['title'] ?? 'Restore Data';
?>
<div class="container mt-4">
    <h1 class="mb-3"><?= htmlspecialchars($title) ?></h1>

    <?php if (class_exists('Flasher')) { Flasher::flash(); } ?>

    <?php if (!empty($rows)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama Data</th>
                        <th scope="col">Jenis Data</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col">Deleted By</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r): ?>
                        <?php if (is_object($r)) { $r = (array) $r; } ?>
                        <tr>
                            <td><?= htmlspecialchars($r['id'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['nama_data'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['jenis_data'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['deleted_at'] ?? '') ?></td>
                            <td><?= htmlspecialchars($r['deleted_by'] ?? '') ?></td>
                            <td>
                                <a href="<?= htmlspecialchars(BASEURL . '/restore/restore/' . rawurlencode($r['id'] ?? '')) ?>"
                                   class="btn btn-sm btn-success"
                                   onclick="return confirm('Restore data ini?')">Restore</a>

                                <a href="<?= htmlspecialchars(BASEURL . '/restore/deletePermanent/' . rawurlencode($r['id'] ?? '')) ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Hapus permanen data ini?')">Hapus Permanen</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Tidak ada data restore.</div>
    <?php endif; ?>
</div>