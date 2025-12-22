<?php

class Jadwal_model {

    private $db;
    public function __construct() {
        $this->db = new Database;
    }

    public function getCalendarAsisten($id_asisten) {
        $this->db->query("
            SELECT 
                j.id_jadwal,
                j.tanggal,
                j.jam_mulai,
                j.jam_selesai,
                m.nama_matkul,
                m.singkatan,
                r.nama_ruangan,
                mon.id_monitoring
            FROM jadwal_praktikum j
            JOIN mst_matakuliah m ON j.id_matkul = m.id_matkul
            JOIN mst_ruangan r ON j.id_ruangan = r.id_ruangan
            LEFT JOIN monitoring mon 
                ON mon.id_jadwal = j.id_jadwal 
                AND mon.id_asisten = :id_asisten
            WHERE j.id_asisten = :id_asisten
        ");

        $this->db->bind('id_asisten', $id_asisten);
        $rows = $this->db->resultSet();

        $events = [];
        foreach ($rows as $r) {

            // WARNA EVENT
            if ($r['id_monitoring']) {
                $color = '#28a745'; // hijau
            } elseif ($r['tanggal'] == date('Y-m-d')) {
                $color = '#ffc107'; // kuning
            } else {
                $color = '#dc3545'; // merah
            }

            $events[] = [
                'title' => $r['singkatan'],
                'start' => $r['tanggal'] . 'T' . $r['jam_mulai'],
                'end'   => $r['tanggal'] . 'T' . $r['jam_selesai'],
                'color' => $color,
                'id_jadwal' => $r['id_jadwal']
            ];
        }

        return $events;
    }
}
