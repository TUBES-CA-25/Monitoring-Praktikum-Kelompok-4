<form id="formTambahDataDosen" action="<?= BASEURL ?>/Dosen/tambah" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">            
            <div class="form-group mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP">
            </div>
            <div class="form-group mb-3">
                <label for="nama_dosen" class="form-label">Nama Dosen</label>
                <input type="text" name="nama_dosen" class="form-control" placeholder="Masukkan Dosen" required>
            </div>
            <div class="form-group mb-3">
                <label for="formFile" class="form-label">Masukkan Foto</label>
                <input class="form-control " type="file" name="photo_path">
            </div><br>
        </div>
    </div>
</form>