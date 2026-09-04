<?php
$_SERVER["HTTP_HOST"] = "localhost";
$_SERVER["REQUEST_URI"] = "/monitoring-praktikum/User/ubahModal";
$_GET["url"] = "User/ubahModal";
$_SERVER["REQUEST_METHOD"] = "POST";
$_POST["id"] = 1;
session_start();
$_SESSION["id_user"] = 1;
$_SESSION["role"] = "Admin";
$_SESSION["csrf_token"] = "dummy"; // Just in case

require_once "app/config/config.php";

// Override DSN
class DatabaseMock {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;
    private $dbh;
    private $stmt;

    public function __construct() {
        $dsn = "mysql:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname=" . $this->db_name;
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    public function query($query) { $this->stmt = $this->dbh->prepare($query); }
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value): $type = PDO::PARAM_INT; break;
                case is_bool($value): $type = PDO::PARAM_BOOL; break;
                case is_null($value): $type = PDO::PARAM_NULL; break;
                default: $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    public function execute() { return $this->stmt->execute(); }
    public function single() { $this->execute(); return $this->stmt->fetch(PDO::FETCH_ASSOC); }
}

require_once "app/core/Controller.php";
require_once "app/core/SecurityHelper.php";

// Inject Mock
$dbFile = file_get_contents('app/core/Database.php');
$dbFile = str_replace("mysql:host=' .\$this->host. ';dbname='.\$this->db_name", "mysql:unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname='.\$this->db_name", $dbFile);
file_put_contents('app/core/Database_tmp.php', $dbFile);
require_once 'app/core/Database_tmp.php';

require_once 'app/models/User_model.php';

// Instantiate controller directly
require_once 'app/controllers/User.php';
$controller = new User();
ob_start();
try {
    $controller->ubahModal();
    $output = ob_get_clean();
    echo "SUCCESS:\n";
    echo $output;
} catch (Throwable $e) {
    ob_end_clean();
    echo "ERROR:\n";
    echo $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine();
}
unlink('app/core/Database_tmp.php');
