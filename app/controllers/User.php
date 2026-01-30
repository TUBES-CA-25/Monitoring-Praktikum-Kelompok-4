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
    
    public function prosesUbah(){
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
        
        $nama_asli = $_POST['nama_user']; 
        $foto_lama = $_POST['foto_lama'];

        if ($_FILES['photo_profil']['error'] === 4) {
            $foto_baru = $foto_lama;
        } else {
            $foto_baru = $this->uploadFoto($nama_asli, $foto_lama);
            
            if (!$foto_baru) {
                return false; 
            }
        }

        if($this->model('User_model')->prosesUbah($_POST) >= 0){
        }
        if ($this->model('Asisten_model')->updateFotoViaUser($_POST['id_user'], $foto_baru) > 0) {
        }
        
        Flasher::setFlash(' berhasil diubah', '', 'success');
        if ($role == 'Asisten') {
            header('Location: '.BASEURL. '/asisten');
        } else {
            header('Location: '.BASEURL. '/user');
        }
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

    // --- FITUR PROFIL SAYA (ADMIN) ---

    public function profil() {
        // Cek login
        if (!isset($_SESSION['id_user'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        $data['title'] = 'Profil Saya';
        $id_user = $_SESSION['id_user']; 
        $data['user'] = $this->model('User_model')->getUserById($id_user);

        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('user/profil', $data); 
        $this->view('templates/footer');
    }

public function updateProfil() {
    $id_user = $_SESSION['id_user'];
    $data = [
        'id_user'  => $id_user,
        'username' => $_POST['username'], 
        'password' => $_POST['password']
    ];

    if ($this->model('User_model')->updateDataUser($data) > 0) {
        Flasher::setFlash('berhasil', 'diperbarui', 'success', 'Password');
    }
    header('Location: ' . BASEURL . '/user/profil');
    exit;
}

    // --- HELPER FUNCTIONS ---

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
            header('Location: ' . BASEURL . '/user');
            exit;
        }

        if ($ukuranFile > 2000000) {
            Flasher::setFlash('gagal', 'upload! Ukuran max 2MB', 'danger');
            header('Location: ' . BASEURL . '/user');
            exit;
        }

        $namaBersih = preg_replace('/[^A-Za-z0-9]/', '_', $namaOrang);
        $namaFileBaru = $namaBersih . '_profil.' . $ekstensiGambar;

        $targetPath = 'public/img/uploads/' . $namaFileBaru;

        if (!empty($fotoLama) && file_exists($fotoLama)) {
            if ($fotoLama != $targetPath) {
                unlink($fotoLama);
            }
        }

        move_uploaded_file($tmpName, $targetPath);
        return $targetPath;
    }
}