<div class="container">
    <form id="formUbahDosen" action="<?= BASEURL?>/Dosen/prosesUbah" method="post" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" value="<?= $data['ubahdata']['id_dosen']?>" name="id_dosen">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control " value="<?= $data['ubahdata']['nip']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                    <input type="text" name="nama_dosen" class="form-control " value="<?= $data['ubahdata']['nama_dosen']?>" >
                </div>
                <div class="form-group mb-3">
                    <label for="formFile" class="form-label">Masukkan Foto</label>
                    <input class="form-control " type="file" name="photo_path">
                </div><br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>