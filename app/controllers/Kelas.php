<?php

class Kelas extends Controller {
    public function index(){
        $this->isAdmin();
        $data['title'] = 'Data Kelas';
        $data['kelas'] = $this->model('Kelas_model')->tampil();
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('kelas/index', $data);
        $this->view('templates/footer');
    }
    public function modalTambah(){
        $this->isAdmin();
        $data['jurusanOptions'] = $this->model('Kelas_model')->tampilJurusan();

        $this->view('kelas/tambah_kelas', $data);
    }
    public function tambah(){
        $this->isAdmin();
        $data['jurusanOptions'] = $this->model('Kelas_model')->tampilJurusan();

        $this->view('kelas/index', $data);

        if($this->model('Kelas_model')->tambah($_POST) > 0){
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
        }
        header('Location: '.BASEURL. '/kelas');
        exit;
    }
    public function ubahModal(){
        $this->isAdmin();
        $id = $_POST['id'];
        $data['jurusanOptions'] = $this->model('Kelas_model')->tampilJurusan();
        $data['ubahdata'] = $this->model('Kelas_model')->ubah($id);

        $this->view('kelas/ubah_kelas', $data);
    }
    public function prosesUbah(){
        $this->isAdmin();
        if($this->model('Kelas_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash(' berhasil diubah', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil diubah', '', 'danger');
        }
        header('Location: '.BASEURL. '/kelas');
        exit;
    }
    public function hapus($id){
        $this->isAdmin();
        if($this->model('Kelas_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/kelas');
        exit;
    }
}
