<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/monitoring-praktikum/user/profil';
$_GET['url'] = 'user/profil';

session_start();
$_SESSION['id_user'] = 1;
$_SESSION['username'] = 'admin@gmail.com';
$_SESSION['nama_user'] = 'Admin';
$_SESSION['role'] = 'Admin';

require 'app/config/config.php';
// Override DB_HOST
define('DB_HOST_MOCK', 'localhost;unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock');
require 'app/init.php';
$app = new App;
