<form id="formTambahDataAsisten" action="<?= BASEURL ?>/asisten/tambah" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">            
            
            <!-- Data User (Login) -->
            <div class="alert alert-info py-2 mb-3"><small><strong>Data Login Akun</strong></small></div>
            
            <div class="form-group mb-3">
                <label for="usernameInput" class="form-label">Username (Email)</label>
                <input type="email" name="username" id="usernameInput" class="form-control" placeholder="Contoh: nama@student.umi.ac.id" value="<?= $_SESSION['old']['username'] ?? '' ?>" required>
                <!-- Helper Text -->
                <small class="text-muted d-block mt-1">
                    Akhiran yang diizinkan: 
                    <span class="badge badge-light text-dark border">.iclabs@umi.ac.id</span>
                    <span class="badge badge-light text-dark border">@student.umi.ac.id</span>
                    <span class="badge badge-light text-dark border">@umi.ac.id</span>
                    <span class="badge badge-light text-dark border">@gmail.com</span>
                </small>
                <!-- Tempat Pesan Error muncul -->
                <small id="emailError" class="text-danger font-italic" style="display:none;"></small>
            </div>
            
            <!-- INPUT PASSWORD DENGAN FITUR SHOW/HIDE -->
            <div class="form-group mb-3">
                <label for="passwordInput" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="(Opsional) Default: iclabs-umi">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Data Profil Asisten -->
            <div class="alert alert-info py-2 mb-3"><small><strong>Data Profil Asisten</strong></small></div>

            <div class="form-group mb-3">
                <label for="stambuk" class="form-label">Stambuk</label>
                <input type="text" name="stambuk" class="form-control" placeholder="Masukkan Stambuk" required>
            </div>
            <div class="form-group mb-3">
                <label for="nama_asisten" class="form-label">Nama Asisten</label>
                <input type="text" name="nama_asisten" class="form-control" placeholder="Masukkan Nama Lengkap" required>
            </div>
            <div class="form-group mb-3">
                <label for="angkatan" class="form-label">Angkatan</label>
                <input type="text" name="angkatan" class="form-control" placeholder="Masukkan Angkatan" required>
            </div>
            <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">Pilih Status</option>
                        <option value="Asisten">Asisten</option>
                        <option value="Calon Asisten">Calon Asisten</option>
                    </select>
            </div>
            <div class="form-group mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
            </div>

            <div class="form-group mb-3">
                <label for="formFile" class="form-label">Masukkan Foto Profil</label>
                <input class="form-control " type="file" name="photo_profil">
            </div>
            <div class="form-group mb-3">
                <label for="formFile" class="form-label">Masukkan Foto TTD</label>
                <input class="form-control " type="file" name="photo_path">
            </div><br>
        </div>
    </div>
</form>
<?php unset($_SESSION['old']); ?>