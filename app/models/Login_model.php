<?php

class Login_model {
    private $table = 'mst_user';
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUser($username) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE username = :username");
        $this->db->bind('username', $username);
        return $this->db->single();
    }

    public function getRole($username) {
        $this->db->query('SELECT role FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind('username', $username);        
        return $this->db->single();
    }

    public function getNamaUser($username) {
        $this->db->query('SELECT nama_user FROM ' . $this->table . ' WHERE username = :username');
        $this->db->bind('username', $username);    
        $result = $this->db->single();
    
        if ($result) {
            return $result['nama_user'];
        } else {
            return false;
        }
    }

    public function isDefaultPassword($password) {
        $defaultPasswords = ['Admin', 'Dosen', 'Asisten'];
        return in_array($password, $defaultPasswords);
    }

    public function updatePassword($id_user, $hashedPassword) {
        $this->db->query("UPDATE " . $this->table . " SET password = :password WHERE id_user = :id_user");
        $this->db->bind('password', $hashedPassword);
        $this->db->bind('id_user', $id_user);
        return $this->db->execute();
    }
}