<?php

class Asisten extends Controller {
    
    public function index(){
        $data['title'] = 'Data Asisten';
        $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
    
        if ($role == 'Asisten') {
            $data['asisten'] = $this->model('Asisten_model')->getAsistenDetails($id_user);
            $data['user'] = $this->model('User_model')->getUserDetails($id_user);
        } else {
            $data['asisten'] = $this->model('Asisten_model')->tampil();
        }
    
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('asisten/index', $data);
        $this->view('templates/footer');
    }        

    public function modalTambah(){
        $this->isAdmin();
        $data['userOptions'] = $this->model('Asisten_model')->tampilUser();
        $this->view('asisten/tambah_asisten', $data);
    }

    // public function tambah(){
    //     $this->isAdmin();
    //     $data = $_POST;

    //     $namaBersih = preg_replace('/[^A-Za-z0-9]/', '_', $data['nama_asisten']);
        
    //     $namaFileCustom = $namaBersih; 

    //     $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', $namaFileCustom . '_profil');

    //     if ($uploadProfil['status'] == false && $uploadProfil['error_code'] != 4) {
    //         Flasher::setFlash('Gagal upload profil: ' . $uploadProfil['pesan'], '', 'danger');
    //         header('Location: '.BASEURL. '/asisten');
    //         exit;
    //     }
    //     $data['photo_profil'] = $uploadProfil['nama_file']; 

    //     $uploadSignature = $this->prosesUpload('photo_path', 'public/img/signature/', $namaFileCustom . '_ttd');

    //     if ($uploadSignature['status'] == false && $uploadSignature['error_code'] != 4) {
    //         Flasher::setFlash('Gagal upload TTD: ' . $uploadSignature['pesan'], '', 'danger');
    //         header('Location: '.BASEURL. '/asisten');
    //         exit;
    //     }
    //     $data['photo_path'] = $uploadSignature['nama_file'];

    //     if($this->model('Asisten_model')->tambah($data) > 0){
    //         Flasher::setFlash('berhasil ditambahkan', '', 'success');
    //     } else {
    //         Flasher::setFlash('tidak berhasil ditambahkan', '', 'danger');
    //     }
    //     header('Location: '.BASEURL. '/asisten');
    //     exit;
    // }

    public function tambah()
    {
        $this->isAdmin();
        $data = $_POST;
        
        // Validasi: Pastikan semua field required terisi
        $requiredFields = ['username', 'stambuk', 'nama_asisten', 'angkatan', 'status', 'jenis_kelamin'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $_SESSION['old'] = $_POST;
                Flasher::setFlash('Field ' . $field . ' harus diisi!', 'Gagal', 'danger');
                header('Location: ' . BASEURL . '/asisten');
                exit;
            }
        }
        
        $cekUser = $this->model('User_model')->getUserByUsername($data['username']);
        if ($cekUser) {
            $_SESSION['old'] = $_POST;
            Flasher::setFlash('Username/Email sudah terdaftar!', 'Gagal', 'danger');
            header('Location: ' . BASEURL . '/asisten');
            exit;
        }

        $cekStambuk = $this->model('Asisten_model')->cekStambuk($data['stambuk']);
        if ($cekStambuk) {
            $_SESSION['old'] = $_POST;
            Flasher::setFlash('Stambuk ini sudah ada!', 'Gagal', 'danger');
            header('Location: ' . BASEURL . '/asisten');
            exit;
        }

        try {
            $passwordHash = $this->validateAkun($data['username'], $data['password']);

            if (trim($data['password']) === '') {
                Flasher::setFlash(
                    'Password kosong, sistem menggunakan default (iclabs-umi)',
                    'Info',
                    'info'
                );
            }

        } catch (Exception $e) {
            $_SESSION['old'] = $_POST;
            Flasher::setFlash($e->getMessage(), 'Gagal', 'danger');
            header('Location: ' . BASEURL . '/asisten');
            exit;
        }

        
        $namaBersih = preg_replace('/[^A-Za-z0-9]/', '_', $data['nama_asisten']);
        $namaFileCustom = $namaBersih;
        $uploadErrors = []; // Collect upload errors
        
        $data['photo_profil'] = null;
        if (!empty($_FILES['photo_profil']['name']) && $_FILES['photo_profil']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', $namaFileCustom . '_profil');
            if ($uploadProfil['status'] == false) {
                $uploadErrors[] = 'Foto Profil: ' . ($uploadProfil['pesan'] ?? 'Upload gagal');
            } else {
                $data['photo_profil'] = $uploadProfil['nama_file'];
            }
        }

