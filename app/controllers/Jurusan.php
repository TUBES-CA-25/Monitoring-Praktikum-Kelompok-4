<?php

class Jurusan extends Controller {
    public function index(){
        $this->isAdmin();
        $data['title'] = 'Data Jurusan';
        $data['jurusan'] = $this->model('Jurusan_model')->tampil();
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('jurusan/index', $data);
        $this->view('templates/footer');
    }
    public function modalTambah(){
        $this->isAdmin();
        $this->view('jurusan/tambah_jurusan');
    }
    public function tambah(){
        $this->isAdmin();
        if($this->model('Jurusan_model')->tambah($_POST) > 0){
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
        }
        header('Location: '.BASEURL. '/jurusan');
        exit;
    }
    public function ubahModal(){
        $this->isAdmin();
        $id = $_POST['id'];
        $data['ubahdata'] = $this->model('Jurusan_model')->ubah($id);

        $this->view('jurusan/ubah_jurusan', $data);
    }
    public function prosesUbah(){
        $this->isAdmin();
        if($this->model('Jurusan_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash(' berhasil diubah', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil diubah', '', 'danger');
        }
        header('Location: '.BASEURL. '/jurusan');
        exit;
    }
    public function hapus($id){
        $this->isAdmin();
        if($this->model('Jurusan_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/jurusan');
        exit;
    }
}
