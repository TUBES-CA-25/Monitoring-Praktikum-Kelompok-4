<?php

class Restore_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Ambil semua data restore
    public function getAll()
    {
        $this->db->query("
            SELECT * FROM `restore`
            ORDER BY deleted_at DESC
        ");
        return $this->db->resultSet();
    }

    // Restore data kembali ke tabel asli
    public function restoreData($id)
    {
        // Ambil data restore
        $this->db->query("SELECT * FROM `restore` WHERE id = :id");
        $this->db->bind('id', $id);
        $restore = $this->db->single();
        if (is_object($restore)) {
            $restore = (array) $restore;
        }

        if (!$restore) {
            return false;
        }

        $table = $restore['jenis_data']; // contoh: dosen, user, asisten
        $data  = json_decode($restore['data_json'], true);

        if (!$table || !$data) {
            return false;
        }

        // Validasi: pastikan tabel ada di database untuk menghindari SQL injection via nama tabel
        $this->db->query("
            SELECT COUNT(*) as cnt 
            FROM information_schema.tables 
            WHERE table_schema = DATABASE() AND table_name = :tname
        ");
        $this->db->bind('tname', $table);
        $check = $this->db->single();
        if (is_object($check)) {
            $check = (array) $check;
        }
        if (!$check || intval($check['cnt'] ?? 0) === 0) {
            return false;
        }

        // Siapkan kolom dan parameter
        $fields = array_keys($data);
        // Escape column names with backticks
        $columns = implode(', ', array_map(function ($f) {
            return "`$f`";
        }, $fields));
        $params  = ':' . implode(',:', $fields);

        // Gunakan backticks untuk nama tabel
        $sql = "INSERT INTO `{$table}` ($columns) VALUES ($params)";
        $this->db->query($sql);

        foreach ($data as $key => $value) {
            $this->db->bind($key, $value);
        }

        // Jalankan insert
        $inserted = $this->db->execute();
        if (!$inserted) {
            return false;
        }

        // Hapus dari tabel restore
        $this->db->query("DELETE FROM `restore` WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();

        return true;
    }

    // Hapus permanen dari tabel restore
    public function deletePermanent($id)
    {
        $this->db->query("DELETE FROM `restore` WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    // Simpan data ke tabel restore (dipanggil saat delete)
    public function saveToRestore($table, $data, $deletedBy)
    {
        $dataJson = json_encode($data);

        $this->db->query("INSERT INTO `restore` (jenis_data, data_json, deleted_by, deleted_at) 
                        VALUES (:jenis_data, :data_json, :deleted_by, NOW())");
        
        $this->db->bind('jenis_data', $table);
        $this->db->bind('data_json', $dataJson);
        $this->db->bind('deleted_by', $deletedBy);

        return $this->db->execute();
    }
}
?>