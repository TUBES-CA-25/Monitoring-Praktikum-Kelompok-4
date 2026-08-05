<?php
/**
 * =========================================================================
 * DEVOPS STRICT ROUTING CONFIGURATION
 * =========================================================================
 * File ini berisi daftar *whitelist* seluruh Controller dan Method yang 
 * secara eksplisit diizinkan untuk diakses melalui URL.
 * 
 * Tujuan: Mencegah serangan pemanggilan method internal secara sembarangan 
 * (Misal hacker mencoba mengakses fungsi yang tidak seharusnya diekspos).
 * Jika URL tidak ada di daftar ini, otomatis akan dialihkan ke 404 Not Found.
 * =========================================================================
 */

$routes = [
    'Home'       => ['index', 'calendarAsisten'],
    'Login'      => ['index', 'login', 'logout'],
    'User'       => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus', 'profil', 'updateProfil'],
    'Asisten'    => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'ubah', 'hapus', 'importExcel', 'downloadTemplate'],
    'Dosen'      => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus'],
    'Jurusan'    => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus'],
    'Kelas'      => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus'],
    'Ruangan'    => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus'],
    'Ajaran'     => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus'],
    'Matakuliah' => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus', 'getMatakuliahByJurusan', 'importExcel', 'downloadTemplate'],
    'Frekuensi'  => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus', 'detail', 'getFrekuensiCount', 'getMatakuliahOptions', 'filterAjax', 'importExcel', 'downloadTemplate'],
    'Mentoring'  => ['index', 'modalTambah', 'tambah', 'ubahModal', 'prosesUbah', 'hapus', 'prosesHapus', 'export_pdf', 'importExcel', 'downloadTemplate'],
    'Laporan'    => ['index', 'exportExcel', 'getTableByTahun'],
    'Restore'    => ['index', 'kembalikan', 'hapusPermanen'],
    'ErrorPage'  => ['show', 'notFound']
];
