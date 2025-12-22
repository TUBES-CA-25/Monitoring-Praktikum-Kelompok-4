<?php

class Ruangan extends Controller {
    public function index(){
        $this->isAdmin();
        $data['title'] = 'Data Laboratorium';
        $data['ruangan'] = $this->model('Ruangan_model')->tampil();
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('ruangan/index', $data);
        $this->view('templates/footer');
    }
    public function modalTambah(){
        $this->isAdmin();
        $this->view('ruangan/tambah_ruangan');
    }
    public function tambah(){
        $this->isAdmin();
        if($this->model('Ruangan_model')->tambah($_POST) > 0){
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
        }
        header('Location: '.BASEURL. '/ruangan');
        exit;
    }
    public function ubahModal(){
        $this->isAdmin();
        $id = $_POST['id'];
        $data['ubahdata'] = $this->model('Ruangan_model')->ubah($id);

        $this->view('ruangan/ubah_ruangan', $data);
    }
    public function prosesUbah(){
        $this->isAdmin();
        if($this->model('Ruangan_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash(' berhasil diubah', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil diubah', '', 'danger');
        }
        header('Location: '.BASEURL. '/ruangan');
        exit;
    }
    public function hapus($id){
        $this->isAdmin();
        if($this->model('Ruangan_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/ruangan');
        exit;
    }
}
