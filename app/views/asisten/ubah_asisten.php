<div class="container">
    <form id="formUbahAsisten" action="<?= BASEURL?>/Asisten/prosesUbah" method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" value="<?= $data['ubahdata']['id_asisten']?>" name="id_asisten">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="stambuk" class="form-label">Stambuk</label>
                    <input type="text" name="stambuk" class="form-control " value="<?= $data['ubahdata']['stambuk']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="nama_asisten" class="form-label">Nama Asisten</label>
                    <input type="text" name="nama_asisten" class="form-control " value="<?= $data['ubahdata']['nama_asisten']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="angkatan" class="form-label">Angkatan</label>
                    <input type="text" name="angkatan" class="form-control " value="<?= $data['ubahdata']['angkatan']?>" >
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
                        foreach ($data['userOptions'] as $user) {
                            $selected = ($user['id_user'] == $data['ubahdata']['id_user']) ? 'selected' : '';
                            echo "<option value='{$user['id_user']}' {$selected}>{$user['username']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="formFile" class="form-label">Masukkan Foto Profil</label>
                    <input class="form-control " type="file" name="photo_profil">
                </div>
                <div class="form-group mb-3">
                    <label for="formFile" class="form-label">Masukkan Foto</label>
                    <input class="form-control " type="file" name="photo_path">
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