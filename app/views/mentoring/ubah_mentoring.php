<div class="container">
    <form id="formUbahMentoring" action="<?= BASEURL?>/Mentoring/prosesUbah" method="post" autocomplete="off">
<<<<<<< HEAD
    <input type="hidden" value="<?= $data['ubahdata']['id_mentoring']?>" name="id_mentoring">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control " value="<?= $data['ubahdata']['tanggal']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="uraian_materi" class="form-label">Uraian Materi</label>
                    <textarea name="uraian_materi" class="form-control"><?= $data['ubahdata']['uraian_materi'] ?></textarea>
                </div>
                <div class="form-group mb-1">
                    <label for="uraian_tugas" class="form-label">Uraian Tugas</label>
                    <textarea name="uraian_tugas" class="form-control"><?= $data['ubahdata']['uraian_tugas'] ?></textarea>
                </div>
                <div class="form-group mb-1">
                    <label for="id_dosen" class="form-label">Dosen</label>
                    <select name="id_dosen" class="form-control ">
                        <?php
                        foreach ($data['dosenOptions'] as $dosen) {
                            $selected = ($dosen['id_dosen'] == $data['ubahdata']['id_dosen']) ? 'selected' : '';
                            echo "<option value='{$dosen['id_dosen']}' {$selected}>{$dosen['nama_dosen']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="id_asisten1" class="form-label">Asisten 1</label>
                    <select name="id_asisten1" class="form-control ">
                        <?php
                        foreach ($data['asistenOptions'] as $asisten) {
                            $selected = ($asisten['id_asisten'] == $data['ubahdata']['id_asisten1']) ? 'selected' : '';
                            echo "<option value='{$asisten['id_asisten']}' {$selected}>{$asisten['nama_asisten']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="id_asisten2" class="form-label">Asisten 2</label>
                    <select name="id_asisten2" class="form-control ">
                        <?php
                        foreach ($data['asistenOptions'] as $asisten) {
                            $selected = ($asisten['id_asisten'] == $data['ubahdata']['id_asisten2']) ? 'selected' : '';
                            echo "<option value='{$asisten['id_asisten']}' {$selected}>{$asisten['nama_asisten']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- <div class="form-group mb-1">
                    <label for="id_asisten_pengganti" class="form-label">Asisten Pengganti</label>
                    <select name="id_asisten_pengganti" class="form-control ">
                        <?php
                        foreach ($data['asistenOptions'] as $asisten) {
                            $selected = ($asisten['id_asisten'] == $data['ubahdata']['id_asisten_pengganti']) ? 'selected' : '';
                            echo "<option value='{$asisten['id_asisten']}' {$selected}>{$asisten['nama_asisten']}</option>";
                        }
                        ?>
                    </select>
                </div> -->
=======
        <input type="hidden" value="<?= $data['ubahdata']['id_mentoring']?>" name="id_mentoring">
        <input type="hidden" value="<?= $data['ubahdata']['id_frekuensi']?>" name="id_frekuensi">

        <div class="row">
            <div class="col-12">  
                <div class="form-group mb-1">
                    <label for="text" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= $data['ubahdata']['tanggal']; ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="uraian_materi" class="form-label">Uraian Materi</label>
                    <textarea type="text" name="uraian_materi" class="form-control" placeholder="Masukkan Uraian Materi" required><?= $data['ubahdata']['uraian_materi']; ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="uraian_tugas" class="form-label">Uraian Tugas</label>
                    <textarea type="text" name="uraian_tugas" class="form-control" placeholder="Masukkan Uraian Tugas" required><?= $data['ubahdata']['uraian_tugas']; ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="hadir" class="form-label">Kehadiran Mahasiswa</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="number" name="hadir" class="form-control" placeholder="Jumlah Hadir" value="<?= $data['ubahdata']['hadir']; ?>" required>
                        </div>
                        <div class="col-6">
                            <input type="number" name="alpa" class="form-control" placeholder="Jumlah Alpa" value="<?= $data['ubahdata']['alpa']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="form-check d-flex align-items-center mb-3">
                    <div class="row w-100">
                        <div class="col-auto me-3 d-flex align-items-center">
                            <input type="hidden" name="status_dosen" value="Tidak Hadir">
                            <input class="form-check-input" type="checkbox" name="status_dosen" id="status_dosen" value="Hadir" 
                                <?= $data['ubahdata']['status_dosen'] == 'Hadir' ? 'checked' : ''; ?>>
                            <label class="form-check-label ms-2" for="status_dosen">
                                Dosen
                            </label>
                        </div>

                        <div class="col-auto me-3 d-flex align-items-center">
                            <input type="hidden" name="status_asisten1" value="Tidak Hadir">
                            <input class="form-check-input" type="checkbox" name="status_asisten1" id="status_asisten1" value="Hadir"
                                <?= $data['ubahdata']['status_asisten1'] == 'Hadir' ? 'checked' : ''; ?>>
                            <label class="form-check-label ms-2" for="status_asisten1">
                                Asisten 1
                            </label>
                        </div>

                        <div class="col-auto d-flex align-items-center">
                            <input type="hidden" name="status_asisten2" value="Tidak Hadir">
                            <input class="form-check-input" type="checkbox" name="status_asisten2" id="status_asisten2" value="Hadir"
                                <?= $data['ubahdata']['status_asisten2'] == 'Hadir' ? 'checked' : ''; ?>>
                            <label class="form-check-label ms-2" for="status_asisten2">
                                Asisten 2
                            </label>
                        </div>
                    </div>
                </div>

>>>>>>> appyx
                <div class="form-group mb-1">
                    <label for="id_asisten_pengganti" class="form-label">Asisten Pengganti</label>
                    <select name="id_asisten_pengganti" class="form-control">
                        <option value="">Tidak ada asisten pengganti</option>
<<<<<<< HEAD
                        <?php
                        foreach ($data['asistenOptions'] as $asisten) {
                            $selected = ($asisten['id_asisten'] == $data['ubahdata']['id_asisten_pengganti']) ? 'selected' : '';
                            echo "<option value='{$asisten['id_asisten']}' {$selected}>{$asisten['nama_asisten']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="id_matkul" class="form-label">Matakuliah</label>
                    <select name="id_matkul" class="form-control ">
                        <?php
                        foreach ($data['matakuliahOptions'] as $matakuliah) {
                            $selected = ($matakuliah['id_matkul'] == $data['ubahdata']['id_matkul']) ? 'selected' : '';
                            echo "<option value='{$matakuliah['id_matkul']}' {$selected}>{$matakuliah['nama_matkul']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="id_kelas" class="form-label">Kelas</label>
                    <select name="id_kelas" class="form-control ">
                        <?php
                        foreach ($data['kelasOptions'] as $kelas) {
                            $selected = ($kelas['id_kelas'] == $data['ubahdata']['id_kelas']) ? 'selected' : '';
                            echo "<option value='{$kelas['id_kelas']}' {$selected}>{$kelas['kelas']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="id_ruangan" class="form-label">Laboratorium</label>
                    <select name="id_ruangan" class="form-control ">
                        <?php
                        foreach ($data['ruanganOptions'] as $ruangan) {
                            $selected = ($ruangan['id_ruangan'] == $data['ubahdata']['id_ruangan']) ? 'selected' : '';
                            echo "<option value='{$ruangan['id_ruangan']}' {$selected}>{$ruangan['nama_ruangan']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah</button>
=======
                        <?php foreach ($data['asistenOptions'] as $asisten) : ?>
                            <?php 
                            // Logic agar dropdown terpilih sesuai data lama
                            $selected = ($asisten['id_asisten'] == $data['ubahdata']['id_asisten_pengganti']) ? 'selected' : ''; 
                            ?>
                            <option value="<?= $asisten['id_asisten']; ?>" <?= $selected; ?>>
                                <?= $asisten['nama_asisten']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
>>>>>>> appyx
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>