<div class="container">
    <form id="formUbahKelas" action="<?= BASEURL?>/Kelas/prosesUbah" method="post" autocomplete="off">
    <input type="hidden" value="<?= $data['ubahdata']['id_kelas']?>" name="id_kelas">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="id_jurusan" class="form-label">Jurusan</label>
                    <select name="id_jurusan" class="form-control ">
                        <?php
                        foreach ($data['jurusanOptions'] as $jurusan) {
                            $selected = ($jurusan['id_jurusan'] == $data['ubahdata']['id_jurusan']) ? 'selected' : '';
                            echo "<option value='{$jurusan['id_jurusan']}' {$selected}>{$jurusan['jurusan']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" name="kelas" class="form-control " value="<?= $data['ubahdata']['kelas']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="angkatan" class="form-label">Angkatan</label>
                    <input type="number" name="angkatan" class="form-control " value="<?= $data['ubahdata']['angkatan']?>" >
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