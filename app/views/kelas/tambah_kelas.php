<form id="formTambahDataKelas" action="<?= BASEURL ?>/Kelas/tambah" method="post" autocomplete="off">
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-1">
                <label for="id_jurusan" class="form-label">Jurusan</label>
                <select name="id_jurusan" class="form-control" required>
                    <option value="">Pilih Jurusan</option>
                    <?php foreach ($data['jurusanOptions'] as $jurusan) : ?>
                        <option value="<?= $jurusan['id_jurusan']; ?>"><?= $jurusan['jurusan']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" placeholder="Masukkan Kelas" required>
            </div>
            <div class="form-group mb-3">
                <label for="angkatan" class="form-label">Angkatan</label>
                <input type="number" name="angkatan" class="form-control" placeholder="Masukkan Angkatan" required>
            </div><br>
        </div>
    </div>
</form>