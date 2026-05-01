<?php

class Controller{
    protected $db;
    protected $id_asisten;

    public function __construct(){
        session_start(); 
        if (isset($_SESSION['role'])) {
            $this->id_asisten = isset($_SESSION['id_asisten']) ? $_SESSION['id_asisten'] : null;
        } else {
            $this->id_asisten = null;
        }
        $this->db = new Database();
    }

    public function view($view, $data = []){
        if(!isset($_SESSION['id_user'])){
            require_once 'app/views/login/index.php';
        }else{
            require_once 'app/views/' . $view . '.php';
        }
    }

    public function model($model){
        require_once 'app/models/' . $model . '.php';
        return new $model;
    }

    public function isLogin() {
            if (!isset($_SESSION['id_user'])) {
                header('Location:' . BASEURL . '/login'); 
                exit;
            }
    }

    public function isAdmin() {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {  
            if ($_SESSION['role'] == 'Asisten') {
                header('Location:' . BASEURL);
            } else {
            }
            exit;
        }
    }

    public function isAsisten() {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Asisten') {  
            if ($_SESSION['role'] == 'Admin') {
                header('Location:' . BASEURL);
            } else {
            }
            exit;
        }
    }

    public function prosesUpload($inputName, $targetDirDB, $customName = null) {
        $file = $_FILES[$inputName] ?? null;
        
        if (!$file) return ['status' => false, 'pesan' => 'File tidak ditemukan'];
        
        // Jika user tidak upload apa-apa (ini normal saat Edit)
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['status' => true, 'no_upload' => true, 'nama_file' => null];
        }
        
        // Validasi Error PHP Upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['status' => false, 'pesan' => 'Error kode: ' . $file['error']];
        }

        // Validasi Ekstensi & Ukuran
        $ekstensiValid = ['jpg', 'jpeg', 'png'];
        $ekstensiFile = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ekstensiFile, $ekstensiValid)) {
            return ['status' => false, 'pesan' => 'Format harus JPG/PNG'];
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            return ['status' => false, 'pesan' => 'Ukuran file maksimal 5MB'];
        }

        // Penentuan Nama File
        $namaFileBaru = ($customName ? $customName : uniqid()) . '.' . $ekstensiFile;

        // Path System (Naik 2 level ke project root)
        $projectRoot = dirname(dirname(__DIR__));
        $targetDirSystem = $projectRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $targetDirDB);

        // Buat folder jika belum ada
        if (!file_exists($targetDirSystem)) mkdir($targetDirSystem, 0755, true);

        $fullPath = $targetDirSystem . DIRECTORY_SEPARATOR . $namaFileBaru;

        // Pindahkan File
        if (move_uploaded_file($file['tmp_name'], $fullPath)) {
            chmod($fullPath, 0644);
            // Return path untuk disimpan ke database
            return [
                'status' => true, 
                'nama_file' => str_replace(DIRECTORY_SEPARATOR, '/', $targetDirDB) . '/' . $namaFileBaru
            ];
        }

        return ['status' => false, 'pesan' => 'Gagal memindahkan file ke server'];
    }
}
?>
