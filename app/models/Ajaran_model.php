<?php
require_once __DIR__ . '/Restore_model.php';
class Ajaran_model{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }

    public function tambah($data){
        $this->db->query("INSERT INTO mst_tahun_ajaran (tahun_ajaran ) 
                        VALUES (:tahun_ajaran)");

        $this->db->bind('tahun_ajaran', $data['tahun_ajaran']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function prosesUbah($data){
        $this->db->query("UPDATE mst_tahun_ajaran 
                        SET 
                            tahun_ajaran = :tahun_ajaran
                        WHERE 
                            id_tahun = :id_tahun;");

        $this->db->bind('tahun_ajaran', $data['tahun_ajaran']);
        $this->db->bind('id_tahun', $data['id_tahun']);
    
        $this->db->execute();
    
        return $this->db->rowCount();
    }

    public function tampil(){
        $this->db->query("SELECT * FROM mst_tahun_ajaran;");
        return $this->db->resultSet();
    }

    public function ubah($id){
        $this->db->query("SELECT * FROM mst_tahun_ajaran WHERE id_tahun = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }

    public function prosesHapus($id){
        try {
            // Ambil data tahun ajaran yang akan dihapus
            $ajaran = $this->detailAjaran($id);
            if (!$ajaran) {
                return 0;
            }

            // Simpan ke tabel restore
            $restoreModel = new Restore_model();
            $restoreModel->saveToRestore('mst_tahun_ajaran', $ajaran, $_SESSION['id_user']);

            // Hapus mentoring yang terkait frekuensi tahun ajaran ini
            $this->db->query("DELETE FROM trs_mentoring WHERE id_frekuensi IN (SELECT id_frekuensi FROM trs_frekuensi WHERE id_tahun = :id)");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus frekuensi yang terkait tahun ajaran
            $this->db->query("DELETE FROM trs_frekuensi WHERE id_tahun = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus data dari tabel
            $this->db->query("DELETE FROM mst_tahun_ajaran WHERE id_tahun = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            return $this->db->rowCount();

        } catch (PDOException $e) {
            return 0;
        }
    }

    public function detailAjaran($id){
        $this->db->query("SELECT * FROM mst_tahun_ajaran WHERE id_tahun = :id");
        $this->db->bind("id", $id);
        
        return $this->db->single(); 
    }
    
    public function jumlahDataAjaran() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM mst_tahun_ajaran");
        $result = $this->db->single();
        return $result['jumlah'];
    }     
}