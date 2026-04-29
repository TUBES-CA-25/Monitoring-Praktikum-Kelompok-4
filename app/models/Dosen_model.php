<?php
require_once __DIR__ . '/Restore_model.php';
class Dosen_model{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function tambah($data){
        $this->db->query("INSERT INTO mst_dosen (nip, nama_dosen, photo_path) 
                        VALUES (:nip, :nama_dosen, :photo_path)");

        $photo_path = $this->uploadPhoto();

        $this->db->bind('nip', $data['nip']);
        $this->db->bind('nama_dosen', $data['nama_dosen']);
        $this->db->bind(':photo_path', $photo_path);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function prosesUbah($data){
        if ($_FILES['photo_path']['error'] === UPLOAD_ERR_NO_FILE) {
            $photo_path = $this->getPhotoPathByID($data['id_asisten']);
        } else {
            $photo_path = $this->uploadPhoto();
        }
        $this->db->query("UPDATE mst_dosen 
                        SET 
                            nip = :nip, 
                            nama_dosen = :nama_dosen,
                            photo_path = :photo_path
                        WHERE 
                            id_dosen = :id_dosen;");

        $this->db->bind('nip', $data['nip']);
        $this->db->bind('nama_dosen', $data['nama_dosen']);
        $this->db->bind('id_dosen', $data['id_dosen']);
        $this->db->bind('photo_path', $photo_path);
    
        $this->db->execute();
    
        return $this->db->rowCount();
    }

    private function getPhotoPathByID($userID) {
        $this->db->query("SELECT photo_path FROM mst_dosen WHERE id_dosen = :id_dosen");
        $this->db->bind(':id_dosen', $userID);
        $result = $this->db->single();
        return $result['photo_path'];
    }
    
    private function uploadPhoto(){
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

    public function tampil(){
        $this->db->query("SELECT * FROM mst_dosen;");
        return $this->db->resultSet();
    }

    public function ubah($id){
        $this->db->query("SELECT * FROM mst_dosen WHERE id_dosen = :id");
        $this->db->bind("id", $id);

        return $this->db->single(); 
    }

    public function prosesHapus($id){
        try {
            // Ambil data dosen yang akan dihapus
            $dosen = $this->detailDosen($id);
            if (!$dosen) {
                return 0;
            }

            // Simpan ke tabel restore
            $restoreModel = new Restore_model();
            $restoreModel->saveToRestore('mst_dosen', $dosen, $_SESSION['id_user']);

            // Hapus mentoring yang terkait frekuensi dosen
            $this->db->query("DELETE FROM trs_mentoring WHERE id_frekuensi IN (SELECT id_frekuensi FROM trs_frekuensi WHERE id_dosen = :id)");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus frekuensi yang terkait dosen
            $this->db->query("DELETE FROM trs_frekuensi WHERE id_dosen = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Hapus data dari tabel mst_dosen
            $this->db->query("DELETE FROM mst_dosen WHERE id_dosen = :id");
            $this->db->bind("id", $id);
            $this->db->execute();

            return $this->db->rowCount(); 

        } catch (PDOException $e) {
            return 0;
        }
    }

    public function detailDosen($id){
        $this->db->query("SELECT * FROM mst_dosen WHERE id_dosen = :id");
        $this->db->bind("id", $id);
        
        return $this->db->single(); 
    }
    
    public function jumlahDataDosen() {
        $this->db->query("SELECT COUNT(*) as jumlah FROM mst_dosen");
        $result = $this->db->single();
        return $result['jumlah'];
    }     
}