<form id="formTambahDataAsisten" action="<?= BASEURL ?>/Asisten/tambah" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">            
            <div class="form-group mb-3">
                <label for="stambuk" class="form-label">Stambuk</label>
                <input type="text" name="stambuk" class="form-control" placeholder="Masukkan Stambuk" required>
            </div>
            <div class="form-group mb-3">
                <label for="nama_asisten" class="form-label">Nama Asisten</label>
                <input type="text" name="nama_asisten" class="form-control" placeholder="Masukkan Asisten" required>
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
                        <option value="Calon">Calon</option>
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
            <div class="form-group mb-1">
                <label for="id_user" class="form-label">User</label>
                <select name="id_user" class="form-control" required>
                    <option value="">Pilih Nama User</option>
                    <?php foreach ($data['userOptions'] as $user) : ?>
                        <option value="<?= $user['id_user']; ?>"><?= $user['username']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="formFile" class="form-label">Masukkan Foto Profil</label>
                <input class="form-control " type="file" name="photo_profil">
            </div>
            <div class="form-group mb-3">
                <label for="formFile" class="form-label">Masukkan Foto</label>
                <input class="form-control " type="file" name="photo_path">
            </div><br>
        </div>
    </div>
</form>