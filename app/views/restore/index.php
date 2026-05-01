<?php
$rows = $data['restore'] ?? [];
$title = $data['judul'] ?? 'Restore Data';
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
            <!-- Flash Message -->
            <div class="row">
                <div class="col-12">
                    <?php Flasher::flash(); ?>
                </div>
            </div>

            <?php if (!empty($rows)): ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-trash-alt"></i> Daftar Data yang Dihapus
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-warning"><?= count($rows) ?> data ditemukan</span>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-hover m-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 25%">Identitas Data</th>
                                    <th style="width: 15%">Jenis Data</th>
                                    <th style="width: 18%">Waktu Hapus</th>
                                    <th style="width: 19%; text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($rows as $r): ?>
                                    <?php 
                                        // Sesuaikan dengan nama kolom di tabel trs_restore[cite: 1]
                                        $isi = json_decode($r['data_json'], true); 
                                        $id = $r['id_restore']; // Gunakan id_restore sesuai DB[cite: 1]
                                    ?>
                                    <tr>
                                        <td><strong><?= $no++ ?></strong></td>
                                        <td>
                                            <strong class="text-primary">
                                                <!-- Menampilkan Nama Asisten dari dalam JSON -->
                                                <?= $isi['nama_asisten'] ?? 'Data Tidak Dikenal' ?>
                                            </strong>
                                            <br>
                                            <small class="text-muted">Stambuk: <?= $isi['stambuk'] ?? '-' ?></small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                <?= htmlspecialchars($r['jenis_data']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small>
                                                <?= date('d/m/Y H:i', strtotime($r['deleted_at'])) ?>
                                            </small>
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="btn-group btn-group-sm">
                                                <!-- Tombol Lihat Detail -->
                                                <button type="button" class="btn btn-info" 
                                                        data-toggle="modal" data-target="#modal-detail-<?= $id ?>">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>
                                                <!-- Tombol Restore (Redirect ke controller method kembalikan) -->
                                                <a href="<?= BASEURL; ?>/restore/kembalikan/<?= $id ?>" 
                                                   class="btn btn-success" 
                                                   onclick="return confirm('Kembalikan data ini?')">
                                                    <i class="fas fa-redo-alt"></i> Restore
                                                </a>
                                                <!-- Tombol Hapus (Redirect ke controller method hapusPermanen) -->
                                                <a href="<?= BASEURL; ?>/restore/hapusPermanen/<?= $id ?>" 
                                                   class="btn btn-danger" 
                                                   onclick="return confirm('Hapus permanen dari sistem?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="modal-detail-<?= $id ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h5 class="modal-title text-white">Detail Data JSON</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Raw Data JSON:</strong></p>
                                                    <pre class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto; font-size: 12px;"><?= htmlspecialchars(json_encode($isi, JSON_PRETTY_PRINT)) ?></pre>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Tidak ada data di tempat sampah.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>