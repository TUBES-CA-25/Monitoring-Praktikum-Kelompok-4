<?php

class Restore extends Controller {
    public function index() {
    $data['judul'] = 'Restore Data';
    $data['restore'] = $this->model('Restore_model')->getAll();
    
    $this->view('templates/header', $data);
    $this->view('templates/topbar', $data);
    $this->view('templates/sidebar', $data);
    $this->view('restore/index', $data);
    $this->view('templates/footer');
}

    public function kembalikan($id) {
        if ($this->model('Restore_model')->restoreData($id) > 0) {
            Flasher::setFlash('berhasil', 'dikembalikan', 'success');
        } else {
            Flasher::setFlash('gagal', 'dikembalikan', 'danger');
        }
        header('Location: ' . BASEURL . '/restore');
        exit;
    }

    public function hapusPermanen($id) {
        if ($this->model('Restore_model')->deletePermanent($id) > 0) {
            Flasher::setFlash('berhasil', 'dihapus permanen', 'success');
        } else {
            Flasher::setFlash('gagal', 'dihapus', 'danger');
        }
        header('Location: ' . BASEURL . '/restore');
        exit;
    }
}