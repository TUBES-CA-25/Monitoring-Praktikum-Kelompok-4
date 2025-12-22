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

    public function calendarAsisten()
    {
        header('Content-Type: application/json');

        $id_asisten = $_SESSION['id_user'];
        $rows = $this->model('Mentoring_model')->getCalendarAsisten($id_asisten);

        $events = [];

        foreach ($rows as $row) {

            // Skip jika belum ada tanggal (belum ada mentoring sama sekali)
            if (empty($row['tanggal'])) {
                continue;
            }

            // Default warna
            $color = '#dc3545'; // merah = belum isi

            if (!empty($row['id_mentoring'])) {
                $color = '#28a745'; // hijau = selesai
            }

            if (!empty($row['id_asisten_pengganti'])) {
                $color = '#fd7e14'; // oranye
            }

            $events[] = [
                'title' => $row['nama_matkul'],
                'start' => $row['tanggal'], // ⬅️ INI KUNCI
                'backgroundColor' => $color,
                'borderColor' => '#000',
                'extendedProps' => [
                    'id_frekuensi' => $row['id_frekuensi'],
                    'ruangan' => $row['nama_ruangan'],
                    'status' => !empty($row['id_mentoring']) ? 'done' : 'pending'
                ]
            ];
        }

        echo json_encode($events);
        exit;
    }

}