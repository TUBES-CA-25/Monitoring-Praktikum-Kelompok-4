<div class="container">
    <form id="formUbahJurusan" action="<?= BASEURL?>/Jurusan/prosesUbah" method="post" autocomplete="off">
    <input type="hidden" value="<?= $data['ubahdata']['id_jurusan']?>" name="id_jurusan">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="jurusan" class="form-label">Laboratorium</label>
                    <input type="text" name="jurusan" class="form-control " value="<?= $data['ubahdata']['jurusan']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="singkatan_jurusan" class="form-label">Laboratorium</label>
                    <input type="text" name="singkatan_jurusan" class="form-control " value="<?= $data['ubahdata']['singkatan_jurusan']?>" >
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