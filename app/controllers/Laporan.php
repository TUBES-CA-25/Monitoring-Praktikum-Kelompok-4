<?php

class Laporan extends Controller {

    public function index() {
        $this->isAdmin();
        $data['title'] = 'Rekapitulasi Kehadiran Praktikum';
        $data['ajaranOptions'] = $this->model('Frekuensi_model')->tampilAjaran();

        // Mengatur tahun aktif ke null secara default, data akan dimuat oleh AJAX
        $data['tahun_aktif'] = null; 
        // Memuat semua data laporan pada awalnya
        $data['laporan'] = $this->model('Laporan_model')->getRekapKehadiran();

        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('laporan/index', $data);
        $this->view('templates/footer');
    }

    // Metode baru untuk menangani ekspor Excel
    public function exportExcel($id_tahun = null) {
        $this->isAdmin();
        if ($id_tahun == 'null' || $id_tahun == '') {
            $id_tahun = null;
        }

        $data['tahun_aktif'] = $id_tahun;
        $data['laporan'] = $this->model('Laporan_model')->getRekapKehadiran($id_tahun);
        $this->view('laporan/export_excel_action', $data);
    }


    public function getTableByTahun($id_tahun = null) {
        if ($id_tahun == 'null' || $id_tahun == '') {
            $id_tahun = null;
        }

        $data['laporan'] = $this->model('Laporan_model')->getRekapKehadiran($id_tahun);
        
        $this->view('laporan/table_body', $data);
    }
}