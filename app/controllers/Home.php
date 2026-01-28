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

        foreach ($rows as $row) {

            $hariIndex = $hariMap[strtolower($row['hari'])] ?? null;
            if (!$hariIndex) continue;

            $absenDates = !empty($row['tanggal_absen'])
                ? explode(',', $row['tanggal_absen'])
                : [];

            // TANGGAL AWAL JADWAL
            $baseDate = !empty($row['tanggal_mulai'])
                ? new DateTime($row['tanggal_mulai'])
                : new DateTime('today');

            $baseDay = (int)$baseDate->format('N');
            $diff = $hariIndex - $baseDay;

            if ($diff < 0) {
                $diff += 7;
            }

            $startDate = clone $baseDate;
            $startDate->modify("+{$diff} day");


            // GENERATE 12 MINGGU
            for ($i = 0; $i < 12; $i++) {

                $eventDate = clone $startDate;
                $eventDate->modify("+{$i} week");

                $eventDateStr = $eventDate->format('Y-m-d');
                $jadwalWeek   = $eventDate->format('oW');

                // FLAG ABSEN
                $hasSameDay  = false;
                $hasOtherDay = false;

                foreach ($absenDates as $absen) {
                    $absenDT = new DateTime($absen);

                    // MINGGU YANG SAMA
                    if ($absenDT->format('oW') === $jadwalWeek) {
                        if ($absenDT->format('N') == $hariIndex) {
                            $hasSameDay = true;
                        } else {
                            $hasOtherDay = true;
                        }
                    }
                }

                // TENTUKAN WARNA & STATUS (PRIORITAS FIX)
                if ($hasSameDay) {
                    $color  = '#28a745';
                    $status = 'Sudah Mengisi';
                }
                elseif ($hasOtherDay) {
                    $color  = '#0d6efd';
                    $status = 'Kelas Pengganti';
                }
                elseif ($eventDate < $today) {
                    $color  = '#dc3545';
                    $status = 'Belum Mengisi';
                }
                else {
                    $color  = '#6c757d';
                    $status = 'Belum Waktunya';
                }

                $events[] = [
                    'title' => $row['nama_matkul'],
                    'start' => $eventDateStr,
                    'backgroundColor' => $color,
                    'borderColor' => '#343a40',
                    'extendedProps' => [
                        'id_frekuensi' => $row['id_frekuensi'],
                        'ruangan' => $row['nama_ruangan'],
                        'status' => $status,
                        'clickable' => $color !== '#6c757d'
                    ]
                ];
            }
        }

        echo json_encode($events);
        exit;
    }

    }