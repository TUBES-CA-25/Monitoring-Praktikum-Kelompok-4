<?php

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
        // $this->db->query("DELETE FROM mst_ruangan WHERE id_ruangan = :id");
        $this->db->query("CALL delete_ruangan_with_references(:id)");
        $this->db->bind("id", $id);
        $this->db->execute();

        return $this->db->rowCount(); 
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