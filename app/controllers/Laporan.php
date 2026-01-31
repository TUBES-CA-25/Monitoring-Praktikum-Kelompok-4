<?php

class Laporan extends Controller {

    public function index() {
        $this->isAdmin();
        $data['title'] = 'Rekapitulasi Kehadiran Praktikum';
        $data['ajaranOptions'] = $this->model('Frekuensi_model')->tampilAjaran();

        $id_tahun = isset($_POST['id_tahun_filter']) ? $_POST['id_tahun_filter'] : null;
        $data['tahun_aktif'] = $id_tahun;
        $data['laporan'] = $this->model('Laporan_model')->getRekapKehadiran($id_tahun);

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


    public function getTableByTahun($id_tahun = null) {
        if ($id_tahun == 'null' || $id_tahun == '') {
            $id_tahun = null;
        }

        $data['laporan'] = $this->model('Laporan_model')->getRekapKehadiran($id_tahun);
        
        $this->view('laporan/table_body', $data);
    }
}