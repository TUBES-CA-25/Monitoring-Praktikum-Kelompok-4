<?php

// 1. Setting URL 
// Tentukan domain resmi untuk keamanan (Pencegahan Host Header Injection)
define('BASEURL', 'http://localhost/monitoring-praktikum');

// 2. Setting Database (Default XAMPP)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); 
define('DB_NAME', 'db_monitoring_praktikum');

// 3. Setting Maintenance Mode
// Ubah menjadi true jika sedang perbaikan sistem
define('MAINTENANCE_MODE', false);