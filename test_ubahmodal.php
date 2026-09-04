<?php
$_SERVER["HTTP_HOST"] = "localhost";
$_SERVER["REQUEST_URI"] = "/monitoring-praktikum/User/ubahModal";
$_GET["url"] = "User/ubahModal";
$_SERVER["REQUEST_METHOD"] = "POST";
$_POST["id"] = 1;
session_start();
$_SESSION["id_user"] = 1;
$_SESSION["role"] = "Admin";

require "app/config/config.php";
require "app/init.php";

$dbContent = file_get_contents('app/core/Database.php');
$dbContent = str_replace("mysql:host=' .\$this->host. ';dbname='.\$this->db_name", "mysql:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname='.\$this->db_name", $dbContent);
file_put_contents('app/core/Database.php', $dbContent);

$app = new App;

$dbContent = str_replace("mysql:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname='.\$this->db_name", "mysql:host=' .\$this->host. ';dbname='.\$this->db_name", $dbContent);
file_put_contents('app/core/Database.php', $dbContent);
