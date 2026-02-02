<?php

class Matakuliah extends Controller {
    public function index(){
        $this->isAdmin();
        $data['title'] = 'Data Matakuliah';
        $data['matakuliah'] = $this->model('Matakuliah_model')->tampil();
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('matakuliah/index', $data);
        $this->view('templates/footer');
    }

    public function modalTambah(){
        $this->isAdmin();
        $data['jurusanOptions'] = $this->model('Matakuliah_model')->tampilJurusan();
        $this->view('matakuliah/tambah_matakuliah', $data);
    }

    // PENAMBAHAN FLASHER (rafli)

    public function tambah(){
        $this->isAdmin();
        $data['jurusanOptions'] = $this->model('Matakuliah_model')->tampilJurusan();
    
        $result = $this->model('Matakuliah_model')->tambah($_POST);
    
        if($result > 0){
            Flasher::setFlash('Matakuliah berhasil ditambahkan', '', 'success');
        } elseif($result == -2) {
            Flasher::setFlash('Kode matakuliah sudah ada! Gunakan kode lain', '', 'danger');
        } else {
            Flasher::setFlash('Matakuliah tidak berhasil ditambahkan', '', 'danger');
        }
    
        header('Location: '.BASEURL. '/matakuliah');
        exit;
    }

    public function ubahModal(){
        $this->isAdmin();
        $data['jurusanOptions'] = $this->model('Matakuliah_model')->tampilJurusan();
        $id = $_POST['id'];
        $data['ubahdata'] = $this->model('Matakuliah_model')->ubah($id);

        $this->view('matakuliah/ubah_matakuliah', $data);
    }

    public function prosesUbah(){
        $this->isAdmin();
        if($this->model('Matakuliah_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash(' berhasil diubah', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil diubah', '', 'danger');
        }
        header('Location: '.BASEURL. '/matakuliah');
        exit;
    }

    public function hapus($id){
        $this->isAdmin();
        if($this->model('Matakuliah_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/matakuliah');
        exit;
    }
    
    public function getMatakuliahByJurusan(){
        $id_jurusan = $_POST['id_jurusan'];
        $data['matakuliahOptions'] = $this->model('Matakuliah_model')->getMatakuliahByJurusan($id_jurusan);
        echo json_encode($data['matakuliahOptions']);
    }    
}
