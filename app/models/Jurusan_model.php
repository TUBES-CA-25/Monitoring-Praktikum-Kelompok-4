<?php
require_once __DIR__ . '/Restore_model.php';
class Jurusan_model{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function tambah($data){
        $this->db->query("INSERT INTO mst_jurusan (jurusan, singkatan_jurusan) 
                        VALUES (:jurusan, :singkatan_jurusan)");
        $this->db->bind('jurusan', $data['jurusan']);
        $this->db->bind('singkatan_jurusan', $data['singkatan_jurusan']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function prosesUbah($data){
        $this->db->query("UPDATE mst_jurusan 
                        SET 
                            jurusan = :jurusan, 
                            singkatan_jurusan = :singkatan_jurusan 
                        WHERE 
                            id_jurusan = :id_jurusan;");

        $this->db->bind('jurusan', $data['jurusan']);
        $this->db->bind('id_jurusan', $data['id_jurusan']);
        $this->db->bind('singkatan_jurusan', $data['singkatan_jurusan']);
    
        $this->db->execute();
    
        return $this->db->rowCount();
    }

    public function tampil(){
        $this->db->query("SELECT * FROM mst_jurusan ORDER BY id_jurusan ASC");
        return $this->db->resultSet();
    }

    public function ubah($id){
        $this->db->query("SELECT * FROM mst_jurusan WHERE id_jurusan = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }

    public function prosesHapus($id){
        try {
            // Ambil data jurusan yang akan dihapus
            $jurusan = $this->ubah($id);
            if (!$jurusan) {
                return 0;
            }

            // Simpan ke tabel restore
            $restoreModel = new Restore_model();
            $restoreModel->saveToRestore('mst_jurusan', $jurusan, $_SESSION['id_user']);

            // Hapus mentoring yang terkait frekuensi jurusan ini
            $this->db->query("DELETE FROM trs_mentoring WHERE id_frekuensi IN (SELECT id_frekuensi FROM trs_frekuensi WHERE id_jurusan = :id)");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus frekuensi yang terkait jurusan
            $this->db->query("DELETE FROM trs_frekuensi WHERE id_jurusan = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus data dari tabel mst_jurusan
            $this->db->query("DELETE FROM mst_jurusan WHERE id_jurusan = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            return $this->db->rowCount();

        } catch (PDOException $e) {
            return 0;
        }
    }

    public function jumlahDataJurusan() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM mst_jurusan");
        $result = $this->db->single();
        return $result['jumlah'];
    }
    
    public function getJurusanIdByID($jurusan) {
        $this->db->query("SELECT id_jurusan FROM mst_jurusan WHERE jurusan = :jurusan");
        $this->db->bind('jurusan', $jurusan);
        return $this->db->single();
    }
}