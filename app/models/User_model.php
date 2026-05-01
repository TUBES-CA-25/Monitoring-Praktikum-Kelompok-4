<?php
require_once __DIR__ . '/Restore_model.php';
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
    
    public function tampil(){
        $this->db->query("SELECT * FROM mst_user ORDER BY id_user ASC");
        
        return $this->db->resultSet();
    }

    public function ubah($id){
        $this->db->query("SELECT * FROM mst_user WHERE id_user = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }

    public function prosesHapus($id_user) {
        try {
            // 1. Cari tahu apakah user ini adalah seorang asisten
            $this->db->query("SELECT id_asisten FROM mst_asisten WHERE id_user = :id_user");
            $this->db->bind(':id_user', $id_user);
            $asisten = $this->db->single();

            // 2. Jika dia asisten, hapus data asistennya dulu
            if ($asisten) {
                $id_asisten = $asisten['id_asisten'];
                
                // Hapus data yang bergantung pada id_asisten (mentoring & frekuensi)
                $this->db->query("DELETE FROM trs_mentoring WHERE id_frekuensi IN (SELECT id_frekuensi FROM trs_frekuensi WHERE id_asisten1 = :id OR id_asisten2 = :id)");
                $this->db->bind(':id', $id_asisten);
                $this->db->execute();

                $this->db->query("DELETE FROM trs_frekuensi WHERE id_asisten1 = :id OR id_asisten2 = :id");
                $this->db->bind(':id', $id_asisten);
                $this->db->execute();

                // Hapus dari tabel mst_asisten
                $this->db->query("DELETE FROM mst_asisten WHERE id_asisten = :id");
                $this->db->bind(':id', $id_asisten);
                $this->db->execute();
            }

            // 3. Setelah data asisten bersih, baru hapus data di mst_user
            $this->db->query("DELETE FROM mst_user WHERE id_user = :id_user");
            $this->db->bind(':id_user', $id_user);
            $this->db->execute();

            return $this->db->rowCount(); 

        } catch (PDOException $e) {
            // Jika gagal karena constraint, kita bisa log errornya
            return 0;
        }
    }

    public function ubahDataUser($data) {
        $query = "UPDATE mst_user SET 
                    username = :username,
                    password = :password,
                    nama_user = :nama
                WHERE id_user = :id_user";
        
        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('nama', $data['nama_user']); 
        $this->db->bind('id_user', $data['id_user']);

        return $this->db->execute();
    }

    public function ubahDataUserLengkap($data) {
        $query = "UPDATE mst_user SET 
                    nama_user = :nama,
                    username = :username,
                    password = :password,
                    role = :role,
                    photo_profil = :photo_profil,
                    photo_path = :photo_path
                WHERE id_user = :id_user";
        
        $this->db->query($query);
        $this->db->bind('nama', $data['nama_user']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('photo_profil', $data['photo_profil']);
        $this->db->bind('photo_path', $data['photo_path']);
        $this->db->bind('id_user', $data['id_user']);

        return $this->db->execute();
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

    public function getUserByUsernameExceptMe($username, $id_user) {
        // Query ini mencari: Apakah ada username yang sama, tapi miliknya orang lain (id_user berbeda)?
        $this->db->query("SELECT * FROM mst_user WHERE username = :username AND id_user != :id_user");
        $this->db->bind('username', $username);
        $this->db->bind('id_user', $id_user);
        
        return $this->db->single();
    }
}