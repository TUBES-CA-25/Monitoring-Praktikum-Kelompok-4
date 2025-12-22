<div class="container">
    <form id="formTambahDataJurusan" action="<?= BASEURL ?>/Jurusan/tambah" method="post" autocomplete="off">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <input type="text" name="jurusan" class="form-control " placeholder="Masukkan Jurusan" required>
                </div>
                <div class="form-group mb-3">
                    <label for="singkatan_jurusan" class="form-label">Singkatan</label>
                    <input type="text" name="singkatan_jurusan" class="form-control " placeholder="Masukkan Singkatan" required>
                </div>
                <br>
            </div>
        </div>
    </form>
</div>