        $data['photo_path'] = null;
        if (!empty($_FILES['photo_path']['name']) && $_FILES['photo_path']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadSignature = $this->prosesUpload('photo_path', 'public/img/signature/', $namaFileCustom . '_ttd');
            if ($uploadSignature['status'] == false) {
                $uploadErrors[] = 'Foto TTD: ' . ($uploadSignature['pesan'] ?? 'Upload gagal');
            } else {
                $data['photo_path'] = $uploadSignature['nama_file'];
            }
        }

        $dataUser = [
            'nama_user' => $data['nama_asisten'], 
            'username'  => $data['username'],
            'password'  => $passwordHash,
            'role'      => 'Asisten'
        ];

        // Tambah user terlebih dahulu
        $tambahUser = $this->model('User_model')->tambah($dataUser);

        if ($tambahUser > 0) {
            // Ambil ID user yang baru ditambahkan
            $newUser = $this->model('User_model')->getUserByUsername($data['username']);

            if ($newUser) {
                $data['id_user'] = $newUser['id_user'];

                // Tambah data asisten
                $tambahAsisten = $this->model('Asisten_model')->tambah($data);
                
                if ($tambahAsisten > 0) {
                    $_SESSION['old'] = []; // Clear old session
                    
                    // Jika ada upload errors, append ke message
                    $successMsg = 'Data Asisten Berhasil Ditambahkan';
                    if (!empty($uploadErrors)) {
                        $successMsg .= ' (tapi ada masalah dengan upload: ' . implode('; ', $uploadErrors) . ')';
                        Flasher::setFlash($successMsg, '', 'warning');
                    } else {
                        Flasher::setFlash($successMsg, '', 'success');
                    }
                } else {
                    // Hapus user yang sudah dibuat jika gagal tambah asisten
                    $this->model('User_model')->prosesHapus($newUser['id_user']);
                    $_SESSION['old'] = $_POST;
                    Flasher::setFlash('Gagal menyimpan data Asisten. User dihapus otomatis.', '', 'danger');
                }
            } else {
                $_SESSION['old'] = $_POST;
                Flasher::setFlash('Gagal mengambil ID User baru', '', 'danger');
            }

        } else {
            $_SESSION['old'] = $_POST;
            Flasher::setFlash('Gagal menyimpan Data User. Cek email apakah valid?', '', 'danger');
        }

