<div class="container">
    <form id="formTambahDataMatakuliah" action="<?= BASEURL ?>/Matakuliah/tambah" method="post" autocomplete="off">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-3">
                    <label for="kode_matkul" class="form-label">Kode Matakuliah</label>
                    <input type="text" name="kode_matkul" class="form-control " placeholder="Masukkan Kode Matakuliah" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nama_matkul" class="form-label">Matakuliah</label>
                    <input type="text" name="nama_matkul" class="form-control " placeholder="Masukkan Matakuliah" required>
                </div>
                <div class="form-group mb-3">
                    <label for="singkatan" class="form-label">Singkatan</label>
                    <input type="text" name="singkatan" class="form-control " placeholder="Masukkan Singkatan" required>
                </div>
                <div class="form-group mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select name="semester" id="semester" class="form-control" required>
                        <option value="">Pilih Semester</option>
                        <option value="GANJIL">GANJIL</option>
                        <option value="GENAP">GENAP</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" name="sks" class="form-control " placeholder="Masukkan SKS" required>
                </div><br>
            </div>
        </div>
    </form>
</div>