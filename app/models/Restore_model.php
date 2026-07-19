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

    /**
     * Restore data ke tabel asalnya berdasarkan jenis_data.
     * Mendukung: mst_asisten, mst_dosen, mst_ruangan, mst_jurusan,
     *            mst_kelas, mst_matakuliah, mst_user
     */
    public function restoreData($id_restore) {
        try {
            $this->db->query("SELECT * FROM trs_restore WHERE id_restore = :id");
            $this->db->bind(':id', $id_restore);
            $dataRestore = $this->db->single();

            if (!$dataRestore) return 0;

            $data   = json_decode($dataRestore['data_json'], true);
            $jenis  = $dataRestore['jenis_data'];
            $result = 0;

            switch ($jenis) {

                // ── ASISTEN ──────────────────────────────────────────────
                case 'mst_asisten':
                    // Pastikan mst_user-nya masih ada
                    $this->db->query("SELECT id_user FROM mst_user WHERE id_user = :id");
                    $this->db->bind(':id', $data['id_user']);
                    $userExists = $this->db->single();

                    if (!$userExists) {
                        $passDefault = hash('sha256', 'iclabs-umi');
                        $this->db->query("INSERT INTO mst_user 
                                            (id_user, username, password, role, nama_user)
                                          VALUES (:id, :uname, :pass, 'Asisten', :nama)");
                        $this->db->bind(':id',    $data['id_user']);
                        $this->db->bind(':uname', $data['stambuk'] . '@student.umi.ac.id');
                        $this->db->bind(':pass',  $passDefault);
                        $this->db->bind(':nama',  $data['nama_asisten']);
                        $this->db->execute();
                    }

                    // Cek apakah id_asisten sudah ada (cegah duplicate)
                    $this->db->query("SELECT id_asisten FROM mst_asisten WHERE id_asisten = :id");
                    $this->db->bind(':id', $data['id_asisten']);
                    if ($this->db->single()) return -1;

                    $this->db->query("INSERT INTO mst_asisten 
                                        (id_asisten, stambuk, nama_asisten, angkatan, status, jenis_kelamin, id_user, photo_profil, photo_path)
                                      VALUES 
                                        (:id, :stambuk, :nama, :angkatan, :status, :jk, :id_user, :pp, :ttd)");
                    $this->db->bind(':id',       $data['id_asisten']);
                    $this->db->bind(':stambuk',  $data['stambuk']);
                    $this->db->bind(':nama',     $data['nama_asisten']);
                    $this->db->bind(':angkatan', $data['angkatan']);
                    $this->db->bind(':status',   $data['status']);
                    $this->db->bind(':jk',       $data['jenis_kelamin']);
                    $this->db->bind(':id_user',  $data['id_user']);
                    $this->db->bind(':pp',       $data['photo_profil'] ?? null);
                    $this->db->bind(':ttd',      $data['photo_path']   ?? null);
                    $this->db->execute();
                    $result = 1;
                    break;

                // ── DOSEN ────────────────────────────────────────────────
                case 'mst_dosen':
                    $this->db->query("SELECT id_dosen FROM mst_dosen WHERE id_dosen = :id");
                    $this->db->bind(':id', $data['id_dosen']);
                    if ($this->db->single()) return -1;

                    $this->db->query("INSERT INTO mst_dosen (id_dosen, nip, nama_dosen, photo_path)
                                      VALUES (:id, :nip, :nama, :photo)");
                    $this->db->bind(':id',    $data['id_dosen']);
                    $this->db->bind(':nip',   $data['nip']        ?? null);
                    $this->db->bind(':nama',  $data['nama_dosen']);
                    $this->db->bind(':photo', $data['photo_path'] ?? null);
                    $this->db->execute();
                    $result = 1;
                    break;

                // ── RUANGAN ──────────────────────────────────────────────
                case 'mst_ruangan':
                    $this->db->query("SELECT id_ruangan FROM mst_ruangan WHERE id_ruangan = :id");
                    $this->db->bind(':id', $data['id_ruangan']);
                    if ($this->db->single()) return -1;

                    $this->db->query("INSERT INTO mst_ruangan (id_ruangan, nama_ruangan)
                                      VALUES (:id, :nama)");
                    $this->db->bind(':id',   $data['id_ruangan']);
                    $this->db->bind(':nama', $data['nama_ruangan']);
                    $this->db->execute();
                    $result = 1;
                    break;

                // ── JURUSAN ──────────────────────────────────────────────
                case 'mst_jurusan':
                    $this->db->query("SELECT id_jurusan FROM mst_jurusan WHERE id_jurusan = :id");
                    $this->db->bind(':id', $data['id_jurusan']);
                    if ($this->db->single()) return -1;

                    $this->db->query("INSERT INTO mst_jurusan (id_jurusan, jurusan, singkatan_jurusan)
                                      VALUES (:id, :jurusan, :singkatan)");
                    $this->db->bind(':id',        $data['id_jurusan']);
                    $this->db->bind(':jurusan',   $data['jurusan']);
                    $this->db->bind(':singkatan', $data['singkatan_jurusan'] ?? null);
                    $this->db->execute();
                    $result = 1;
                    break;

                // ── KELAS ────────────────────────────────────────────────
                case 'mst_kelas':
                    $this->db->query("SELECT id_kelas FROM mst_kelas WHERE id_kelas = :id");
                    $this->db->bind(':id', $data['id_kelas']);
                    if ($this->db->single()) return -1;

                    $this->db->query("INSERT INTO mst_kelas (id_kelas, id_jurusan, kelas, angkatan)
                                      VALUES (:id, :id_jurusan, :kelas, :angkatan)");
                    $this->db->bind(':id',         $data['id_kelas']);
                    $this->db->bind(':id_jurusan', $data['id_jurusan']);
                    $this->db->bind(':kelas',      $data['kelas']);
                    $this->db->bind(':angkatan',   $data['angkatan']);
                    $this->db->execute();
                    $result = 1;
                    break;

                // ── MATAKULIAH ───────────────────────────────────────────
                case 'mst_matakuliah':
                    $this->db->query("SELECT id_matkul FROM mst_matakuliah WHERE id_matkul = :id");
                    $this->db->bind(':id', $data['id_matkul']);
                    if ($this->db->single()) return -1;

                    $this->db->query("INSERT INTO mst_matakuliah (id_matkul, nama_matkul, sks)
                                      VALUES (:id, :nama, :sks)");
                    $this->db->bind(':id',   $data['id_matkul']);
                    $this->db->bind(':nama', $data['nama_matkul']);
                    $this->db->bind(':sks',  $data['sks'] ?? null);
                    $this->db->execute();
                    $result = 1;
                    break;

                // ── USER / ADMIN ─────────────────────────────────────────
                case 'mst_user':
                    $this->db->query("SELECT id_user FROM mst_user WHERE id_user = :id");
                    $this->db->bind(':id', $data['id_user']);
                    if ($this->db->single()) return -1;

                    $this->db->query("INSERT INTO mst_user 
                                        (id_user, username, password, role, nama_user, photo_profil, photo_path)
                                      VALUES (:id, :uname, :pass, :role, :nama, :pp, :ph)");
                    $this->db->bind(':id',    $data['id_user']);
                    $this->db->bind(':uname', $data['username']);
                    $this->db->bind(':pass',  $data['password']);
                    $this->db->bind(':role',  $data['role']);
                    $this->db->bind(':nama',  $data['nama_user']);
                    $this->db->bind(':pp',    $data['photo_profil'] ?? null);
                    $this->db->bind(':ph',    $data['photo_path']   ?? null);
                    $this->db->execute();
                    $result = 1;
                    break;

                default:
                    return 0; // Jenis data tidak dikenal
            }

            // Hapus dari trs_restore jika berhasil di-restore
            if ($result > 0) {
                $this->db->query("DELETE FROM trs_restore WHERE id_restore = :id");
                $this->db->bind(':id', $id_restore);
                $this->db->execute();
            }

            return $result;

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
        $this->db->bind('data_json',  $dataJson);
        $this->db->bind('deleted_by', $deletedBy);
        return $this->db->execute();
    }
}