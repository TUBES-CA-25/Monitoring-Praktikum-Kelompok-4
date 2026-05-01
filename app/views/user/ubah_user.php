<div class="container">
    <?php if (isset($data['ubahdata'])) : ?>
    <form id="formUbahUser" action="<?= BASEURL ?>/User/prosesUbah" method="post" autocomplete="off" enctype="multipart/form-data">
        
        <!-- Hidden ID -->
        <input type="hidden" value="<?= $data['ubahdata']['id_user'] ?>" name="id_user">
        <input type="hidden" value="<?= $data['ubahdata']['role'] ?>" name="role">

        <div class="row">
            <div class="col-12">
                <div class="form-group mb-3">
                    <label for="nama_user" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_user" class="form-control" 
                           value="<?= htmlspecialchars($data['ubahdata']['nama_user'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="username" class="form-label">Username (Email)</label>
                    <input type="text" name="username" class="form-control" 
                           value="<?= htmlspecialchars($data['ubahdata']['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">Ganti Password</label>
                    <div class="input-group">
                        <input id="passwordInput" type="password" name="password" class="form-control" 
                               placeholder="Kosongkan jika tidak ingin ganti password">
                        <button id="togglePassword" type="button" class="btn btn-outline-secondary">
                            <i class="fa fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    <small class="text-muted italic">Sistem menggunakan enkripsi SHA-256 otomatis.</small>
                </div>

                <?php if ($_SESSION['role'] == 'Admin') : ?>
                <div class="form-group mb-3">
                    <label for="role" class="form-label">Hak Akses (Role)</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="Asisten" <?= ($data['ubahdata']['role'] == 'Asisten') ? 'selected' : '' ?>>Asisten</option>
                        <option value="Admin" <?= ($data['ubahdata']['role'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                <?php endif; ?>

                <!-- EDIT FOTO PROFIL -->
                <div class="form-group mb-3">
                    <label for="photo_profil" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" name="photo_profil" accept="image/*"> 
                    <div class="mt-2">
                        <small class="text-muted d-block">File saat ini: <?= basename($data['ubahdata']['photo_profil'] ?? 'default.jpg') ?></small>
                        <?php if(!empty($data['ubahdata']['photo_profil'])): ?>
                            <img src="<?= BASEURL . '/' . $data['ubahdata']['photo_profil'] ?>" alt="Profil" class="img-thumbnail" width="80">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- EDIT FOTO TTD -->
                <div class="form-group mb-4">
                    <label for="photo_path" class="form-label">Tanda Tangan Digital (TTD)</label>
                    <input type="file" class="form-control" name="photo_path" accept="image/*"> 
                    <div class="mt-2">
                        <small class="text-muted d-block">File saat ini: <?= basename($data['ubahdata']['photo_path'] ?? 'Tidak ada') ?></small>
                        <?php if(!empty($data['ubahdata']['photo_path'])): ?>
                            <img src="<?= BASEURL . '/' . $data['ubahdata']['photo_path'] ?>" alt="TTD" class="img-thumbnail" width="120">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="text-center border-top pt-3">
                    <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </form>
    <?php else: ?>
        <div class="alert alert-danger">Data user tidak ditemukan atau gagal dimuat.</div>
    <?php endif; ?>
</div>

<script>
    // Toggle Password
    document.getElementById('togglePassword')?.addEventListener('click', function () {
        const passwordInput = document.getElementById('passwordInput');
        const icon = document.getElementById('eyeIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>