<div class="container">
    <form id="formUbahMatakuliah" action="<?= BASEURL?>/Matakuliah/prosesUbah" method="post" autocomplete="off">
    <input type="hidden" value="<?= $data['ubahdata']['id_matkul']?>" name="id_matkul">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="kode_matkul" class="form-label">Kode Matakuliah</label>
                    <input type="text" name="kode_matkul" class="form-control " value="<?= $data['ubahdata']['kode_matkul']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="nama_matkul" class="form-label">Matakuliah</label>
                    <input type="text" name="nama_matkul" class="form-control " value="<?= $data['ubahdata']['nama_matkul']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="singkatan" class="form-label">Singkatan</label>
                    <input type="text" name="singkatan" class="form-control " value="<?= $data['ubahdata']['singkatan']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="semester" class="form-label">Semester</label>
                    <select name="semester" id="semester" class="form-control" required>
                        <option value="">Pilih Semester</option>
                        <option value="GANJIL" <?= isset($data['ubahdata']['semester']) && $data['ubahdata']['semester'] === 'GANJIL' ? 'selected' : '' ?>>GANJIL</option>
                        <option value="GENAP" <?= isset($data['ubahdata']['semester']) && $data['ubahdata']['semester'] === 'GENAP' ? 'selected' : '' ?>>GENAP</option>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" name="sks" class="form-control " value="<?= $data['ubahdata']['sks']?>" >
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