<?php

define('BASEURL', 'http://localhost/monitoring-praktikum');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); 
define('DB_NAME', 'db_monitoring_praktikum');

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$connect) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}