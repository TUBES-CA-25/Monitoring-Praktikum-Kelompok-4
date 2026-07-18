<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="<?= BASEURL;?>/public/css/style.css">
    <link rel="stylesheet" href="<?= BASEURL;?>/public/template/plugins/fontawesome-free/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="<?= BASEURL;?>/public/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image">                
                <img src="<?= BASEURL;?>/public/img/ICLabs-logo.png" alt="Logo">                
            </div>
            
            <div class="col-md-6 right">                
                <div class="input-box">          
                    <form class="login-form" action="<?= BASEURL?>/Login/login" method="post" autocomplete="off">
                        <header><h4>Login</h4></header>

                        <div style="width: 100%; margin-bottom: 15px;">
                            <?php Flasher::flash(); ?>
                        </div>
                        <div class="input-field">
                            <input type="text" class="input" id="username" name="username" required="" autocomplete="off" value="<?= isset($data['remember_username']) ? $data['remember_username'] : '' ?>">
                            <label for="username">Username</label> 
                        </div> 
                        <div class="input-field" style="position: relative;">
                            <input type="password" class="input" id="password" name="password" required="" style="padding-right: 40px;" value="<?= isset($data['remember_password']) ? $data['remember_password'] : '' ?>">
                            <label for="password">Password</label>
                            <span id="togglePassword" style="position: absolute; right: 20px; top: 10px; cursor: pointer; color: #777; z-index: 10;">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </span>
                        </div> 
                        <div style="display: flex; align-items: center; margin-bottom: 20px; margin-top: 5px;">
                            <input type="checkbox" id="remember" name="remember" style="width: auto; margin-right: 8px; cursor: pointer;" <?= isset($_COOKIE['remember_username']) ? 'checked' : '' ?>>
                            <label for="remember" style="position: static; font-size: 14px; color: #555; cursor: pointer;">Remember Me</label>
                        </div>
                        <div class="input-field">                        
                            <button type="submit" class="submit">Login</button>
                        </div> 
                        
                        <div class="text-center">
                            </div>
                    </form>        
                </div>  
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        if (type === 'password') {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    });
</script>

</body>
</html>