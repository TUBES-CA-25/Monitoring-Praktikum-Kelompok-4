<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASEURL;?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login</title>
</head>
<body>
  <div class="Login-Wrap">
    <div class="container-fluid h-100 login-barrier">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-md-4">
              <div class="login-logo text-center">
                <img src="<?= BASEURL?>/assets/img/logo-dark.png" alt="" width="100px">
              </div><br>
                <div class="login-container">
                    <form class="login-form" action="<?= BASEURL?>/Login/login" method="post" autocomplete="off">
                        <h5><b>LOGIN</b></h5>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="email" class="form-control" id="username" name="username" placeholder="Masukkan Username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="Masukkan Password" id="passwordInput" required>
                                <button id="togglePassword" type="button" class="btn btn-outline-light" style="border-color: #06253A; color: #06253A;"><i class="fa fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-dark button-style" style="width: 35%;">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
