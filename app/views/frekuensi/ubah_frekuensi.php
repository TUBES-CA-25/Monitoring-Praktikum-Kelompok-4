<div class="container">
    <form id="formUbahFrekuensi" action="<?= BASEURL?>/Frekuensi/prosesUbah" method="post" autocomplete="off">
    <input type="hidden" value="<?= $data['ubahdata']['id_frekuensi']?>" name="id_frekuensi">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="id_jurusan" class="form-label">Jurusan</label>
                    <select id="id_jurusan" name="id_jurusan" class="form-control">
                        <option value="">Pilih Jurusan</option>
                        <?php foreach ($data['jurusanOptions'] as $jurusan) : ?>
                            <option value="<?= $jurusan['id_jurusan']; ?>" data-singkatan="<?= $jurusan['singkatan_jurusan']; ?>" <?= ($jurusan['id_jurusan'] == $data['ubahdata']['id_jurusan']) ? 'selected' : ''; ?>>
                                <?= $jurusan['jurusan']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="id_matkul" class="form-label">Matakuliah</label>
                    <select id="id_matkul" name="id_matkul" class="form-control">
                        <option value="">Pilih Matakuliah</option>
                        <?php foreach ($data['matakuliahOptions'] as $matkul) : ?>
                            <option value="<?= $matkul['id_matkul']; ?>" data-singkatan="<?= $matkul['singkatan']; ?>" <?= ($matkul['id_matkul'] == $data['ubahdata']['id_matkul']) ? 'selected' : ''; ?>>
                                <?= $matkul['nama_matkul']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="frekuensi" class="form-label">Frekuensi</label>
                    <input type="text" name="frekuensi" class="form-control " value="<?= $data['ubahdata']['frekuensi']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="id_tahun" class="form-label">Tahun Ajaran</label>
                    <select name="id_tahun" class="form-control ">
                        <?php
                        foreach ($data['ajaranOptions'] as $ajaran) {
                            $selected = ($ajaran['id_tahun'] == $data['ubahdata']['id_tahun']) ? 'selected' : '';
                            echo "<option value='{$ajaran['id_tahun']}' {$selected}>{$ajaran['tahun_ajaran']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mb-1">
                    <label for="id_kelas" class="form-label">Kelas</label>
                    <select name="id_kelas" class="form-control ">
                        <?php
                        foreach ($data['frekuensiOptions'] as $kelas) {
                            $selected = ($kelas['id_kelas'] == $data['ubahdata']['id_kelas']) ? 'selected' : '';
                            echo "<option value='{$kelas['id_kelas']}' {$selected}>{$kelas['kelas']} - {$kelas['angkatan']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="jadwal" class="form-label">Jadwal</label>
                        <select name="hari" id="hari" class="form-control" required>
                            <option value="">Hari</option>
                            <option value="Senin" <?= ($data['ubahdata']['hari'] == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                            <option value="Selasa" <?= ($data['ubahdata']['hari'] == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                            <option value="Rabu" <?= ($data['ubahdata']['hari'] == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                            <option value="Kamis" <?= ($data['ubahdata']['hari'] == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                            <option value="Jumat" <?= ($data['ubahdata']['hari'] == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                            <option value="Sabtu" <?= ($data['ubahdata']['hari'] == 'Sabtu') ? 'selected' : ''; ?>>Sabtu</option>
                            <option value="Minggu" <?= ($data['ubahdata']['hari'] == 'Minggu') ? 'selected' : ''; ?>>Minggu</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="jam_mulai">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" value="<?= $data['ubahdata']['jam_mulai']?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="jam_selesai">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" value="<?= $data['ubahdata']['jam_selesai']?>">
                    </div>
                </div>
                <div class="form-group mb-1">
                    <label for="id_ruangan" class="form-label">Ruangan</label>
                    <select name="id_ruangan" class="form-control ">
                        <?php
                        foreach ($data['ruanganOptions'] as $ruangan) {
                            $selected = ($ruangan['id_ruangan'] == $data['ubahdata']['id_ruangan']) ? 'selected' : '';
                            echo "<option value='{$ruangan['id_ruangan']}' {$selected}>{$ruangan['nama_ruangan']}</option>";
                        }
                        ?>
                    </select>
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
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize frekuensi value
    updateFrekuensi();

    document.getElementById('id_jurusan').addEventListener('change', function() {
        updateFrekuensi();
    });

    document.getElementById('id_matkul').addEventListener('change', function() {
        updateFrekuensi();
    });
    function updateFrekuensi() {
    var jurusanSelect = document.getElementById('id_jurusan');
    var matkulSelect = document.getElementById('id_matkul');

    var jurusanOption = jurusanSelect.options[jurusanSelect.selectedIndex];
    var matkulOption = matkulSelect.options[matkulSelect.selectedIndex];

    var jurusanSingkatan = jurusanOption ? jurusanOption.getAttribute('data-singkatan') : '';
    var matkulSingkatan = matkulOption ? matkulOption.getAttribute('data-singkatan') : '';

    if (jurusanSingkatan && matkulSingkatan) {
        var singkatan = jurusanSingkatan + '_' + matkulSingkatan;

        fetch('<?= BASEURL ?>/Frekuensi/getFrekuensiCount', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ singkatan: singkatan })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Singkatan:', singkatan);
            console.log('Frekuensi Count:', data.count);

            var count = data.count;
            document.getElementById('frekuensi').value = singkatan + '-' + (count + 1);
        })
        .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('frekuensi').value = '';
    }
}

});
</script>
