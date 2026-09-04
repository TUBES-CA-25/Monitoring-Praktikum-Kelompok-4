<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/monitoring-praktikum/user/updateProfil';
$_GET['url'] = 'user/updateProfil';
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['password_lama'] = '';
$_POST['password_baru'] = '';
$_POST['nama_user'] = 'Zaki Falihin Ayyubi';
$_POST['username'] = 'admin@gmail.com';

session_start();
$_SESSION['id_user'] = 1;
$_SESSION['username'] = 'admin@gmail.com';
$_SESSION['nama_user'] = 'Admin';
$_SESSION['role'] = 'Admin';

require 'app/config/config.php';
function customExceptionHandler($e) {
    echo "EXCEPTION: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile() . "\n";
    exit;
}
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_exception_handler('customExceptionHandler');
set_error_handler('customErrorHandler');
require 'app/init.php';

sed -i '' "s/mysql:host=' .\$this->host. ';dbname='.\$this->db_name;/mysql:unix_socket=\/Applications\/XAMPP\/xamppfiles\/var\/mysql\/mysql.sock;dbname='.\$this->db_name;/" app/core/Database.php
$app = new App;
sed -i '' "s/mysql:unix_socket=\/Applications\/XAMPP\/xamppfiles\/var\/mysql\/mysql.sock;dbname='.\$this->db_name;/mysql:host=' .\$this->host. ';dbname='.\$this->db_name;/" app/core/Database.php
