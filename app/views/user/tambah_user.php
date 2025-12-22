<div class="container">
    <form id="formTambahDataUser" action="<?= BASEURL ?>/User/tambah" method="post" autocomplete="off">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-3">
                    <label for="nama_user" class="form-label">Nama User</label>
                    <input type="text" name="nama_user" class="form-control " placeholder="Masukkan Nama User" required>
                </div>
                <div class="form-group mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control " placeholder="Masukkan Username" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" name="password" class="form-control " placeholder="Masukkan Password" required>
                </div>
                <div class="form-group mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">Pilih Role</option>
                        <option value="Asisten">Asisten</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div><br>
            </div>
        </div>
    </form>
</div>