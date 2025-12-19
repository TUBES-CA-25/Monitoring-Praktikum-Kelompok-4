<?php

// 1. Setting URL (Sesuaikan dengan nama folder di htdocs)
// Jika nama folder di htdocs adalah 'monitoring', maka:
define('BASEURL', 'http://localhost/monitoring-praktikum');

// 2. Setting Database (Default XAMPP)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Password default XAMPP biasanya kosong
define('DB_NAME', 'db_monitoring_praktikum');

// 3. Koneksi Manual (Bawaan kodingan aslinya)
$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$connect) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}