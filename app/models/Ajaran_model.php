<?php

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
        // $this->db->query("DELETE FROM mst_tahun_ajaran WHERE id_tahun = :id");
        $this->db->query("CALL delete_tahun_with_references(:id)");
        $this->db->bind("id", $id);
        $this->db->execute();

        return $this->db->rowCount(); 
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