<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/monitoring-praktikum/user/profil';
$_GET['url'] = 'user/profil';

session_start();
$_SESSION['id_user'] = 1;
$_SESSION['username'] = 'admin@gmail.com';
$_SESSION['nama_user'] = 'Admin';
$_SESSION['role'] = 'Admin';

require_once 'app/config/config.php';
// Override DB_HOST temporarily for CLI
// We know localhost fails in CLI for XAMPP on Mac unless we use socket
// But we can just use 127.0.0.1 and change Database.php temporarily, or just catch it.
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
$app = new App;
