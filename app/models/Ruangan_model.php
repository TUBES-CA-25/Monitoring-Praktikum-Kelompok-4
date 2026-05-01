<?php
require_once __DIR__ . '/Restore_model.php';
class Ruangan_model{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }

    public function tambah($data){
        $this->db->query("INSERT INTO mst_ruangan (nama_ruangan) 
                        VALUES (:nama_ruangan)");
        $this->db->bind('nama_ruangan', $data['nama_ruangan']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function prosesUbah($data){
        $this->db->query("UPDATE mst_ruangan 
                        SET 
                            nama_ruangan = :nama_ruangan 
                        WHERE 
                            id_ruangan = :id_ruangan;");

        $this->db->bind('nama_ruangan', $data['nama_ruangan']);
        $this->db->bind('id_ruangan', $data['id_ruangan']);
    
        $this->db->execute();
    
        return $this->db->rowCount();
    }

    public function tampil(){
        $this->db->query("SELECT * FROM mst_ruangan ORDER BY id_ruangan ASC");
        return $this->db->resultSet();
    }

    public function ubah($id){
        $this->db->query("SELECT * FROM mst_ruangan WHERE id_ruangan = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }

    public function prosesHapus($id){
        try {
            // Ambil data ruangan yang akan dihapus
            $ruangan = $this->detailRuangan($id);
            if (!$ruangan) {
                return 0;
            }

            // Simpan ke tabel restore
            $restoreModel = new Restore_model();
            $restoreModel->saveToRestore('mst_ruangan', $ruangan, $_SESSION['id_user']);

            // Hapus mentoring yang terkait frekuensi di ruangan ini
            $this->db->query("DELETE FROM trs_mentoring WHERE id_frekuensi IN (SELECT id_frekuensi FROM trs_frekuensi WHERE id_ruangan = :id)");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus frekuensi yang terkait ruangan
            $this->db->query("DELETE FROM trs_frekuensi WHERE id_ruangan = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus data dari tabel mst_ruangan
            $this->db->query("DELETE FROM mst_ruangan WHERE id_ruangan = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            return $this->db->rowCount();

        } catch (PDOException $e) {
            return 0;
        }
    }

    public function detailRuangan($id){
        $this->db->query("SELECT * FROM mst_ruangan WHERE id_ruangan = :id");
        $this->db->bind("id", $id);
        
        return $this->db->single(); 
    }   
    
    public function jumlahDataRuangan() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM mst_ruangan");
        $result = $this->db->single();
        return $result['jumlah'];
    }     
}