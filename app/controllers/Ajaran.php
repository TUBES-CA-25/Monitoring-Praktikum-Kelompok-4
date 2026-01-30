<?php

class Ajaran extends Controller {
    public function index(){
        $this->isAdmin();
        $data['title'] = 'Data Tahun Ajaran';
        $data['ajaran'] = $this->model('Ajaran_model')->tampil();
        
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('ajaran/index', $data);
        $this->view('templates/footer');
    }

    public function modalTambah(){
        $this->isAdmin();
        $this->view('ajaran/tambah_ajaran');
    }

    public function tambah(){
        $this->isAdmin();
        $this->view('ajaran/index');

        if($this->model('Ajaran_model')->tambah($_POST) > 0){
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
        }
        header('Location: '.BASEURL. '/ajaran');
        exit;
    }

    public function ubahModal(){
        $this->isAdmin();
        $id = $_POST['id'];
        $data['ubahdata'] = $this->model('Ajaran_model')->ubah($id);

        $this->view('ajaran/ubah_ajaran', $data);
    }

    public function prosesUbah(){
        $this->isAdmin();
        if($this->model('Ajaran_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash(' berhasil diubah', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil diubah', '', 'danger');
        }
        header('Location: '.BASEURL. '/ajaran');
        exit;
    }
    
    public function hapus($id){
        $this->isAdmin();
        if($this->model('Ajaran_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/ajaran');
        exit;
    }
}
