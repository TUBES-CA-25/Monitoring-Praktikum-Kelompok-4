<?php

class Asisten extends Controller {
    // public function index(){
    //     $data['title'] = 'Data Asisten';
    //     $data['asisten'] = $this->model('Asisten_model')->tampil();
        
    //     $this->view('templates/header', $data);
    //     $this->view('templates/topbar');
    //     $this->view('templates/sidebar');
    //     $this->view('asisten/index', $data);
    //     $this->view('templates/footer');
    // }
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
        if($this->model('Asisten_model')->tambah($_POST) > 0){
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
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
        if($this->model('Asisten_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash(' berhasil diubah', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil diubah', '', 'danger');
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
}
