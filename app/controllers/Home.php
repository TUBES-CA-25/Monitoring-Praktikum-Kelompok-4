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
        
        $data['calendarLegend'] = [
            ['label' => 'Sesuai Jadwal', 'color' => '#6c757d'],
            ['label' => 'Belum Mengisi', 'color' => '#dc3545'],
            ['label' => 'Sudah Mengisi', 'color' => '#28a745'],
            ['label' => 'Kelas Pengganti', 'color' => '#0d6efd']
        ];

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
        header('Content-Type: application/json');
        date_default_timezone_set('Asia/Jakarta');

        $frekuensiModel = $this->model('Frekuensi_model');
        $mentoringModel = $this->model('Mentoring_model');

        $asisten = $frekuensiModel->getAsistenIdByUserId($_SESSION['id_user']);
        if (!$asisten) {
            echo json_encode([]);
            exit;
        }

        $rows = $mentoringModel->getCalendarAsisten($asisten['id_asisten']);

        $hariMap = [
            'senin' => 1,
            'selasa' => 2,
            'rabu' => 3,
            'kamis' => 4,
            'jumat' => 5,
            'sabtu' => 6,
            'minggu' => 7
        ];

    $events = [];
    
    $today = new DateTime('today');
    $endOfThisWeek = clone $today;
    $endOfThisWeek->modify('sunday this week');
    $todayWeek = $today->format('oW');
    $todayDayIndex = (int) $today->format('N');

    foreach ($rows as $row) {

        // ===== VALIDASI HARI =====
        $hariIndex = $hariMap[strtolower($row['hari'])] ?? null;
        if (!$hariIndex) continue;

        // ===== VALIDASI TANGGAL MULAI =====
        if (empty($row['tanggal_mulai'])) continue;
        $baseDate = new DateTime($row['tanggal_mulai']);

        // ===== CARI TANGGAL PERTAMA SESUAI HARI =====
        $diff = $hariIndex - (int)$baseDate->format('N');
        if ($diff < 0) $diff += 7;

        $startDate = clone $baseDate;
        $startDate->modify("+{$diff} day");

        // ===== SIMPAN JADWAL DEFAULT =====
        $jadwal = [];

        for ($i = 0; $i < 12; $i++) {

            $d = clone $startDate;
            $d->modify("+{$i} week");


            $weekKey = $d->format('oW');

            $jadwal[$weekKey] = [
                'date'  => $d,
                'shown' => true
            ];
        }

        // ===== PROSES ABSENSI =====
        $absenDates = !empty($row['tanggal_absen'])
            ? explode(',', $row['tanggal_absen'])
            : [];

        foreach ($absenDates as $absen) {

            $absenDT = new DateTime($absen);
            $weekKey = $absenDT->format('oW');

            if (!isset($jadwal[$weekKey])) continue;

            // HAPUS JADWAL DEFAULT
            $jadwal[$weekKey]['shown'] = false;

            // 🔵 KELAS PENGGANTI
            if ((int)$absenDT->format('N') !== $hariIndex) {

                $color  = '#0d6efd';
                $status = 'Kelas Pengganti';

            }
            // 🟢 SESUAI JADWAL
            else {

                $color  = '#28a745';
                $status = 'Sudah Mengisi';
            }

            $events[] = [
                'title' => $row['nama_matkul'],
                'start' => $absenDT->format('Y-m-d'),
                'backgroundColor' => $color,
                'borderColor' => '#343a40',
                'extendedProps' => [
                    'id_frekuensi' => $row['id_frekuensi'],
                    'id_mentoring' => $row['id_mentoring'] ?? null,
                    'ruangan' => $row['nama_ruangan'],
                    'status' => $status,
                    'clickable' => true
                ]
            ];
        }

        // ===== TAMPILKAN JADWAL DEFAULT =====
        foreach ($jadwal as $j) {

            if (!$j['shown']) continue;

            if ($j['date'] < $today) {
                $color  = '#dc3545';
                $status = 'Belum Mengisi';
                $clickable = true;

            } elseif ($j['date'] <= $endOfThisWeek) {
                $color  = '#6c757d';
                $status = 'Belum Waktunya';
                $clickable = false;

            } else {
                continue;
            }

            $events[] = [
                'title' => $row['nama_matkul'],
                'start' => $j['date']->format('Y-m-d'),
                'backgroundColor' => $color,
                'borderColor' => '#343a40',
                'extendedProps' => [
                    'id_frekuensi' => $row['id_frekuensi'],
                    'id_mentoring' => $row['id_mentoring'] ?? null,
                    'ruangan' => $row['nama_ruangan'],
                    'status' => $status,
                    'clickable' => $clickable
                ]
            ];
        }
    }
    echo json_encode($events);
    exit;
    }
}