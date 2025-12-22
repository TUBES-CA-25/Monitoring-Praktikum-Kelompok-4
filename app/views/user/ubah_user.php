<div class="container">
    <form id="formUbahUser" action="<?= BASEURL?>/User/prosesUbah" method="post" autocomplete="off">
        <input type="hidden" value="<?= $data['ubahdata']['id_user']?>" name="id_user">
        <input type="hidden" value="<?= $data['ubahdata']['role']?>" name="role"> <!-- Menyertakan role sebagai hidden field -->
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-1">
                    <label for="nama_user" class="form-label">Nama User</label>
                    <input type="text" name="nama_user" class="form-control " value="<?= $data['ubahdata']['nama_user']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control " value="<?= $data['ubahdata']['username']?>" >
                </div>
                <div class="form-group mb-1">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input id="passwordInput" type="password" name="password" class="form-control " value="">
                        <div class="input-group-append">
                            <button id="togglePassword" type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                </div>
                <?php if ($_SESSION['role'] == 'Admin') : ?>
                <div class="form-group mb-1">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">Pilih Role</option>
                        <option value="Asisten" <?= isset($data['ubahdata']['role']) && $data['ubahdata']['role'] === 'Asisten' ? 'selected' : '' ?>>Asisten</option>
                        <option value="Admin" <?= isset($data['ubahdata']['role']) && $data['ubahdata']['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
                <?php endif; ?>
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
    // PENGATURAN PASSWORD
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordInput = document.getElementById('passwordInput');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
</script>
