<div class="container">
    <?php if (isset($data['ubahdata'])) : ?>
    <form id="formUbahDataAsisten" action="<?= BASEURL ?>/asisten/prosesUbah" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">            
                <!-- Input Hidden ID -->
                <input type="hidden" name="id_asisten" value="<?= $data['ubahdata']['id_asisten'] ?? '' ?>">
                <input type="hidden" name="id_user" value="<?= $data['ubahdata']['id_user'] ?? '' ?>">
                
                <div class="alert alert-info py-2 mb-3"><small><strong>Data Login Akun</strong></small></div>
                
                <div class="form-group mb-3">
                    <label for="usernameInput" class="form-label">Username (Email)</label>
                    <input type="email" name="username" id="usernameInput" class="form-control" 
                        value="<?= htmlspecialchars($data['ubahdata']['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                
                <div class="form-group mb-3">
                    <label for="passwordInput" class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordInput" class="form-control" 
                               placeholder="Kosongkan jika tidak ingin mengubah password">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">Gunakan SHA-256 otomatis saat disimpan.</small>
                </div>

                <div class="alert alert-info py-2 mb-3"><small><strong>Data Profil Asisten</strong></small></div>

                <div class="form-group mb-3">
                    <label for="stambuk" class="form-label">Stambuk</label>
                    <input type="text" name="stambuk" class="form-control" 
                           value="<?= htmlspecialchars($data['ubahdata']['stambuk'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="nama_asisten" class="form-label">Nama Asisten</label>
                    <input type="text" name="nama_asisten" class="form-control" 
                           value="<?= htmlspecialchars($data['ubahdata']['nama_asisten'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <input type="text" name="angkatan" class="form-control" 
                                   value="<?= htmlspecialchars($data['ubahdata']['angkatan'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Asisten" <?= ($data['ubahdata']['status'] == 'Asisten') ? 'selected' : '' ?>>Asisten</option>
                                <option value="Calon Asisten" <?= ($data['ubahdata']['status'] == 'Calon Asisten') ? 'selected' : '' ?>>Calon Asisten</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="Pria" <?= ($data['ubahdata']['jenis_kelamin'] == 'Pria') ? 'selected' : '' ?>>Pria</option>
                                <option value="Wanita" <?= ($data['ubahdata']['jenis_kelamin'] == 'Wanita') ? 'selected' : '' ?>>Wanita</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                
                <!-- BAGIAN UPLOAD FOTO PROFIL -->
                <div class="form-group mb-3">
                    <label class="form-label">Ganti Foto Profil (Opsional)</label>
                    <input class="form-control" type="file" name="photo_profil" accept="image/*">
                    <small class="text-muted">File saat ini: <?= $data['ubahdata']['photo_profil'] ?? 'Tidak ada' ?></small>
                </div>

                <!-- BAGIAN UPLOAD FOTO TTD (YANG TADI TERLEWAT) -->
                <div class="form-group mb-3">
                    <label class="form-label">Ganti Foto TTD / Signature (Opsional)</label>
                    <input class="form-control" type="file" name="photo_path" accept="image/*">
                    <small class="text-muted">File saat ini: <?= $data['ubahdata']['photo_path'] ?? 'Tidak ada' ?></small>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    <a href="<?= BASEURL ?>/asisten" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </div>
        </div>
    </form>
    <?php endif; ?>
</div>

<script>
// Toggle Password Visibility
document.getElementById('togglePassword')?.addEventListener('click', function() {
    const pwdInput = document.getElementById('passwordInput');
    const icon = document.getElementById('eyeIcon');
    if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pwdInput.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});

// Validasi Form saat Submit (Ukuran & Format File)
document.getElementById('formUbahDataAsisten')?.addEventListener('submit', function(e) {
    const photoProfile = document.querySelector('input[name="photo_profil"]');
    const photoPath = document.querySelector('input[name="photo_path"]');
    
    const checkFile = (input, label) => {
        if (input.files.length > 0) {
            const file = input.files[0];
            const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            
            if (file.size > 5 * 1024 * 1024) {
                alert(`File ${label} terlalu besar! Maksimal 5MB.`);
                return false;
            }
            if (!allowed.includes(file.type)) {
                alert(`Format file ${label} tidak didukung! Gunakan JPG/PNG/GIF.`);
                return false;
            }
        }
        return true;
    };

    if (!checkFile(photoProfile, 'Foto Profil') || !checkFile(photoPath, 'Foto TTD')) {
        e.preventDefault();
        return false;
    }
});
</script>