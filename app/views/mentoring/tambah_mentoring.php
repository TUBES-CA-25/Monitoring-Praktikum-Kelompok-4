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
            <div class="form-group mb-1">
                <label for="id_dosen" class="form-label">Dosen</label>
                <select name="id_dosen" class="form-control" required>
                    <option value="">Pilih Nama Dosen</option>
                    <?php foreach ($data['dosenOptions'] as $dosen) : ?>
                        <option value="<?= $dosen['id_dosen']; ?>"><?= $dosen['nama_dosen']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-1">
                <label for="id_asisten1" class="form-label">Asisten 1</label>
                <select name="id_asisten1" class="form-control">
                    <option value="">Pilih Nama Asisten 1</option>
                    <?php foreach ($data['asistenOptions'] as $asisten) : ?>
                        <option value="<?= $asisten['id_asisten']; ?>"><?= $asisten['nama_asisten']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-1">
                <label for="id_asisten2" class="form-label">Asisten 2</label>
                <select name="id_asisten2" class="form-control">
                    <option value="">Pilih Nama Asisten 2</option>
                    <?php foreach ($data['asistenOptions'] as $asisten) : ?>
                        <option value="<?= $asisten['id_asisten']; ?>"><?= $asisten['nama_asisten']; ?></option>
                    <?php endforeach; ?>
                </select>
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