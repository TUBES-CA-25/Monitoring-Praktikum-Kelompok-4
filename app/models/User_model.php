<?php

class User_model{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }

    public function tambah($data){
        $this->db->query("INSERT INTO mst_user (nama_user, username, password, role) 
                        VALUES (:nama_user, :username, :password, :role)");
        $this->db->bind('nama_user', $data['nama_user']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('role', $data['role']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahByAsisten($data){
        $query = "INSERT INTO mst_user (nama_user, username, password, role) 
                  VALUES (:nama_user, :username, :password, :role)";
        
        $this->db->query($query);
        
        // PERBAIKAN: Tambahkan titik dua (:)
        $this->db->bind(':nama_user', $data['nama_user']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':role', $data['role']);

        try {
            $this->db->execute();
            return $this->db->rowCount();
        } catch (PDOException $e) {
            return 0;
        }
    }

    // TAMBAHAN UPDATE DATA USER DENGAN VALIDASI PASSWORD (rafli)
    public function updateDataUser($data) {
        $query = "UPDATE mst_user SET username = :username";
        
        if (!empty($data['password'])) {
            $query .= ", password = :password";
        }
        
        $query .= " WHERE id_user = :id_user";

        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('id_user', $data['id_user']);
        
        if (!empty($data['password'])) {
            $this->db->bind('password', hash('sha256', $data['password']));
        }

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getUserById($id) {
        $this->db->query("SELECT * FROM mst_user WHERE id_user = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function prosesUbah($data){
        if (!empty($data['password'])) {
            $query = "UPDATE mst_user 
                      SET nama_user = :nama_user, 
                          username = :username, 
                          password = :password, 
                          role = :role 
                      WHERE id_user = :id_user";
        } else {
            $query = "UPDATE mst_user 
                      SET nama_user = :nama_user, 
                          username = :username, 
                          role = :role 
                      WHERE id_user = :id_user";
        }

        $this->db->query($query);
        $this->db->bind('nama_user', $data['nama_user']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('id_user', $data['id_user']);

        if (!empty($data['password'])) {
            $this->db->bind('password', $data['password']);
        }
        try {
            $this->db->execute();
            return true; 
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function tampil(){
        $this->db->query("SELECT * FROM mst_user ORDER BY id_user ASC");
        
        return $this->db->resultSet();
    }

    public function ubah($id){
        $this->db->query("SELECT * FROM mst_user WHERE id_user = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }

    public function prosesHapus($id){
        $this->db->query("CALL delete_user_with_references(:id)");
        $this->db->bind("id", $id);
        $this->db->execute();

        return $this->db->rowCount(); 
    }

    public function detailUser($id){
        $this->db->query("SELECT * FROM mst_user WHERE id_user = :id");
        $this->db->bind("id", $id);
        
        return $this->db->single(); 
    }   
    
    public function jumlahDataUser() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM mst_user");
        $result = $this->db->single();
        return $result['jumlah'];
    } 

    public function getUserDetails($id_user) {
        $this->db->query("SELECT * FROM mst_user 
                          LEFT JOIN mst_asisten ON mst_user.id_user = mst_asisten.id_user 
                          WHERE mst_user.id_user = :id_user");
        
        $this->db->bind(':id_user', $id_user);
        return $this->db->resultSet();
    }

    public function getUserByUsername($username)
    {
        $this->db->query('SELECT * FROM mst_user WHERE username = :username');
        $this->db->bind(':username', $username);
        return $this->db->single();
    }
}