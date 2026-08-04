<?php

// 1. Setting URL 
// Jika nama folder di htdocs adalah 'monitoring', maka:
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASEURL', $protocol . $host . '/monitoring-praktikum');

// 2. Setting Database (Default XAMPP)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); 
define('DB_NAME', 'db_monitoring_praktikum');

// 3. Setting Maintenance Mode
// Ubah menjadi true jika sedang perbaikan sistem
define('MAINTENANCE_MODE', false);

// 3. Koneksi Manual (Bawaan kodingan aslinya)
$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$connect) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}