<?php
// Include helper functions
require_once __DIR__ . '/_helpers.php';

$rows = $data['restore'] ?? [];
$title = $data['title'] ?? 'Restore Data';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-undo"></i> <?= htmlspecialchars($title) ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?php if (class_exists('Flasher')) { Flasher::flash(); } ?>

            <?php if (!empty($rows)): ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-trash-alt"></i> Daftar Data yang Dihapus
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-warning"><?= count($rows) ?> data</span>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-hover m-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 25%">Nama Data</th>
                                    <th style="width: 18%">Jenis Data</th>
                                    <th style="width: 18%">Waktu Hapus</th>
                                    <th style="width: 15%">Dihapus Oleh</th>
                                    <th style="width: 19%; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($rows as $r): ?>
                                    <?php if (is_object($r)) { $r = (array) $r; } ?>
                                    <tr>
                                        <td><strong><?= $no++ ?></strong></td>
                                        <td>
                                            <strong class="text-primary">
                                                <?= getDisplayName($r['data_json'] ?? '') ?>
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-info badge-lg">
                                                <?= $jenis_labels[$r['jenis_data']] ?? htmlspecialchars($r['jenis_data']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= isset($r['deleted_at']) ? date('d/m/Y H:i', strtotime($r['deleted_at'])) : '-' ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?= getUserNameById($r['deleted_by'] ?? 0) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-info btn-sm" 
                                                        data-toggle="modal" data-target="#modal-detail-<?= $r['id'] ?>">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                <button type="button" class="btn btn-success btn-sm" 
                                                        onclick="confirmRestore(<?= $r['id'] ?>)">
                                                    <i class="fas fa-redo-alt"></i> Restore
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        onclick="confirmDelete(<?= $r['id'] ?>)">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal untuk Detail Data -->
                                    <div class="modal fade" id="modal-detail-<?= $r['id'] ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h5 class="modal-title text-white">
                                                        <i class="fas fa-info-circle"></i> Detail Data: 
                                                        <?= getDisplayName($r['data_json'] ?? '') ?>
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <p><strong>Jenis Data:</strong></p>
                                                            <span class="badge badge-info badge-lg">
                                                                <?= $jenis_labels[$r['jenis_data']] ?? htmlspecialchars($r['jenis_data']) ?>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p><strong>Dihapus Oleh:</strong></p>
                                                            <p><?= getUserNameById($r['deleted_by'] ?? 0) ?></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p><strong>Waktu Hapus:</strong></p>
                                                            <p><?= isset($r['deleted_at']) ? date('d/m/Y H:i:s', strtotime($r['deleted_at'])) : '-' ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <p><strong>Data JSON:</strong></p>
                                                            <pre class="bg-light p-3 rounded" style="max-height: 400px; overflow-y: auto;">
<?= htmlspecialchars(json_encode(json_decode($r['data_json'] ?? '{}', true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?>
                                                            </pre>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                        <i class="fas fa-times"></i> Tutup
                                                    </button>
                                                    <button type="button" class="btn btn-success" 
                                                            onclick="confirmRestore(<?= $r['id'] ?>)">
                                                        <i class="fas fa-redo-alt"></i> Restore Sekarang
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle"></i>
                    <strong>Tidak ada data yang dihapus</strong>
                    <p class="mb-0">Semua data aman dan belum ada yang di-restore atau dihapus.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Form untuk Restore -->
<form id="form-restore" method="GET" style="display:none;"></form>

<!-- Form untuk Delete Permanen -->
<form id="form-delete" method="GET" style="display:none;"></form>

<!-- Define BASEURL for JavaScript -->
<script>
    const BASEURL = '<?= BASEURL ?>';
</script>

<!-- Load External CSS & JS -->
<link rel="stylesheet" href="<?= BASEURL ?>/public/css/restore.css">
<script src="<?= BASEURL ?>/public/js/restore.js"></script>