<div class="container">
    <form id="formUbahRuangan" action="<?= BASEURL?>/Ruangan/prosesUbah" method="post" autocomplete="off">
    <input type="hidden" value="<?= $data['ubahdata']['id_ruangan']?>" name="id_ruangan">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="nama_ruangan" class="form-label">Laboratorium</label>
                    <input type="text" name="nama_ruangan" class="form-control " value="<?= $data['ubahdata']['nama_ruangan']?>" >
                </div><br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>