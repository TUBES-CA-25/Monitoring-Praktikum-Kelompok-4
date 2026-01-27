<form id="formTambahDataMentoring" action="<?= BASEURL ?>/Mentoring/tambah" method="post" autocomplete="off">
    <div class="row">
        <div class="col-12">
            <input type="hidden" name="id_frekuensi" value="<?= $data['frekuensiOptions']['id_frekuensi']; ?>">

            <div class="form-group mb-2">
                <label class="font-weight-bold" style="font-size: 0.9rem;">Tanggal</label>
                <?php
                    date_default_timezone_set('Asia/Makassar'); 
                    $tanggalHariIni = date("Y-m-d");
                ?>
                <input type="date" name="tanggal" class="form-control" value="<?= $tanggalHariIni; ?>" required>
            </div>

            <div class="form-group mb-2">
                <label class="font-weight-bold" style="font-size: 0.9rem;">Uraian Materi</label>
                <textarea name="uraian_materi" class="form-control" rows="3" placeholder="Masukkan Uraian Materi" style="resize: none;" required></textarea>
            </div>

            <div class="form-group mb-2">
                <label class="font-weight-bold" style="font-size: 0.9rem;">Uraian Tugas</label>
                <textarea name="uraian_tugas" class="form-control" rows="3" placeholder="Masukkan Uraian Tugas" style="resize: none;" required></textarea>
            </div>

            <div class="form-group mb-2">
                <label class="font-weight-bold" style="font-size: 0.9rem;">Kehadiran</label>
                <div class="row">
                    <div class="col-6 pr-1">
                        <input type="number" name="hadir" class="form-control" placeholder="Jumlah Hadir" min="0" required>
                    </div>
                    <div class="col-6 pl-1">
                        <input type="number" name="alpa" class="form-control" placeholder="Jumlah Alpa" min="0" required>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3 mt-3">
                <div class="d-flex align-items-center">
                    <div class="custom-control custom-checkbox mr-4">
                        <input class="custom-control-input" type="checkbox" name="status_dosen" value="Hadir" id="s_dosen">
                        <label class="custom-control-label font-weight-normal" for="s_dosen" style="font-size: 0.9rem;">Dosen</label>
                    </div>
                    <div class="custom-control custom-checkbox mr-4">
                        <input class="custom-control-input" type="checkbox" name="status_asisten1" value="Hadir" id="s_as1">
                        <label class="custom-control-label font-weight-normal" for="s_as1" style="font-size: 0.9rem;">Asisten 1</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="status_asisten2" value="Hadir" id="s_as2">
                        <label class="custom-control-label font-weight-normal" for="s_as2" style="font-size: 0.9rem;">Asisten 2</label>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <label class="font-weight-bold" style="font-size: 0.9rem;">Asisten Pengganti</label>
                <select name="id_asisten_pengganti" class="form-control">
                    <option value="">Pilih Nama Asisten Pengganti</option>
                    <?php foreach ($data['asistenOptions'] as $asisten) : ?>
                        <option value="<?= $asisten['id_asisten']; ?>"><?= $asisten['nama_asisten']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</form>