<?php

class User extends Controller {
    public function index() {
        $this->isAdmin();
        $data['title'] = 'Data User';
        // $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
        // $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
    
        // if ($role == 'Asisten') {
        //     $data['user'] = $this->model('User_model')->getUserDetails($id_user);
        // } else {
            $data['user'] = $this->model('User_model')->tampil();
        // }
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
    public function tambah(){
        $this->isAdmin();
        if($this->model('User_model')->tambah($_POST) > 0){
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
        }
        header('Location: '.BASEURL. '/user');
        exit;
    }
    public function ubahModal(){
        $id = $_POST['id'];
        $data['ubahdata'] = $this->model('User_model')->ubah($id);

        $this->view('user/ubah_user', $data);
    }
    public function prosesUbah(){
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
        if($this->model('User_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash(' berhasil diubah', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil diubah', '', 'danger');
        }
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

}
