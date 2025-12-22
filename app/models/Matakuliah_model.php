<?php

class Matakuliah_model{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    public function tambah($data){
        $this->db->query("INSERT INTO mst_matakuliah (kode_matkul, nama_matkul, singkatan, semester, sks, id_jurusan) 
                        VALUES (:kode_matkul, :nama_matkul, :singkatan, :semester, :sks, :id_jurusan)");
        $this->db->bind('kode_matkul', $data['kode_matkul']);
        $this->db->bind('nama_matkul', $data['nama_matkul']);
        $this->db->bind('singkatan', $data['singkatan']);
        $this->db->bind('semester', $data['semester']);
        $this->db->bind('sks', $data['sks']);
        $this->db->bind('id_jurusan', $data['id_jurusan']);

        $this->db->execute();

        return $this->db->rowCount();
    }
    public function prosesUbah($data){
        $this->db->query("UPDATE mst_matakuliah 
                        SET 
                            kode_matkul = :kode_matkul, 
                            nama_matkul = :nama_matkul,
                            singkatan = :singkatan, 
                            semester = :semester, 
                            sks = :sks, 
                            id_jurusan = :id_jurusan 
                        WHERE 
                            id_matkul = :id_matkul;");

        $this->db->bind('kode_matkul', $data['kode_matkul']);
        $this->db->bind('nama_matkul', $data['nama_matkul']);
        $this->db->bind('singkatan', $data['singkatan']);
        $this->db->bind('semester', $data['semester']);
        $this->db->bind('sks', $data['sks']);
        $this->db->bind('id_jurusan', $data['id_jurusan']);
        $this->db->bind('id_matkul', $data['id_matkul']);
    
        $this->db->execute();
    
        return $this->db->rowCount();
    }
    public function tampil(){
        $this->db->query("SELECT mst_matakuliah.id_matkul, 
                            mst_matakuliah.kode_matkul, 
                            mst_matakuliah.nama_matkul, 
                            mst_matakuliah.singkatan, 
                            mst_matakuliah.semester, 
                            mst_matakuliah.sks, 
                            mst_jurusan.jurusan
                          FROM 
                            mst_matakuliah
                          JOIN 
                            mst_jurusan ON mst_matakuliah.id_jurusan = mst_jurusan.id_jurusan;");
        return $this->db->resultSet();
    }
    public function tampilJurusan(){
        $this->db->query("SELECT id_jurusan, jurusan FROM mst_jurusan");

        return $this->db->resultSet();
    }
    public function ubah($id){
        $this->db->query("SELECT * FROM mst_matakuliah WHERE id_matkul = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }
    public function prosesHapus($id){
        // $this->db->query("DELETE FROM mst_matakuliah WHERE id_matkul = :id");
        $this->db->query("CALL delete_matakuliah_with_references(:id)");
        $this->db->bind("id", $id);
        $this->db->execute();

        return $this->db->rowCount(); 
    }
    public function jumlahDataMatakuliah() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM mst_matakuliah");
        $result = $this->db->single();
        return $result['jumlah'];
    } 
    public function getMatakuliahByJurusan($id_jurusan){
        $this->db->query("SELECT id_matkul, nama_matkul FROM mst_matakuliah WHERE id_jurusan = :id_jurusan");
        $this->db->bind('id_jurusan', $id_jurusan);
        return $this->db->resultSet();
    }
    
}