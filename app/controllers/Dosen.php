<?php

class Dosen extends Controller {
    public function index(){
        $this->isAdmin();
        $data['title'] = 'Data Dosen';
        $data['dosen'] = $this->model('Dosen_model')->tampil();
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('dosen/index', $data);
        $this->view('templates/footer');
    }
    
    public function modalTambah(){
        $this->isAdmin();
        $this->view('dosen/tambah_dosen');
    }

    public function tambah(){
        $this->isAdmin();

        if($this->model('Dosen_model')->tambah($_POST) > 0){
            Flasher::setFlash('Dosen', 'berhasil ditambahkan', 'success');
        }else{
            Flasher::setFlash('Dosen', 'tidak berhasil ditambahkan', 'danger');
        }
        header('Location: '.BASEURL. '/dosen');
        exit;
    }

    public function ubahModal(){
        $this->isAdmin();
        $id = $_POST['id'];
        $data['ubahdata'] = $this->model('Dosen_model')->ubah($id);

        $this->view('dosen/ubah_dosen', $data);
    }

    public function prosesUbah(){
        $this->isAdmin();
        if($this->model('Dosen_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash('Dosen', 'berhasil diubah', 'success');
        }else{
            Flasher::setFlash('Dosen', 'tidak berhasil diubah', 'danger');
        }
        header('Location: '.BASEURL. '/dosen');
        exit;
    }

    public function hapus($id){
        $this->verifyCsrfToken();
        $this->isAdmin();
        if($this->model('Dosen_model')->prosesHapus($id)){
            Flasher::setFlash('Dosen', 'berhasil dihapus', 'success');
        }else{
            Flasher::setFlash('Dosen', 'tidak berhasil dihapus', 'danger');
        }
        header('Location: '.BASEURL. '/dosen');
        exit;
    }
}
