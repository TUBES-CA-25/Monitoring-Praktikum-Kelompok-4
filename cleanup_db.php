<?php
require_once "app/config/config.php";

class DatabaseMock {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;
    private $dbh;

    public function __construct() {
        $dsn = "mysql:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname=" . $this->db_name;
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("DB Error: " . $e->getMessage());
        }
    }

    public function getDb() {
        return $this->dbh;
    }
}

$db = (new DatabaseMock())->getDb();

$delKelas = $db->exec("DELETE FROM mst_kelas WHERE angkatan IN (2021, 2022)");
echo "Berhasil menghapus " . (int)$delKelas . " data mst_kelas tahun 2021/2022.\n";
