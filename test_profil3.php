<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/monitoring-praktikum/user/profil';
$_GET['url'] = 'user/profil';

session_start();
$_SESSION['id_user'] = 9999; // User that DOES NOT EXIST
$_SESSION['username'] = 'admin@gmail.com';
$_SESSION['nama_user'] = 'Admin';
$_SESSION['role'] = 'Admin';

require_once 'app/config/config.php';
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
