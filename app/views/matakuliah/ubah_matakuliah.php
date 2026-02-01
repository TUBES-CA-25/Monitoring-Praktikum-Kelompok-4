<div class="container">
    <!-- GUNAKAN ID FORM YANG SAMA DENGAN REFERENSI -->
    <form id="formUbahMatakuliah" action="<?= BASEURL?>/Matakuliah/prosesUbah" method="post" autocomplete="off">
        <!-- HIDDEN ID -->
        <input type="hidden" value="<?= $data['ubahdata']['id_matkul']?>" name="id_matkul">
        
        <div class="row">
            <div class="col-12">
                <!-- KODE MATKUL -->
                <div class="form-group mb-1">
                    <label for="kode_matkul" class="form-label">Kode Matakuliah</label>
                    <input type="text" name="kode_matkul" class="form-control" 
                           value="<?= $data['ubahdata']['kode_matkul']?>">
                </div>
                
                <!-- NAMA MATKUL -->
                <div class="form-group mb-1">
                    <label for="nama_matkul" class="form-label">Matakuliah</label>
                    <input type="text" name="nama_matkul" class="form-control" 
                           value="<?= $data['ubahdata']['nama_matkul']?>">
                </div>
                
                <!-- SINGKATAN -->
                <div class="form-group mb-1">
                    <label for="singkatan" class="form-label">Singkatan</label>
                    <input type="text" name="singkatan" class="form-control" 
                           value="<?= $data['ubahdata']['singkatan']?>">
                </div>
                
                <!-- JURUSAN DROPDOWN (YANG BARU) -->
                <div class="form-group mb-1">
                    <label for="id_jurusan" class="form-label">Jurusan</label>
                    <select name="id_jurusan" id="id_jurusan" class="form-control" required>
                        <option value="">Pilih Jurusan</option>
                        <?php foreach ($data['jurusanOptions'] as $jurusan) : ?>
                            <option value="<?= $jurusan['id_jurusan'] ?>" 
                                <?= ($jurusan['id_jurusan'] == $data['ubahdata']['id_jurusan']) ? 'selected' : '' ?>>
                                <?= $jurusan['jurusan'] ?> (<?= $jurusan['singkatan_jurusan'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- SEMESTER -->
                <div class="form-group mb-1">
                    <label for="semester" class="form-label">Semester</label>
                    <select name="semester" id="semester" class="form-control" required>
                        <option value="">Pilih Semester</option>
                        <option value="GANJIL" <?= isset($data['ubahdata']['semester']) && $data['ubahdata']['semester'] === 'GANJIL' ? 'selected' : '' ?>>GANJIL</option>
                        <option value="GENAP" <?= isset($data['ubahdata']['semester']) && $data['ubahdata']['semester'] === 'GENAP' ? 'selected' : '' ?>>GENAP</option>
                    </select>
                </div>
                
                <!-- SKS -->
                <div class="form-group mb-1">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" name="sks" class="form-control" 
                           value="<?= $data['ubahdata']['sks']?>">
                </div>
                
                <br>
                
                <!-- TOMBOL DENGAN STRUKTUR YANG SAMA -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>