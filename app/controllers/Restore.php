<?php

class Restore extends Controller
{
    public function __construct()
    {
        // Call parent constructor to initialize session
        parent::__construct();
        
        // Pastikan pengguna login sebagai Admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
            header('Location: ' . BASEURL . '/login');
            exit;
        }
    }

    // Tambahkan helper isAdmin untuk dipanggil di method lain
    public function isAdmin() {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {  
            if ($_SESSION['role'] == 'Asisten') {
                header('Location: ' . BASEURL);
            } else {
            }
            exit;
        }
    }

    public function index()
    {
        $data['title']   = 'Restore Data';
        $data['restore'] = $this->model('Restore_model')->getAll();

        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar', $data);
        $this->view('restore/index', $data);
        $this->view('templates/footer');
    }

    public function restore($id)
    {
        if ($this->model('Restore_model')->restoreData($id)) {
            Flasher::setFlash('Data berhasil', 'direstore', 'success');
        } else {
            Flasher::setFlash('Gagal melakukan restore data', '', 'danger');
        }

        header('Location: ' . BASEURL . '/restore');
        exit;
    }

    public function deletePermanent($id)
    {
        if ($this->model('Restore_model')->deletePermanent($id)) {
            Flasher::setFlash('Data berhasil', 'dihapus permanen', 'success');
        } else {
            Flasher::setFlash('Gagal menghapus data', '', 'danger');
        }

        header('Location: ' . BASEURL . '/restore');
        exit;
    }
}
?>