<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="<?= BASEURL;?>/public/css/style.css">
    
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
                            <input type="text" class="input" id="username" name="username" required="" autocomplete="off">
                            <label for="username">Username</label> 
                        </div> 
                        <div class="input-field">
                            <input type="password" class="input" id="password" name="password" required="">
                            <label for="password">Password</label>
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

</body>
</html>