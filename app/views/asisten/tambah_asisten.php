
<form id="formTambahDataAsisten" action="<?= BASEURL ?>/Asisten/tambah" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">            
            <!-- Data User (Login) -->
            <div class="alert alert-info py-2 mb-3"><small><strong>Data Login Akun</strong></small></div>
            
            <div class="form-group mb-3">
                <label for="username" class="form-label">Username (Email)</label>
                <input type="text" name="username" class="form-control" placeholder="Contoh: nama@student.umi.ac.id" required>
                <!-- Menambahkan Helper Text untuk Validasi Domain -->
                <small class="text-muted d-block mt-1">
                    Akhiran yang diizinkan: 
                    <span class="badge badge-light text-dark border">.iclabs@umi.ac.id</span>
                    <span class="badge badge-light text-dark border">@student.umi.ac.id</span>
                    <span class="badge badge-light text-dark border">@umi.ac.id</span>
                    <span class="badge badge-light text-dark border">@gmail.com</span>
                </small>
            </div>
            
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <!-- Hapus 'required' dan update placeholder -->
                <input type="password" name="password" class="form-control" placeholder="(Opsional) Kosongkan untuk password default: iclabs-umi">
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