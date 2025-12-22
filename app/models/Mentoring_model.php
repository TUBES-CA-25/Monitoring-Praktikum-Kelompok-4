<?php

class Mentoring_model{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }    
    public function tambah($data){
        $this->db->query("INSERT INTO trs_mentoring 
                            (id_frekuensi, tanggal, uraian_materi, uraian_tugas, hadir, alpa, status_dosen, status_asisten1, status_asisten2, id_asisten_pengganti) 
                        VALUES 
                            (:id_frekuensi, :tanggal, :uraian_materi, :uraian_tugas, :hadir, :alpa, :status_dosen, :status_asisten1, :status_asisten2, :id_asisten_pengganti)");
        
        $this->db->bind('id_frekuensi', $data['id_frekuensi']);

        $this->db->bind('tanggal', $data['tanggal']);

        $this->db->bind('uraian_materi', $data['uraian_materi']);
        $this->db->bind('uraian_tugas', $data['uraian_tugas']);
        $this->db->bind('hadir', $data['hadir']);
        $this->db->bind('alpa', $data['alpa']);
        $this->db->bind('status_dosen', $data['status_dosen']);
        $this->db->bind('status_asisten1', $data['status_asisten1']);
        $this->db->bind('status_asisten2', $data['status_asisten2']);
        $this->db->bind('id_asisten_pengganti', !empty($data['id_asisten_pengganti']) ? $data['id_asisten_pengganti'] : null);
            
        try {
            $this->db->execute();
            return $data['id_frekuensi'];
        } catch (Exception $e) {
            return false;
        }
    }
    public function prosesUbah($data){
        $id_asisten_pengganti = isset($data['id_asisten_pengganti']) && $data['id_asisten_pengganti'] !== '' ? $data['id_asisten_pengganti'] : null;
    
        $this->db->query("UPDATE trs_mentoring 
                          SET 
                              id_frekuensi = :id_frekuensi, 
                              tanggal = :tanggal, 
                              uraian_materi = :uraian_materi, 
                              uraian_tugas = :uraian_tugas, 
                              hadir = :hadir, 
                              alpa = :alpa, 
                              status_dosen = :status_dosen, 
                              status_asisten1 = :status_asisten1, 
                              status_asisten2 = :status_asisten2, 
                              id_asisten_pengganti = :id_asisten_pengganti
                          WHERE 
                              id_mentoring = :id_mentoring;");
    
        $this->db->bind('id_frekuensi', $data['id_frekuensi']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('uraian_materi', $data['uraian_materi']);
        $this->db->bind('uraian_tugas', $data['uraian_tugas']);
        $this->db->bind('hadir', $data['hadir']);
        $this->db->bind('alpa', $data['alpa']);
        $this->db->bind('status_dosen', $data['status_dosen']);
        $this->db->bind('status_asisten1', $data['status_asisten1']);
        $this->db->bind('status_asisten2', $data['status_asisten2']);
        $this->db->bind('id_asisten_pengganti', $id_asisten_pengganti, $id_asisten_pengganti === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $this->db->bind('id_mentoring', $data['id_mentoring']);
        
        try {
            $this->db->execute();
            return $this->db->rowCount();
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function tampil(){
        $this->db->query("SELECT
                            trs_mentoring.id_mentoring,
                            trs_frekuensi.id_frekuensi,
                            trs_mentoring.tanggal,
                            trs_mentoring.uraian_materi,
                            trs_mentoring.uraian_tugas,
                            trs_mentoring.hadir,
                            trs_mentoring.alpa,
                            trs_mentoring.status_dosen,
                            trs_mentoring.status_asisten1,
                            trs_mentoring.status_asisten2,
                            mst_asisten.nama_asisten
                            -- trs_frekuensi.kode_matkul,
                            -- mst_matakuliah.nama_matkul,
                            -- mst_asisten.frekuensi,
                            -- mst_asisten.nama_asisten,
                            -- mst_asisten.nama_asisten,
                            -- mst_asisten.nama_asisten,
                            -- mst_asisten.nama_asisten,
                            -- mst_asisten.nama_asisten
                        FROM
                            trs_mentoring
                        JOIN
                            mst_asisten ON trs_mentoring.id_asisten_pengganti = mst_asisten.id_asisten
                        JOIN
                            trs_frekuensi ON trs_mentoring.id_frekuensi = trs_frekuensi.id_frekuensi;");
        return $this->db->resultSet();
    }
    
    public function tampilDosen(){
        $this->db->query("SELECT id_dosen, nama_dosen FROM mst_dosen");

        return $this->db->resultSet();
    }
    public function tampilAsisten(){
        $this->db->query("SELECT id_asisten, nama_asisten FROM mst_asisten");

        return $this->db->resultSet();
    }
    public function tampilMatakuliah(){
        $this->db->query("SELECT id_matkul, nama_matkul, semester FROM mst_matakuliah");

        return $this->db->resultSet();
    }
    public function tampilKelas(){
        $this->db->query("SELECT id_kelas, kelas FROM mst_kelas");

        return $this->db->resultSet();
    }
    public function tampilFrekuensi(){
        $this->db->query("SELECT id_frekuensi, frekuensi FROM trs_frekuensi");

        return $this->db->resultSet();
    }
    public function tampilRuangan(){
        $this->db->query("SELECT id_ruangan, nama_ruangan FROM mst_ruangan");

        return $this->db->resultSet();
    }
    public function ubah($id){
        $this->db->query("SELECT * FROM trs_mentoring WHERE id_mentoring = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }
    public function prosesHapus($id){
        $this->db->query("DELETE FROM trs_mentoring WHERE id_mentoring = :id");
        $this->db->bind("id", $id);
        $this->db->execute();

        return $this->db->rowCount(); 
    }
    public function detailMentoring($id){
        $this->db->query("SELECT * FROM trs_mentoring WHERE id_mentoring = :id");
        $this->db->bind("id", $id);
        
        return $this->db->single(); 
    }   
    public function jumlahDataMentoring() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM trs_mentoring");
        $result = $this->db->single();
        return $result['jumlah'];
    }     
    public function cekJumlahMentoring($id_frekuensi) {
        $this->db->query("SELECT COUNT(*) as jumlah FROM trs_mentoring WHERE id_frekuensi = :id_frekuensi");
        $this->db->bind('id_frekuensi', $id_frekuensi);
        $result = $this->db->single();
        return $result['jumlah'];
    }
    public function getCountByFrekuensi($id_frekuensi) {
        $this->db->query("SELECT COUNT(*) as count FROM trs_mentoring WHERE id_frekuensi = :id_frekuensi");
        $this->db->bind(':id_frekuensi', $id_frekuensi);
        $result = $this->db->single();
        return $result['count'];
    }

    public function getHariIni($id_asisten) {
        $this->db->query("
            SELECT j.id_jadwal, m.nama_matkul, j.jam_mulai, j.jam_selesai, r.nama_ruangan
            FROM jadwal_praktikum j
            JOIN mst_matakuliah m ON j.id_matkul = m.id_matkul
            JOIN mst_ruangan r ON j.id_ruangan = r.id_ruangan
            WHERE j.id_asisten = :id
              AND j.tanggal = CURDATE()
            LIMIT 1
        ");
        $this->db->bind('id', $id_asisten);
        return $this->db->single();
    }

    public function getAktivitasTerakhir($id_asisten) {
        $this->db->query("
            SELECT m.nama_matkul, r.nama_ruangan, mon.tanggal
            FROM monitoring mon
            JOIN jadwal_praktikum j ON mon.id_jadwal = j.id_jadwal
            JOIN mst_matakuliah m ON j.id_matkul = m.id_matkul
            JOIN mst_ruangan r ON j.id_ruangan = r.id_ruangan
            WHERE mon.id_asisten = :id
            ORDER BY mon.tanggal DESC
            LIMIT 5
        ");
        $this->db->bind('id', $id_asisten);
        return $this->db->resultSet();
    }

    public function getCalendarAsisten($id_asisten)
    {
        $this->db->query("
            SELECT
                tm.id_mentoring,
                tm.tanggal,
                tm.status_dosen,
                tm.id_asisten_pengganti,

                f.id_frekuensi,
                mk.nama_matkul,
                r.nama_ruangan
            FROM trs_frekuensi f
            JOIN mst_matakuliah mk ON f.id_matkul = mk.id_matkul
            JOIN mst_ruangan r ON f.id_ruangan = r.id_ruangan
            LEFT JOIN trs_mentoring tm 
                ON tm.id_frekuensi = f.id_frekuensi
            WHERE f.id_asisten1 = :id_asisten
        ");

        $this->db->bind('id_asisten', $id_asisten);
        return $this->db->resultSet();
    }

}