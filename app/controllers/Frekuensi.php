<?php

class Frekuensi extends Controller {

    public function index() {
        // Mendapatkan id_user dan role dari sesi
        $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;

        // Ambil data untuk dropdown filter tahun ajaran
        $data['ajaranOptions'] = $this->model('Frekuensi_model')->tampilAjaran();

        // LOGIKA FILTER: Cek jika ada pengiriman data filter tahun
        if (isset($_POST['id_tahun_filter']) && $_POST['id_tahun_filter'] != '') {
            $data['frekuensi'] = $this->model('Frekuensi_model')->tampilBerdasarkanTahun($_POST['id_tahun_filter']);
        } else {
            $data['frekuensi'] = $this->model('Frekuensi_model')->tampil();
        }

        // Kode untuk akses asisten (tetap dipertahankan agar asisten bisa melihat jadwalnya sendiri)
        if ($role == 'Asisten') {
            $asisten = $this->model('Frekuensi_model')->getAsistenIdByUserId($id_user);
            
            if ($asisten === false) {
                Flasher::setFlash('Asisten tidak ditemukan', '', 'danger');
                header('Location: ' . BASEURL . '/frekuensi');
                exit;
            }

            $id_asisten = $asisten['id_asisten'];
            $data['frekuensi_asisten'] = $this->model('Frekuensi_model')->getFrekuensiByAsistenId($id_asisten);
        }

        $data['title'] = 'Data Jadwal Praktikum';

        // Memanggil View
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('frekuensi/index', $data);
        $this->view('templates/footer');
    }
    
    public function modalTambah(){
        $this->isAdmin();
        $data['dosenOptions'] = $this->model('Frekuensi_model')->tampilDosen();
        $data['asistenOptions'] = $this->model('Frekuensi_model')->tampilAsisten();
        $data['matakuliahOptions'] = $this->model('Frekuensi_model')->tampilMatakuliah();
        $data['frekuensiOptions'] = $this->model('Frekuensi_model')->tampilFrekuensi();
        $data['ruanganOptions'] = $this->model('Frekuensi_model')->tampilRuangan();
        $data['jurusanOptions'] = $this->model('Frekuensi_model')->tampilJurusan();
        $data['ajaranOptions'] = $this->model('Frekuensi_model')->tampilAjaran();

        $this->view('frekuensi/tambah_frekuensi', $data);
    }

    public function tambah(){
        $this->isAdmin();
        $data['dosenOptions'] = $this->model('Frekuensi_model')->tampilDosen();
        $data['asistenOptions'] = $this->model('Frekuensi_model')->tampilAsisten();
        $data['matakuliahOptions'] = $this->model('Frekuensi_model')->tampilMatakuliah();
        $data['frekuensiOptions'] = $this->model('Frekuensi_model')->tampilFrekuensi();
        $data['ruanganOptions'] = $this->model('Frekuensi_model')->tampilRuangan();
        $data['jurusanOptions'] = $this->model('Frekuensi_model')->tampilJurusan();
        $data['ajaranOptions'] = $this->model('Frekuensi_model')->tampilAjaran();
    
        if($this->model('Frekuensi_model')->tambah($_POST) > 0){
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
        }
        header('Location: '.BASEURL. '/frekuensi');
        exit;
    }
    
    public function ubahModal(){
        $this->isAdmin();
        $id = $_POST['id'];
        $data['dosenOptions'] = $this->model('Frekuensi_model')->tampilDosen();
        $data['asistenOptions'] = $this->model('Frekuensi_model')->tampilAsisten();
        $data['matakuliahOptions'] = $this->model('Frekuensi_model')->tampilMatakuliah();
        $data['frekuensiOptions'] = $this->model('Frekuensi_model')->tampilFrekuensi();
        $data['ruanganOptions'] = $this->model('Frekuensi_model')->tampilRuangan();
        $data['jurusanOptions'] = $this->model('Frekuensi_model')->tampilJurusan();
        $data['ajaranOptions'] = $this->model('Frekuensi_model')->tampilAjaran();
        $data['ubahdata'] = $this->model('Frekuensi_model')->ubah($id);

        $this->view('frekuensi/ubah_frekuensi', $data);
    }

    public function prosesUbah(){
        $this->isAdmin();
        if($this->model('Frekuensi_model')->prosesUbah($_POST) > 0){
            Flasher::setFlash(' berhasil diubah', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil diubah', '', 'danger');
        }
        header('Location: '.BASEURL. '/frekuensi');
        exit;
    }

    public function hapus($id){
        $this->isAdmin();
        if($this->model('Frekuensi_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/frekuensi');
        exit;
    }

    public function detail($id) {
        $data['title'] = 'Detail Jadwal Praktikum';
        $data['detail'] = $this->model('Frekuensi_model')->detailFrekuensi($id);
        $data['mentoring'] = $this->model('Frekuensi_model')->getMentoringByFrekuensiId($id);
        $data['frekuensi'] = $this->model('Frekuensi_model')->detailFrekuensi($id);

        if ($data['detail']) {
            $this->view('templates/header', $data);
            $this->view('templates/topbar');
            $this->view('templates/sidebar');
            $this->view('mentoring/detail', $data);
            $this->view('templates/footer');
        } else {
            Flasher::setFlash('Data tidak ditemukan', '', 'danger');
            header('Location: '.BASEURL. '/frekuensi');
            exit;
        }
    }    
    
    public function getFrekuensiCount() {
        $input = json_decode(file_get_contents('php://input'), true);
        $singkatan = $input['singkatan'];
    
        $count = $this->model('Frekuensi_model')->getFrekuensiCount($singkatan);
        echo json_encode(['count' => $count]);
    }
    
    public function getMatakuliahOptions(){
        $id_jurusan = $_POST['id_jurusan'];
        $data['matakuliahOptions'] = $this->model('Matakuliah_model')->getMatakuliahByJurusan($id_jurusan);
        echo json_encode($data['matakuliahOptions']);
    }
    
    public function filterAjax()
    {
        // Pastikan request adalah AJAX
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            http_response_code(403);
            exit('Forbidden');
        }

        // Ambil data POST (JSON)
        $input = json_decode(file_get_contents('php://input'), true);
        $id_tahun = isset($input['id_tahun']) ? $input['id_tahun'] : '';

        // Ambil data dari model
        if ($id_tahun) {
            $data = $this->model('Frekuensi_model')->getFrekuensiByTahun($id_tahun);
        } else {
            $data = $this->model('Frekuensi_model')->getAllFrekuensi();
        }

        // Set header dan kirim data JSON
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
