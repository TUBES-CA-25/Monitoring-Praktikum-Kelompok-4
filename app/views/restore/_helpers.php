<?php

/**
 * Restore Helper Functions
 * Contains helper functions for restore data display
 */

// Helper function untuk extract nama dari JSON
function getDisplayName($json_data) {
    $data = json_decode($json_data, true);
    if (!$data || !is_array($data)) return 'Unknown';
    
    // Cek berbagai kemungkinan field nama
    $name_fields = ['nama_user', 'nama_dosen', 'nama_asisten', 'nama_ruangan', 
                    'nama_matkul', 'jurusan', 'kelas', 'tahun_ajaran'];
    
    foreach ($name_fields as $field) {
        if (isset($data[$field])) {
            return htmlspecialchars($data[$field]);
        }
    }
    
    return 'Data #' . ($data['id'] ?? 'unknown');
}

// Helper function untuk get user name
function getUserNameById($id) {
    $db = new Database();
    $db->query("SELECT nama_user FROM mst_user WHERE id_user = :id");
    $db->bind('id', $id);
    $result = $db->single();
    return ($result && isset($result['nama_user'])) ? htmlspecialchars($result['nama_user']) : 'Unknown';
}

// Mapping untuk label jenis data
$jenis_labels = [
    'mst_user' => 'User',
    'mst_dosen' => 'Dosen',
    'mst_asisten' => 'Asisten',
    'mst_jurusan' => 'Jurusan',
    'mst_kelas' => 'Kelas',
    'mst_matakuliah' => 'Matakuliah',
    'mst_ruangan' => 'Ruangan/Lab',
    'mst_tahun_ajaran' => 'Tahun Ajaran',
    'trs_frekuensi' => 'Frekuensi'
];
