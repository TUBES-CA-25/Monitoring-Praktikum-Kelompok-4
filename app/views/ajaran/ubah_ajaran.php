<div class="container">
    <form id="formUbahAjaran" action="<?= BASEURL?>/Ajaran/prosesUbah" method="post" autocomplete="off">
    <input type="hidden" value="<?= $data['ubahdata']['id_tahun']?>" name="id_tahun">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" class="form-control " value="<?= $data['ubahdata']['tahun_ajaran']?>" >
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