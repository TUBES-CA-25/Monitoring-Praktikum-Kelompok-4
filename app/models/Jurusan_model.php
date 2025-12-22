<?php

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
        // $this->db->query("DELETE FROM mst_jurusan WHERE id_jurusan = :id");
        $this->db->query("CALL delete_jurusan_with_references(:id)");
        $this->db->bind("id", $id);
        $this->db->execute();

        return $this->db->rowCount(); 
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