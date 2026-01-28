<?php

class Laporan extends Controller {

public function index() {
    $this->isAdmin();
        $data['title'] = 'Rekapitulasi Kehadiran Praktikum';
        $data['ajaranOptions'] = $this->model('Frekuensi_model')->tampilAjaran();

        $id_tahun = isset($_POST['id_tahun_filter']) ? $_POST['id_tahun_filter'] : null;
        $data['tahun_aktif'] = $id_tahun;
        $data['laporan'] = $this->model('Laporan_model')->getRekapKehadiran($id_tahun);

        // Cek apakah user menekan tombol Export Excel
        if (isset($_POST['export_excel'])) {
            $this->view('laporan/export_excel_action', $data);
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('laporan/index', $data);
        $this->view('templates/footer');
    }
}