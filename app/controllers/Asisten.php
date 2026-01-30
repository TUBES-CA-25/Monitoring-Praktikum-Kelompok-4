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

    public function tambah(){
        $this->isAdmin();
        $data = $_POST;

        $namaBersih = preg_replace('/[^A-Za-z0-9]/', '_', $data['nama_asisten']);
        
        $namaFileCustom = $namaBersih; 

        $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', $namaFileCustom . '_profil');

        if ($uploadProfil['status'] == false && $uploadProfil['error_code'] != 4) {
            Flasher::setFlash('Gagal upload profil: ' . $uploadProfil['pesan'], '', 'danger');
            header('Location: '.BASEURL. '/asisten');
            exit;
        }
        $data['photo_profil'] = $uploadProfil['nama_file']; 

        $uploadSignature = $this->prosesUpload('photo_path', 'public/img/signature/', $namaFileCustom . '_ttd');

        if ($uploadSignature['status'] == false && $uploadSignature['error_code'] != 4) {
            Flasher::setFlash('Gagal upload TTD: ' . $uploadSignature['pesan'], '', 'danger');
            header('Location: '.BASEURL. '/asisten');
            exit;
        }
        $data['photo_path'] = $uploadSignature['nama_file'];

        if($this->model('Asisten_model')->tambah($data) > 0){
            Flasher::setFlash('berhasil ditambahkan', '', 'success');
        } else {
            Flasher::setFlash('tidak berhasil ditambahkan', '', 'danger');
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

        if ($_FILES['photo_profil']['error'] === 4) {
            $data['photo_profil'] = $this->model('Asisten_model')->getPhoto2PathByID($id_asisten);
        } else {
            $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', $namaFileCustom . '_profil');
            
            if ($uploadProfil['status'] == false) {
                Flasher::setFlash('Gagal ubah profil: ' . $uploadProfil['pesan'], '', 'danger');
                header('Location: '.BASEURL. '/asisten');
                exit;
            }
            $data['photo_profil'] = $uploadProfil['nama_file'];
        }

        if ($_FILES['photo_path']['error'] === 4) {
            $data['photo_path'] = $this->model('Asisten_model')->getPhotoPathByID($id_asisten);
        } else {
            $uploadSignature = $this->prosesUpload('photo_path', 'public/img/signature/', $namaFileCustom . '_ttd');
            
            if ($uploadSignature['status'] == false) {
                Flasher::setFlash('Gagal ubah TTD: ' . $uploadSignature['pesan'], '', 'danger');
                header('Location: '.BASEURL. '/asisten');
                exit;
            }
            $data['photo_path'] = $uploadSignature['nama_file'];
        }

        if($this->model('Asisten_model')->prosesUbah($data) > 0){
            Flasher::setFlash('berhasil diubah', '', 'success');
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
        $file = $_FILES[$inputName];
        
        if ($file['error'] === 4) {
            return ['status' => false, 'error_code' => 4, 'nama_file' => null];
        }

        $ekstensiValid = ['jpg', 'jpeg', 'png'];
        $ekstensiFile = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ekstensiFile, $ekstensiValid)) {
            return ['status' => false, 'error_code' => 1, 'pesan' => 'Format file harus JPG/PNG'];
        }

        if ($file['size'] > 5000000) {
            return ['status' => false, 'error_code' => 2, 'pesan' => 'Ukuran file max 5MB'];
        }

        $namaFileBaru = ($customName ? $customName : uniqid()) . '.' . $ekstensiFile;

        $rootPath = getcwd(); 
        
        $targetDirSystem = $rootPath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $targetDirDB);

        if (!file_exists($targetDirSystem)) {
            mkdir($targetDirSystem, 0777, true);
        }

        if (file_exists($targetDirSystem . $namaFileBaru)) {
            unlink($targetDirSystem . $namaFileBaru);
        }
        if (move_uploaded_file($file['tmp_name'], $targetDirSystem . $namaFileBaru)) {
            return ['status' => true, 'nama_file' => $targetDirDB . $namaFileBaru];
        } else {
            return ['status' => false, 'error_code' => 3, 'pesan' => 'Gagal akses folder: ' . $targetDirSystem];
        }
    }
}