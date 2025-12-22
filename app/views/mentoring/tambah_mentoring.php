<form id="formTambahDataMentoring" action="<?= BASEURL ?>/Mentoring/tambah" method="post" autocomplete="off">
    <div class="row">
        <div class="col-12">  
            <div class="form-group mb-1">
                <label for="id_frekuensi" class="form-label">Frekuensi</label>
                <select name="id_frekuensi" class="form-control">
                    <option value="<?= $data['frekuensiOptions']['id_frekuensi']; ?>" selected><?= $data['frekuensiOptions']['frekuensi']; ?></option>
                </select>
            </div>
            <div class="form-group mb-1">
                <label for="text" class="form-label">Tanggal</label>
                <?php
                    $tanggalHariIni = date("Y-m-d");
                ?>
                <input type="date" name="tanggal" class="form-control " value="<?= $tanggalHariIni ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="uraian_materi" class="form-label">Uraian Materi</label>
                <textarea type="text" name="uraian_materi" class="form-control" placeholder="Masukkan Uraian Materi" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="uraian_tugas" class="form-label">Uraian Tugas</label>
                <textarea type="text" name="uraian_tugas" class="form-control" placeholder="Masukkan Uraian Tugas" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="hadir" class="form-label">Kehadiran</label>
                <div class="row">
                    <div class="col-6">
                        <input type="number" name="hadir" class="form-control" placeholder="Jumlah Hadir" required>
                    </div>
                    <div class="col-6">
                        <input type="number" name="alpa" class="form-control" placeholder="Jumlah Alpa" required>
                    </div>
                </div>
            </div>
            <div class="form-check d-flex align-items-center mb-3">
                <div class="row w-100">
                    <div class="col-auto me-3 d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" name="status_dosen" id="status_dosen" value="Hadir">
                        <label class="form-check-label ms-2" for="status_dosen">
                            Dosen
                        </label>
                    </div>
                    <div class="col-auto me-3 d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" name="status_asisten1" id="status_asisten1" value="Hadir">
                        <label class="form-check-label ms-2" for="status_asisten1">
                            Asisten 1
                        </label>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" name="status_asisten2" id="status_asisten2" value="Hadir">
                        <label class="form-check-label ms-2" for="status_asisten2">
                            Asisten 2
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group mb-1">
                <label for="id_asisten_pengganti" class="form-label">Asisten Pengganti</label>
                <select name="id_asisten_pengganti" class="form-control">
                    <option value="">Pilih Nama Asisten Pengganti</option>
                    <?php foreach ($data['asistenOptions'] as $asisten) : ?>
                        <option value="<?= $asisten['id_asisten']; ?>"><?= $asisten['nama_asisten']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
        </div>
    </div>
</form>