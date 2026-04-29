<?php

require_once __DIR__ . '/Restore_model.php';

class Asisten_model {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function tambah($data) {
        $query = "INSERT INTO mst_asisten 
                    (stambuk, nama_asisten, angkatan, status, jenis_kelamin, id_user, photo_profil, photo_path) 
                VALUES 
                    (:stambuk, :nama_asisten, :angkatan, :status, :jenis_kelamin, :id_user, :photo_profil, :photo_path)";

        $this->db->query($query);

        $this->db->bind(':stambuk', $data['stambuk']);
        $this->db->bind(':nama_asisten', $data['nama_asisten']);
        $this->db->bind(':angkatan', $data['angkatan']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind(':id_user', $data['id_user']);
        
        $this->db->bind(':photo_profil', $data['photo_profil']);
        $this->db->bind(':photo_path', $data['photo_path']);

        $this->db->execute();

        return $this->db->rowCount();
    }
    
    public function cekStambuk($stambuk) {
        $this->db->query("SELECT id_asisten FROM mst_asisten WHERE stambuk = :stambuk");
        $this->db->bind(':stambuk', $stambuk);
        return $this->db->single();
    }

    public function prosesUbah($data) {
        $query = "UPDATE mst_asisten 
                  SET 
                    stambuk = :stambuk, 
                    nama_asisten = :nama_asisten, 
                    angkatan = :angkatan, 
                    status = :status, 
                    jenis_kelamin = :jenis_kelamin, 
                    id_user = :id_user, 
                    photo_profil = :photo_profil, 
                    photo_path = :photo_path 
                  WHERE 
                    id_asisten = :id_asisten";

        $this->db->query($query);

        $this->db->bind(':stambuk', $data['stambuk']);
        $this->db->bind(':nama_asisten', $data['nama_asisten']);
        $this->db->bind(':angkatan', $data['angkatan']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind(':id_user', $data['id_user']);
        $this->db->bind(':id_asisten', $data['id_asisten']);
        
        $this->db->bind(':photo_profil', $data['photo_profil']);
        $this->db->bind(':photo_path', $data['photo_path']);
    
        $this->db->execute();
    
        return $this->db->rowCount();
    }

    public function getPhotoPathByID($id) {
        $this->db->query("SELECT photo_path FROM mst_asisten WHERE id_asisten = :id");
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result['photo_path'];
    }    

    public function getPhoto2PathByID($id) {
        $this->db->query("SELECT photo_profil FROM mst_asisten WHERE id_asisten = :id");
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result['photo_profil'];
    }

    public function prosesHapus($id) {
        try {
            // Ambil data asisten yang akan dihapus
            $asisten = $this->detailAsisten($id);
            if (!$asisten) {
                return 0;
            }

            // Simpan ke tabel restore
            $restoreModel = new Restore_model();
            $restoreModel->saveToRestore('mst_asisten', $asisten, $_SESSION['id_user']);

            // Hapus mentoring yang terkait frekuensi asisten
            $this->db->query("DELETE FROM trs_mentoring 
                            WHERE id_frekuensi IN (
                                SELECT id_frekuensi FROM trs_frekuensi 
                                WHERE id_asisten1 = :id OR id_asisten2 = :id
                            )");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus frekuensi yang melibatkan asisten
            $this->db->query("DELETE FROM trs_frekuensi 
                            WHERE id_asisten1 = :id OR id_asisten2 = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus data dari tabel mst_asisten
            $this->db->query("DELETE FROM mst_asisten WHERE id_asisten = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            return $this->db->rowCount(); 

        } catch (PDOException $e) {
            return 0;
        }
    }

    public function tampil() {
        $this->db->query("SELECT mst_asisten.id_asisten, 
                            mst_asisten.stambuk, 
                            mst_asisten.nama_asisten, 
                            mst_asisten.angkatan, 
                            mst_asisten.status, 
                            mst_asisten.jenis_kelamin, 
                            mst_user.username,
                            mst_asisten.photo_profil,
                            mst_asisten.photo_path
                          FROM 
                            mst_asisten
                          JOIN 
                            mst_user ON mst_asisten.id_user = mst_user.id_user");
        return $this->db->resultSet();
    }    

    public function tampilUser() {
        $this->db->query("SELECT id_user, username FROM mst_user");
        return $this->db->resultSet();
    }

    public function ubah($id) {
        $this->db->query("SELECT * FROM mst_asisten WHERE id_asisten = :id");
        $this->db->bind(':id', $id);
        return $this->db->single(); 
    }

    public function detailAsisten($id) {
        $this->db->query("SELECT * FROM mst_asisten WHERE id_asisten = :id");
        $this->db->bind(':id', $id);
        return $this->db->single(); 
    }

    public function jumlahDataAsisten() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM mst_asisten");
        $result = $this->db->single();
        return $result['jumlah'];
    }

    public function getAsistenDetails($id_user) {
        $this->db->query("SELECT * FROM mst_asisten 
                          JOIN mst_user ON mst_asisten.id_user = mst_user.id_user 
                          WHERE mst_user.id_user = :id_user");
        
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet(); 
    }

    public function cariDataAsistenByUserId($id_user) {
        $this->db->query("SELECT * FROM mst_asisten WHERE id_user = :id_user");
        $this->db->bind(':id_user', $id_user);
        return $this->db->single();
    }

    public function updateFotoViaUser($id_user, $foto_baru) {
        $this->db->query("UPDATE mst_asisten SET photo_profil = :photo_profil WHERE id_user = :id_user");
        $this->db->bind(':photo_profil', $foto_baru);
        $this->db->bind(':id_user', $id_user);
        
        $this->db->execute();
        return $this->db->rowCount();
    }
}