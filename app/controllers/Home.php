<?php

class Home extends Controller {
    public function index(){
        $data['title'] = 'Dasboard';
        $data['jumlahDataRuangan'] = $this->model('Ruangan_model')->jumlahDataRuangan();
        $data['jumlahDataMatakuliah'] = $this->model('Matakuliah_model')->jumlahDataMatakuliah();
        $data['jumlahDataKelas'] = $this->model('Kelas_model')->jumlahDataKelas();
        $data['jumlahDataJurusan'] = $this->model('Jurusan_model')->jumlahDataJurusan();
        $data['jumlahDataUser'] = $this->model('User_model')->jumlahDataUser();
        $data['jumlahDataDosen'] = $this->model('Dosen_model')->jumlahDataDosen();
        $data['jumlahDataAsisten'] = $this->model('Asisten_model')->jumlahDataAsisten();
        $data['jumlahDataMentoring'] = $this->model('Mentoring_model')->jumlahDataMentoring();
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('home/index', $data);  
        $this->view('templates/footer');        
    }

    public function calendarAsisten() {
        header('Content-Type: application/json');
        echo json_encode([]);
    }
}