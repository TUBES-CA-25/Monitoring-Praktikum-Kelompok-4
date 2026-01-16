<?php

class Home extends Controller {
    public function index(){
        $data['title'] = 'Dashboard'; 
        
        // --- DATA STATISTIK ---
        $data['jumlahDataRuangan'] = $this->model('Ruangan_model')->jumlahDataRuangan();
        $data['jumlahDataMatakuliah'] = $this->model('Matakuliah_model')->jumlahDataMatakuliah();
        $data['jumlahDataKelas'] = $this->model('Kelas_model')->jumlahDataKelas();
        $data['jumlahDataJurusan'] = $this->model('Jurusan_model')->jumlahDataJurusan();
        $data['jumlahDataUser'] = $this->model('User_model')->jumlahDataUser();
        $data['jumlahDataDosen'] = $this->model('Dosen_model')->jumlahDataDosen();
        $data['jumlahDataAsisten'] = $this->model('Asisten_model')->jumlahDataAsisten();
        $data['jumlahDataMentoring'] = $this->model('Mentoring_model')->jumlahDataMentoring();
        
        // --- LOGIKA ASISTEN ---
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'Asisten') {
        $frekuensiModel = $this->model('Frekuensi_model');
        $mentoringModel = $this->model('Mentoring_model');
        
        // 1. Cari id_asisten yang terhubung dengan id_user di session
        $asisten = $frekuensiModel->getAsistenIdByUserId($_SESSION['id_user']);
        
        if ($asisten) {
            $id_asisten = $asisten['id_asisten'];

            // 2. Ambil Jadwal hari ini (Milik User ini saja)
            $data['monitoringHariIni'] = $frekuensiModel->getJadwalHariIniAsisten($id_asisten);

            // 3. Ambil Aktivitas Terakhir (Milik User ini saja dari Mentoring_model)
            $data['aktivitasTerakhir'] = $mentoringModel->getAktivitasTerakhirAsisten($id_asisten);
        } else {
            $data['monitoringHariIni'] = [];
            $data['aktivitasTerakhir'] = [];
        }
    }
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }

    public function calendarAsisten()
    {
        date_default_timezone_set('Asia/Jakarta');
        
        header('Content-Type: application/json');
        
        $frekuensiModel = $this->model('Frekuensi_model');
        $mentoringModel = $this->model('Mentoring_model');

        // 1. Dapatkan ID Asisten asli dari user session
        $asisten = $frekuensiModel->getAsistenIdByUserId($_SESSION['id_user']);
        $id_asisten = $asisten['id_asisten'];

        // 2. Ambil semua data jadwal & mentoring
        $rows = $mentoringModel->getCalendarAsisten($id_asisten);

        $events = [];
        foreach ($rows as $row) {
            // Logika penentuan tanggal: 
            // Jika belum ada mentoring, kalender mungkin butuh logika plotting tanggal berdasarkan hari.
            // Namun jika kita mengikuti data trs_mentoring yang sudah ada:
            if (empty($row['tanggal'])) continue; 

            // Warna Merah (Default: Belum diisi)
            $color = '#dc3545'; 

            // Warna Hijau (Selesai diisi)
            if (!empty($row['id_mentoring'])) {
                $color = '#28a745'; 
            }

            // Warna Oranye (Jika ada asisten pengganti)
            if (!empty($row['id_asisten_pengganti'])) {
                $color = '#fd7e14';
            }

            $events[] = [
                'title' => $row['nama_matkul'],
                'start' => $row['tanggal'],
                'backgroundColor' => $color,
                'borderColor' => '#343a40',
                'extendedProps' => [
                    'id_frekuensi' => $row['id_frekuensi'],
                    'ruangan' => $row['nama_ruangan'],
                    'status' => !empty($row['id_mentoring']) ? 'Selesai' : 'Belum Diisi'
                ]
            ];
        }

        echo json_encode($events);
        exit;
    }

}