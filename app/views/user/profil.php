<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Profil Saya</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="<?= BASEURL ?>/public/img/user.png"
                                     alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center"><?= $data['user']['nama_user']; ?></h3>
                            <p class="text-muted text-center"><?= $_SESSION['role']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header p-2">
                            <h3 class="card-title ml-2">Detail Informasi</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Email (Username)</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext"><?= $data['user']['username']; ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9">
                                    <p class="form-control-plaintext"><?= $data['user']['role']; ?></p>
                                </div>
                            </div>

                            <?php if ($_SESSION['role'] == 'Admin') : ?>
                                <hr>
                                <form action="<?= BASEURL; ?>/user/updateProfil" method="post">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-primary">Password Baru</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" class="form-control" placeholder="Masukkan password baru untuk mengganti" required>
                                            <small class="text-muted">Masukkan password baru Anda untuk meningkatkan keamanan.</small>
                                            <input type="hidden" name="username" value="<?= $data['user']['username']; ?>">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-key"></i> Update Password Admin
                                        </button>
                                    </div>
                                </form>
                            <?php else : ?>
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle"></i> Untuk perubahan data atau password, silakan hubungi Admin.
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>