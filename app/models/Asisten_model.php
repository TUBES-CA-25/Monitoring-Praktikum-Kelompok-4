<?php

class Asisten_model {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function tambah($data) {
        $photo_path = $this->uploadPhoto();
        $photo_profil = $this->uploadPhoto2();

        $this->db->query("INSERT INTO mst_asisten (stambuk, nama_asisten, angkatan, status, jenis_kelamin, id_user, photo_profil, photo_path) 
                        VALUES (:stambuk, :nama_asisten, :angkatan, :status, :jenis_kelamin, :id_user, :photo_profil, :photo_path)");

        $this->db->bind(':stambuk', $data['stambuk']);
        $this->db->bind(':nama_asisten', $data['nama_asisten']);
        $this->db->bind(':angkatan', $data['angkatan']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind(':id_user', $data['id_user']);
        $this->db->bind(':photo_profil', $photo_profil);
        $this->db->bind(':photo_path', $photo_path);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function prosesUbah($data) {
        if ($_FILES['photo_path']['error'] === UPLOAD_ERR_NO_FILE) {
            $photo_path = $this->getPhotoPathByID($data['id_asisten']);
        } else {
            $photo_path = $this->uploadPhoto();
        }

        if ($_FILES['photo_profil']['error'] === UPLOAD_ERR_NO_FILE) {
            $photo_profil = $this->getPhoto2PathByID($data['id_asisten']);
        } else {
            $photo_profil = $this->uploadPhoto2();
        }

        $this->db->query("UPDATE mst_asisten 
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
                            id_asisten = :id_asisten");

        $this->db->bind(':stambuk', $data['stambuk']);
        $this->db->bind(':nama_asisten', $data['nama_asisten']);
        $this->db->bind(':angkatan', $data['angkatan']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':jenis_kelamin', $data['jenis_kelamin']);
        $this->db->bind(':id_user', $data['id_user']);
        $this->db->bind(':id_asisten', $data['id_asisten']);
        $this->db->bind(':photo_profil', $photo_profil);
        $this->db->bind(':photo_path', $photo_path);
    
        $this->db->execute();
    
        return $this->db->rowCount();
    }

    private function getPhotoPathByID($userID) {
        $this->db->query("SELECT photo_path FROM mst_asisten WHERE id_asisten = :id_asisten");
        $this->db->bind(':id_asisten', $userID);
        $result = $this->db->single();
        return $result['photo_path'];
    }    

    private function getPhoto2PathByID($userID) {
        $this->db->query("SELECT photo_profil FROM mst_asisten WHERE id_asisten = :id_asisten");
        $this->db->bind(':id_asisten', $userID);
        $result = $this->db->single();
        return $result['photo_profil'];
    }    

    private function uploadPhoto() {
        if (!isset($_FILES['photo_path'])) {
            return null;
        }

        $file = $_FILES['photo_path'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];
    
        if ($fileError === UPLOAD_ERR_OK) {
            $destination = 'public/img/signature/' . $fileName;
            move_uploaded_file($fileTmpName, $destination);
            return $destination; 
        } else {
            return null;
        }
    }

    private function uploadPhoto2() {
        if (!isset($_FILES['photo_profil'])) {
            return null;
        }

        $file = $_FILES['photo_profil'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];
    
        if ($fileError === UPLOAD_ERR_OK) {
            $destination = 'public/img/uploads/' . $fileName;
            move_uploaded_file($fileTmpName, $destination);
            return $destination; 
        } else {
            return null;
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
                            mst_user ON mst_asisten.id_user = mst_user.id_user;");
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

    public function prosesHapus($id) {
        $this->db->query("CALL delete_asisten_with_references(:id)");
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount(); 
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