        header('Location: '.BASEURL. '/asisten');
        exit;
    }

    public function ubahModal(){
        $this->isAdmin();
        $id = $_POST['id'];
        $data['userOptions'] = $this->model('Asisten_model')->tampilUser();
        $data['ubahdata'] = $this->model('Asisten_model')->ubah($id);
        $this->view('asisten/ubah_asisten', $data);
    }

    public function prosesUbah(){
        $this->isAdmin();
        $data = $_POST;
        $id_asisten = $data['id_asisten'];

        $namaBersih = preg_replace('/[^A-Za-z0-9]/', '_', $data['nama_asisten']); 
        
        $namaFileCustom = $namaBersih;
        $uploadErrors = [];

        // Proses upload foto profil
        if ($_FILES['photo_profil']['error'] === UPLOAD_ERR_NO_FILE) {
            // Tidak ada file baru, gunakan foto lama
            $data['photo_profil'] = $this->model('Asisten_model')->getPhoto2PathByID($id_asisten);
        } else if ($_FILES['photo_profil']['error'] !== UPLOAD_ERR_OK) {
            // Ada error, gunakan foto lama dan catat error
            $data['photo_profil'] = $this->model('Asisten_model')->getPhoto2PathByID($id_asisten);
            $uploadErrors[] = 'Foto Profil: Error pada upload (' . $_FILES['photo_profil']['error'] . ')';
        } else {
            // Ada file, proses upload
            $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', $namaFileCustom . '_profil');
            
            if ($uploadProfil['status'] == false) {
                // Upload gagal, gunakan foto lama
                $data['photo_profil'] = $this->model('Asisten_model')->getPhoto2PathByID($id_asisten);
                $uploadErrors[] = 'Foto Profil: ' . ($uploadProfil['pesan'] ?? 'Upload gagal');
            } else {
                $data['photo_profil'] = $uploadProfil['nama_file'];
            }
        }

        // Proses upload foto TTD
        if ($_FILES['photo_path']['error'] === UPLOAD_ERR_NO_FILE) {
            // Tidak ada file baru, gunakan foto lama
            $data['photo_path'] = $this->model('Asisten_model')->getPhotoPathByID($id_asisten);
        } else if ($_FILES['photo_path']['error'] !== UPLOAD_ERR_OK) {
            // Ada error, gunakan foto lama dan catat error
            $data['photo_path'] = $this->model('Asisten_model')->getPhotoPathByID($id_asisten);
            $uploadErrors[] = 'Foto TTD: Error pada upload (' . $_FILES['photo_path']['error'] . ')';
        } else {
            // Ada file, proses upload
            $uploadSignature = $this->prosesUpload('photo_path', 'public/img/signature/', $namaFileCustom . '_ttd');
            
            if ($uploadSignature['status'] == false) {
                // Upload gagal, gunakan foto lama
                $data['photo_path'] = $this->model('Asisten_model')->getPhotoPathByID($id_asisten);
                $uploadErrors[] = 'Foto TTD: ' . ($uploadSignature['pesan'] ?? 'Upload gagal');
            } else {
                $data['photo_path'] = $uploadSignature['nama_file'];
            }
        }

        if($this->model('Asisten_model')->prosesUbah($data) > 0){
            if (!empty($uploadErrors)) {
                $msg = 'Asisten berhasil diubah (tapi ada masalah upload: ' . implode('; ', $uploadErrors) . ')';
                Flasher::setFlash($msg, '', 'warning');
            } else {
                Flasher::setFlash('Asisten berhasil diubah', '', 'success');
            }
        } else {
            Flasher::setFlash('Data disimpan (tidak ada perubahan)', '', 'info');
        }
        header('Location: '.BASEURL. '/asisten');
        exit;
    }

    public function hapus($id){
        $this->isAdmin();
        if($this->model('Asisten_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/asisten');
        exit;
    }

    private function prosesUpload($inputName, $targetDirDB, $customName = null) {
        $file = $_FILES[$inputName] ?? null;
        
        // Cek file exists di $_FILES
        if (!$file) {
            return ['status' => false, 'error_code' => 99, 'pesan' => 'File tidak ditemukan dalam upload'];
        }
        
        // Cek error upload - Kode 4 berarti no file (UPLOAD_ERR_NO_FILE)
        // Jika tidak ada file, ini bukan error - user tidak upload foto
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['status' => true, 'error_code' => 4, 'nama_file' => null, 'pesan' => 'No file'];
        }
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errMsg = '';
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE: $errMsg = 'File terlalu besar (melebihi upload_max_filesize di php.ini)'; break;
                case UPLOAD_ERR_FORM_SIZE: $errMsg = 'File terlalu besar (melebihi MAX_FILE_SIZE)'; break;
                case UPLOAD_ERR_PARTIAL: $errMsg = 'File hanya terupload sebagian'; break;
                case UPLOAD_ERR_NO_TMP_DIR: $errMsg = 'Folder temp tidak tersedia'; break;
                case UPLOAD_ERR_CANT_WRITE: $errMsg = 'Gagal menulis ke disk'; break;
                case UPLOAD_ERR_EXTENSION: $errMsg = 'Upload dihentikan oleh extension'; break;
                default: $errMsg = 'Error upload: ' . $file['error'];
            }
            return ['status' => false, 'error_code' => 5, 'pesan' => $errMsg];
        }

        // Validasi ekstensi file
        $ekstensiValid = ['jpg', 'jpeg', 'png', 'gif'];
        $ekstensiFile = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ekstensiFile, $ekstensiValid)) {
            return ['status' => false, 'error_code' => 1, 'pesan' => 'Format file harus JPG, PNG, atau GIF (Anda upload: .' . $ekstensiFile . ')'];
        }

        // Validasi ukuran file (5MB max)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $maxSize) {
            return ['status' => false, 'error_code' => 2, 'pesan' => 'Ukuran file maksimal 5MB (ukuran saat ini: ' . round($file['size'] / 1024 / 1024, 2) . 'MB)'];
        }

        // Validasi ukuran minimal
        if ($file['size'] < 1024) {
            return ['status' => false, 'error_code' => 7, 'pesan' => 'File terlalu kecil, minimal 1KB (ukuran saat ini: ' . $file['size'] . ' bytes)'];
        }

        // Validasi MIME type - lebih robust dengan error handling
        $mimeType = false;
        if (function_exists('finfo_file')) {
            $finfo = @finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo !== false) {
                $mimeType = @finfo_file($finfo, $file['tmp_name']);
                @finfo_close($finfo);
            }
        }
        
        // Alternative: gunakan mime_content_type jika finfo tidak tersedia
        if (!$mimeType && function_exists('mime_content_type')) {
            $mimeType = mime_content_type($file['tmp_name']);
        }
        
        // Alternative: gunakan getimagesize
        if (!$mimeType) {
            $imageInfo = @getimagesize($file['tmp_name']);
            if ($imageInfo !== false && isset($imageInfo['mime'])) {
                $mimeType = $imageInfo['mime'];
            }
        }
        
        // Jika MIME tidak bisa dideteksi, izinkan berdasarkan extension saja
        if ($mimeType) {
            $mimeTypesValid = ['image/jpeg', 'image/png', 'image/gif', 'image/x-png'];
            if (!in_array($mimeType, $mimeTypesValid)) {
                return ['status' => false, 'error_code' => 6, 'pesan' => 'File bukan gambar yang valid (MIME: ' . $mimeType . '). Gunakan JPG, PNG, atau GIF'];
            }
        }

        $namaFileBaru = ($customName ? $customName : uniqid()) . '.' . $ekstensiFile;

        // Gunakan __DIR__ dari Controller untuk path yang lebih reliable
        // __DIR__ = /.../.../app/controllers
        // Naik 2 level ke project root = /.../.../monitoring-praktikum
        $projectRoot = dirname(dirname(__DIR__));
        $targetDirSystem = $projectRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $targetDirDB);

        // Buat folder jika belum ada
        if (!file_exists($targetDirSystem)) {
            if (!mkdir($targetDirSystem, 0755, true)) {
                return ['status' => false, 'error_code' => 8, 'pesan' => 'Gagal membuat folder upload: ' . $targetDirSystem];
            }
        }

        // Cek folder writable
        if (!is_writable($targetDirSystem)) {
            return ['status' => false, 'error_code' => 9, 'pesan' => 'Folder tidak dapat ditulis: ' . $targetDirSystem];
        }

        $fullPath = $targetDirSystem . DIRECTORY_SEPARATOR . $namaFileBaru;

        // Hapus file lama jika ada dengan error handling
        if (file_exists($fullPath)) {
            if (!is_writable($fullPath)) {
                return ['status' => false, 'error_code' => 11, 'pesan' => 'File lama sudah ada tapi tidak bisa dihapus (permission denied): ' . $fullPath];
            }
            if (!unlink($fullPath)) {
                return ['status' => false, 'error_code' => 10, 'pesan' => 'Gagal menghapus file lama: ' . $fullPath . ' (unknown error)'];
            }
        }

        // Pindahkan file upload
        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            $debugInfo = [];
            $debugInfo[] = 'Source tmp: ' . $file['tmp_name'] . ' (exists: ' . (file_exists($file['tmp_name']) ? 'yes' : 'no') . ')';
            $debugInfo[] = 'Target: ' . $fullPath . ' (exists: ' . (file_exists($fullPath) ? 'yes' : 'no') . ')';
            $debugInfo[] = 'Target dir: ' . $targetDirSystem . ' (writable: ' . (is_writable($targetDirSystem) ? 'yes' : 'no') . ', exists: ' . (file_exists($targetDirSystem) ? 'yes' : 'no') . ')';
            $debugInfo[] = 'File size: ' . ($file['size'] ?? 'unknown') . ' bytes';
            
            // Check PHP permission context
            $debugInfo[] = 'Current user: ' . get_current_user();
            $debugInfo[] = 'Upload tmp owner: ' . (file_exists($file['tmp_name']) ? posix_getpwuid(fileowner($file['tmp_name']))['name'] : 'N/A');
            
            $pesan = 'Gagal memindahkan file upload. Detail: ' . implode(' | ', $debugInfo);
            return ['status' => false, 'error_code' => 3, 'pesan' => $pesan];
        }

        // Set permission file
        chmod($fullPath, 0644);

        // Return path dengan format yang konsisten
        $returnPath = str_replace(DIRECTORY_SEPARATOR, '/', $targetDirDB) . '/' . $namaFileBaru;
        return ['status' => true, 'nama_file' => $returnPath];
    }

    private function validateAkun($username, $password)
    {
        $username = trim(strtolower($username));

        if ($username === '') {
            throw new Exception('Email wajib diisi!');
        }

        $allowedDomains = [
            '@umi.ac.id',
            '@student.umi.ac.id',
            '@gmail.com'
        ];

        $valid = false;
        foreach ($allowedDomains as $domain) {
            if (substr($username, -strlen($domain)) === $domain) {
                $valid = true;
                break;
            }
        }

        // email khusus
        if ($username === 'iclabs@umi.ac.id') {
            $valid = true;
        }

        if (!$valid) {
            throw new Exception(
                'Email tidak valid! Gunakan domain UMI / Student / Gmail'
            );
        }

        $finalPass = trim($password);
        if ($finalPass === '') {
            $finalPass = 'iclabs-umi';
        }

        return hash('sha256', $finalPass);
    }
}