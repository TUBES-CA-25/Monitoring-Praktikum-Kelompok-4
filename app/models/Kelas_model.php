<?php

class Kelas_model{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    public function tambah($data){
        $this->db->query("INSERT INTO mst_kelas (id_jurusan, kelas, angkatan) 
                        VALUES (:id_jurusan, :kelas, :angkatan)");

        $this->db->bind('id_jurusan', $data['id_jurusan']);
        $this->db->bind('kelas', $data['kelas']);
        $this->db->bind('angkatan', $data['angkatan']);

        $this->db->execute();

        return $this->db->rowCount();
    }
    public function prosesUbah($data){
        $this->db->query("UPDATE mst_kelas 
                        SET 
                            id_jurusan = :id_jurusan, 
                            kelas = :kelas, 
                            angkatan = :angkatan 
                        WHERE 
                            id_kelas = :id_kelas;");

        $this->db->bind('id_jurusan', $data['id_jurusan']);
        $this->db->bind('kelas', $data['kelas']);
        $this->db->bind('angkatan', $data['angkatan']);
        $this->db->bind('id_kelas', $data['id_kelas']);
    
        $this->db->execute();
    
        return $this->db->rowCount();
    }
    public function tampil(){
        $this->db->query("SELECT mst_kelas.id_kelas, 
                            mst_jurusan.jurusan, 
                            mst_kelas.kelas, 
                            mst_kelas.angkatan
                          FROM 
                            mst_kelas
                          JOIN 
                            mst_jurusan ON mst_kelas.id_jurusan = mst_jurusan.id_jurusan;");
        return $this->db->resultSet();
    }
    
    public function tampilJurusan(){
        $this->db->query("SELECT id_jurusan, jurusan FROM mst_jurusan");

        return $this->db->resultSet();
    }
    public function ubah($id){
        $this->db->query("SELECT * FROM mst_kelas WHERE id_kelas = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }
    public function prosesHapus($id){
        // $this->db->query("DELETE FROM mst_kelas WHERE id_kelas = :id");
        $this->db->query("CALL delete_kelas_with_references(:id)");
        $this->db->bind("id", $id);
        $this->db->execute();

        return $this->db->rowCount(); 
    }
    public function detailKelas($id){
        $this->db->query("SELECT * FROM mst_kelas WHERE id_kelas = :id");
        $this->db->bind("id", $id);
        
        return $this->db->single(); 
    }   
    public function jumlahDataKelas() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM mst_kelas");
        $result = $this->db->single();
        return $result['jumlah'];
    }     
}