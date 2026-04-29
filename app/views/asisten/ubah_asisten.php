<div class="container">
    <form id="formUbahAsisten" action="<?= BASEURL?>/Asisten/prosesUbah" method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" value="<?= htmlspecialchars($data['ubahdata']['id_asisten'] ?? '', ENT_QUOTES, 'UTF-8')?>" name="id_asisten">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="stambuk" class="form-label">Stambuk</label>
                    <input type="text" name="stambuk" class="form-control " value="<?= htmlspecialchars($data['ubahdata']['stambuk'] ?? '', ENT_QUOTES, 'UTF-8')?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="nama_asisten" class="form-label">Nama Asisten</label>
                    <input type="text" name="nama_asisten" class="form-control " value="<?= htmlspecialchars($data['ubahdata']['nama_asisten'] ?? '', ENT_QUOTES, 'UTF-8')?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="angkatan" class="form-label">Angkatan</label>
                    <input type="text" name="angkatan" class="form-control " value="<?= htmlspecialchars($data['ubahdata']['angkatan'] ?? '', ENT_QUOTES, 'UTF-8')?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">Pilih Status</option>
                        <option value="Asisten" <?= isset($data['ubahdata']['status']) && $data['ubahdata']['status'] === 'Asisten' ? 'selected' : '' ?>>Asisten</option>
                        <option value="Calon Asisten" <?= isset($data['ubahdata']['status']) && $data['ubahdata']['status'] === 'Calon Asisten' ? 'selected' : '' ?>>Calon Asisten</option>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Pria" <?= isset($data['ubahdata']['jenis_kelamin']) && $data['ubahdata']['jenis_kelamin'] === 'Pria' ? 'selected' : '' ?>>Pria</option>
                        <option value="Wanita" <?= isset($data['ubahdata']['jenis_kelamin']) && $data['ubahdata']['jenis_kelamin'] === 'Wanita' ? 'selected' : '' ?>>Wanita</option>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="id_user" class="form-label">Username</label>
                    <select name="id_user" class="form-control ">
                        <?php
                        if (isset($data['userOptions']) && is_array($data['userOptions'])) {
                            foreach ($data['userOptions'] as $user) {
                                $selected = (isset($data['ubahdata']['id_user']) && $user['id_user'] == $data['ubahdata']['id_user']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($user['id_user'] ?? '', ENT_QUOTES, 'UTF-8') . "' {$selected}>" . htmlspecialchars($user['username'] ?? '', ENT_QUOTES, 'UTF-8') . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="formFile" class="form-label">Masukkan Foto Profil</label>
                    <input class="form-control" type="file" name="photo_profil" accept="image/jpeg,image/png,image/gif">
                    <small class="text-muted d-block mt-1">
                        Format: JPG, PNG, atau GIF | Maksimal: 5MB
                    </small>
                </div>
                <div class="form-group mb-3">
                    <label for="formFile" class="form-label">Masukkan Foto TTD</label>
                    <input class="form-control" type="file" name="photo_path" accept="image/jpeg,image/png,image/gif">
                    <small class="text-muted d-block mt-1">
                        Format: JPG, PNG, atau GIF | Maksimal: 5MB
                    </small>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Validasi file upload real-time
function validateImageFile(input) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    const maxSize = 5 * 1024 * 1024; // 5MB
    const fieldName = input.name === 'photo_profil' ? 'Foto Profil' : 'Foto TTD';
    
    if (input.files.length === 0) return true;
    
    const file = input.files[0];
    
    // Cek ukuran
    if (file.size > maxSize) {
        alert(`${fieldName}: Ukuran file terlalu besar! Maksimal 5MB (ukuran: ${(file.size / 1024 / 1024).toFixed(2)}MB)`);
        input.value = '';
        return false;
    }
    
    // Cek MIME type
    if (!allowedTypes.includes(file.type)) {
        alert(`${fieldName}: Format file tidak valid!\n\nFormat yang diizinkan:\n- JPG / JPEG\n- PNG\n- GIF\n\nFormat Anda: ${file.type || 'tidak terdeteksi'}`);
        input.value = '';
        return false;
    }
    
    return true;
}

// Event listener untuk field upload
document.querySelector('input[name="photo_profil"]')?.addEventListener('change', function() {
    validateImageFile(this);
});

document.querySelector('input[name="photo_path"]')?.addEventListener('change', function() {
    validateImageFile(this);
});

// Validasi form submit
document.getElementById('formUbahAsisten')?.addEventListener('submit', function(e) {
    const form = this;
    
    // Cek select fields tidak boleh kosong
    const statusSelect = document.querySelector('select[name="status"]');
    const jenisKelaminSelect = document.querySelector('select[name="jenis_kelamin"]');
    
    if (statusSelect && statusSelect.value === '') {
        alert('Status harus dipilih!');
        statusSelect.focus();
        e.preventDefault();
        return false;
    }
    
    if (jenisKelaminSelect && jenisKelaminSelect.value === '') {
        alert('Jenis Kelamin harus dipilih!');
        jenisKelaminSelect.focus();
        e.preventDefault();
        return false;
    }
    
    const photoProfile = document.querySelector('input[name="photo_profil"]');
    const photoPath = document.querySelector('input[name="photo_path"]');
    
    // Validasi file jika ada
    if (photoProfile.files.length > 0 && !validateImageFile(photoProfile)) {
        e.preventDefault();
        return false;
    }
    
    if (photoPath.files.length > 0 && !validateImageFile(photoPath)) {
        e.preventDefault();
        return false;
    }
    
    return true;
});
</script>