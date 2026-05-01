<?php

class User extends Controller {
    
    public function index() {
        $this->isAdmin();
        $data['title'] = 'Data User';
        $data['user'] = $this->model('User_model')->tampil();
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }
    
    public function modalTambah(){
        $this->isAdmin();
        $this->view('user/tambah_user');
    }

    public function tambah() {
        $this->isAdmin();
        $data = $_POST;
        
        // Enkripsi password saat tambah user baru
        if (!empty($data['password'])) {
            $data['password'] = hash('sha256', $data['password']);
        }

        if ($this->model('User_model')->tambah($data) > 0) {
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        } else {
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
        }
        
        header('Location: ' . BASEURL . '/user');
        exit;
    }

    public function ubahModal(){
        $id = $_POST['id'];
        $data['ubahdata'] = $this->model('User_model')->ubah($id);
        $asistenData = $this->model('Asisten_model')->cariDataAsistenByUserId($id);
        $data['foto_asisten'] = $asistenData; 
        $this->view('user/ubah_user', $data);
    }
    
    public function prosesUbah() {
        $data = $_POST;
        $id_user = $data['id_user'];
        
        $userLama = $this->model('User_model')->getUserById($id_user);
        $asistenLama = $this->model('Asisten_model')->getByUserId($id_user); 

        // 1. Password SHA-256
        // LOGIKA PASSWORD YANG BENAR
        if (empty($data['password'])) {
            // Jika input kosong, ambil password lama (sudah dalam bentuk hash)
            $data['password'] = $userLama['password'];
        } else {
            // Jika diisi, baru kita hash menggunakan SHA-256
            $data['password'] = hash('sha256', $data['password']);
        }

        // 2. Upload Foto Profil
        $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', 'profil_' . $id_user);
        // Jika upload sukses dan ada file baru, pakai file baru. Jika tidak, pakai yang lama.
        $data['photo_profil'] = ($uploadProfil['status'] && !$uploadProfil['no_upload']) 
                                ? $uploadProfil['nama_file'] 
                                : $asistenLama['photo_profil'];

        // 3. Upload TTD
        $uploadTTD = $this->prosesUpload('photo_path', 'public/img/signature/', 'ttd_' . $id_user);
        $data['photo_path'] = ($uploadTTD['status'] && !$uploadTTD['no_upload']) 
                            ? $uploadTTD['nama_file'] 
                            : $asistenLama['photo_path'];

        // 4. Update Database (Tabel User)
        $updateUser = $this->model('User_model')->ubahDataUser($data);
        
        // 5. Update Database (Tabel Asisten - Khusus Foto & TTD)
        $updateAsisten = $this->model('Asisten_model')->updateFilesByUserId(
            $id_user, 
            $data['photo_profil'], 
            $data['photo_path']
        );

        if ($updateUser >= 0 && $updateAsisten >= 0) {
            Flasher::setFlash('Berhasil', 'diperbarui', 'success');
        } else {
            Flasher::setFlash('Gagal', 'memperbarui data', 'danger');
        }

        header('Location: ' . BASEURL . '/User');
        exit;
    }

    public function hapus($id){
        $this->isAdmin();
        if($this->model('User_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/user');
        exit;
    }

    public function profil() {
        if (!isset($_SESSION['id_user'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        $id_user = $_SESSION['id_user'];
        // Ambil data user dari model
        $data['user'] = $this->model('User_model')->getUserById($id_user);
        $data['title'] = 'Profil Saya';

        // Jika data tidak ditemukan di database, gunakan data session agar tidak error
        if (!$data['user']) {
            $data['user'] = [
                'id_user' => $_SESSION['id_user'],
                'username' => $_SESSION['username'],
                'nama_user' => $_SESSION['nama_user'],
                'role' => $_SESSION['role']
            ];
        }

        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');

        if ($_SESSION['role'] == 'Admin') {
            $this->view('user/profil', $data); 
        } else {
            // Jika asisten, arahkan ke halaman profil asisten yang sesuai
            header('Location: ' . BASEURL . '/asisten'); 
            exit;
        }

        $this->view('templates/footer');
    }

    public function updateProfil() {
        $id_user = $_POST['id_user'];
        $passwordBaru = $_POST['password'];
        
        // Ambil data lama agar nama_user dan username tidak hilang
        $userLama = $this->model('User_model')->getUserById($id_user);

        $dataUpdate = [
            'id_user'   => $id_user,
            'username'  => $_POST['username'],
            'nama_user' => $userLama['nama_user'],
            'password'  => hash('sha256', $passwordBaru), // Hash dilakukan DISINI saja
            'role'      => $userLama['role']
        ];

        if ($this->model('User_model')->ubahDataUser($dataUpdate) >= 0) {
            Flasher::setFlash('Berhasil', 'Password Admin telah diperbarui', 'success');
        } else {
            Flasher::setFlash('Gagal', 'Gagal memperbarui password', 'danger');
        }

        header('Location: ' . BASEURL . '/user/profil');
        exit;
    }


    public function uploadFoto($namaOrang, $fotoLama)
    {
        $namaFile = $_FILES['photo_profil']['name'];
        $ukuranFile = $_FILES['photo_profil']['size'];
        $tmpName = $_FILES['photo_profil']['tmp_name'];

        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));

        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            Flasher::setFlash('gagal', 'upload! Format harus jpg/jpeg/png', 'danger');
            $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
            header('Location: ' . BASEURL . ($role == 'Asisten' ? '/asisten' : '/user'));
            exit;
        }

        if ($ukuranFile > 2000000) {
            Flasher::setFlash('gagal', 'upload! Ukuran max 2MB', 'danger');
            $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
            header('Location: ' . BASEURL . ($role == 'Asisten' ? '/asisten' : '/user'));
            exit;
        }

        $namaBersih = preg_replace('/[^A-Za-z0-9]/', '_', $namaOrang);
        $namaFileBaru = $namaBersih . '_profil.' . $ekstensiGambar;

        // Gunakan __DIR__ untuk path yang reliable
        // __DIR__ = /.../.../app/controllers
        // Naik 2 level ke project root = /.../.../monitoring-praktikum
        $projectRoot = dirname(dirname(__DIR__));
        $targetDirSystem = $projectRoot . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $namaFileBaru;
        $targetPath = 'public/img/uploads/' . $namaFileBaru;

        if (!empty($fotoLama) && file_exists($fotoLama)) {
            if ($fotoLama != $targetPath) {
                unlink($fotoLama);
            }
        }

        move_uploaded_file($tmpName, $targetDirSystem);
        return $targetPath;
    }
}