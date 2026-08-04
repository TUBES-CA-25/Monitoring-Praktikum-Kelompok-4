<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Profil Saya</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php Flasher::flash(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Bagian Kiri: Foto Profil -->
                                <div class="col-md-4 text-center border-right">
                                    <?php $foto = !empty($data['user']['photo_profil']) ? BASEURL . '/' . $data['user']['photo_profil'] : BASEURL . '/public/img/user.png'; ?>
                                    <img class="profile-user-img img-fluid img-circle shadow-sm mb-3"
                                         src="<?= e($foto) ?>"
                                         alt="User profile picture"
                                         style="width: 180px; height: 180px; object-fit: cover; border-radius: 50%;">
                                    <h3 class="profile-username" style="font-weight: 600;">
                                        <?= e($data['user']['nama_user'] ?? $_SESSION['nama_user']) ?>
                                    </h3>
                                    <p class="text-muted"><span class="badge badge-primary px-3 py-2" style="font-size: 0.9rem;"><?= e($_SESSION['role']) ?></span></p>
                                </div>
                                
                                <!-- Bagian Kanan: Detail & Ganti Password -->
                                <div class="col-md-8 px-4">
                                    <h4 class="mb-4 text-primary" style="font-weight: 600;"><i class="fas fa-info-circle"></i> Detail Informasi & Keamanan</h4>
                                    
                                    <?php if ($_SESSION['role'] == 'Admin') : ?>
                                    <form action="<?= BASEURL; ?>/user/updateProfil" method="post">
                                        <input type="hidden" name="id_user" value="<?= e($data['user']['id_user'] ?? $_SESSION['id_user']) ?>">
                                        
                                        <div class="form-group row mb-4">
                                            <label class="col-sm-3 col-form-label text-muted">Nama Lengkap</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nama_user" class="form-control" value="<?= e($data['user']['nama_user'] ?? $_SESSION['nama_user']) ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label class="col-sm-3 col-form-label text-muted">Email (Username)</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="username" class="form-control" value="<?= e($data['user']['username'] ?? $_SESSION['username']) ?>" required>
                                            </div>
                                        </div>


                                        <hr>
                                        <h5 class="mt-4 mb-3" style="font-weight: 600;">Keamanan</h5>
                                        
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-muted">Password Baru</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="password" id="passwordInput" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin ganti password">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                            <i class="fas fa-eye" id="eyeIcon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <small class="text-muted mt-1 d-block">Gunakan password yang kuat untuk meningkatkan keamanan akun Anda.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="text-right mt-4 pt-3 border-top">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
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
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        
        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleBtn.innerHTML = '<i class="fas fa-eye-slash" id="eyeIcon"></i>';
                } else {
                    passwordInput.type = 'password';
                    toggleBtn.innerHTML = '<i class="fas fa-eye" id="eyeIcon"></i>';
                }
            });
        }
    });
</script>