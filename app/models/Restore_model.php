<?php

class Restore_model {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAll() {
        $this->db->query("SELECT * FROM trs_restore ORDER BY deleted_at DESC");
        return $this->db->resultSet();
    }

    public function restoreData($id_restore) {
        try {
            $this->db->query("SELECT * FROM trs_restore WHERE id_restore = :id");
            $this->db->bind(':id', $id_restore);
            $dataRestore = $this->db->single();
            
            if (!$dataRestore) return 0;

            $data = json_decode($dataRestore['data_json'], true);

            // Cek apakah User masih ada di mst_user[cite: 1]
            $this->db->query("SELECT id_user FROM mst_user WHERE id_user = :id_user");
            $this->db->bind(':id_user', $data['id_user']);
            $userExists = $this->db->single();

            if (!$userExists) {
                // Buat ulang user jika hilang agar foreign key tidak error[cite: 1]
                $passwordDefault = password_hash('iclabs-umi', PASSWORD_DEFAULT);
                $this->db->query("INSERT INTO mst_user (id_user, username, password, role, nama_user) 
                                VALUES (:id_user, :username, :password, 'Asisten', :nama)");
                $this->db->bind(':id_user', $data['id_user']);
                $this->db->bind(':username', $data['stambuk'] . '@student.umi.ac.id');
                $this->db->bind(':password', $passwordDefault);
                $this->db->bind(':nama', $data['nama_asisten']);
                $this->db->execute();
            }

            // Masukkan kembali ke mst_asisten[cite: 1]
            $query = "INSERT INTO mst_asisten 
                        (id_asisten, stambuk, nama_asisten, angkatan, status, jenis_kelamin, id_user, photo_profil, photo_path) 
                    VALUES 
                        (:id, :stambuk, :nama, :angkatan, :status, :jk, :id_user, :pp, :ttd)";
            
            $this->db->query($query);
            $this->db->bind(':id', $data['id_asisten']);
            $this->db->bind(':stambuk', $data['stambuk']);
            $this->db->bind(':nama', $data['nama_asisten']);
            $this->db->bind(':angkatan', $data['angkatan']);
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':jk', $data['jenis_kelamin']);
            $this->db->bind(':id_user', $data['id_user']);
            $this->db->bind(':pp', $data['photo_profil']);
            $this->db->bind(':ttd', $data['photo_path']);
            $this->db->execute();

            // Hapus dari trs_restore
            $this->db->query("DELETE FROM trs_restore WHERE id_restore = :id");
            $this->db->bind(':id', $id_restore);
            $this->db->execute();

            return 1;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function deletePermanent($id) {
        $this->db->query("DELETE FROM trs_restore WHERE id_restore = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function saveToRestore($table, $data, $deletedBy) {
        $dataJson = json_encode($data);
        $this->db->query("INSERT INTO trs_restore (jenis_data, data_json, deleted_by, deleted_at) 
                        VALUES (:jenis_data, :data_json, :deleted_by, NOW())");
        $this->db->bind('jenis_data', $table);
        $this->db->bind('data_json', $dataJson);
        $this->db->bind('deleted_by', $deletedBy);
        return $this->db->execute();
    }
}