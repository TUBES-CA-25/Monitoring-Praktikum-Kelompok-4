<?php

class Asisten extends Controller {
    
    public function index(){
        $data['title'] = 'Data Asisten';
        $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
    
        if ($role == 'Asisten') {
            $data['asisten'] = $this->model('Asisten_model')->getAsistenDetails($id_user);
            $data['user'] = $this->model('User_model')->getUserDetails($id_user);
        } else {
            $data['asisten'] = $this->model('Asisten_model')->tampil();
        }
    
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('asisten/index', $data);
        $this->view('templates/footer');
    }        

    public function modalTambah(){
        $this->isAdmin();
        $data['userOptions'] = $this->model('Asisten_model')->tampilUser();
        $this->view('asisten/tambah_asisten', $data);
    }

    // public function tambah(){
    //     $this->isAdmin();
    //     $data = $_POST;

    //     $namaBersih = preg_replace('/[^A-Za-z0-9]/', '_', $data['nama_asisten']);
        
    //     $namaFileCustom = $namaBersih; 

    //     $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', $namaFileCustom . '_profil');

    //     if ($uploadProfil['status'] == false && $uploadProfil['error_code'] != 4) {
    //         Flasher::setFlash('Gagal upload profil: ' . $uploadProfil['pesan'], '', 'danger');
    //         header('Location: '.BASEURL. '/asisten');
    //         exit;
    //     }
    //     $data['photo_profil'] = $uploadProfil['nama_file']; 

    //     $uploadSignature = $this->prosesUpload('photo_path', 'public/img/signature/', $namaFileCustom . '_ttd');

    //     if ($uploadSignature['status'] == false && $uploadSignature['error_code'] != 4) {
    //         Flasher::setFlash('Gagal upload TTD: ' . $uploadSignature['pesan'], '', 'danger');
    //         header('Location: '.BASEURL. '/asisten');
    //         exit;
    //     }
    //     $data['photo_path'] = $uploadSignature['nama_file'];

    //     if($this->model('Asisten_model')->tambah($data) > 0){
    //         Flasher::setFlash('berhasil ditambahkan', '', 'success');
    //     } else {
    //         Flasher::setFlash('tidak berhasil ditambahkan', '', 'danger');
    //     }
    //     header('Location: '.BASEURL. '/asisten');
    //     exit;
    // }

    public function tambah()
    {
        $this->isAdmin();
        $data = $_POST;
        
        // 1. Validasi Field Kosong
        $requiredFields = ['username', 'stambuk', 'nama_asisten', 'angkatan', 'status', 'jenis_kelamin'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $_SESSION['old'] = $_POST;
                Flasher::setFlash('Semua field wajib diisi!', 'Gagal', 'danger');
                header('Location: ' . BASEURL . '/asisten');
                exit;
            }
        }
        
        // 2. Cek apakah Username atau Stambuk sudah ada (Pencegahan awal)
        if ($this->model('User_model')->getUserByUsername($data['username'])) {
            $_SESSION['old'] = $_POST;
            Flasher::setFlash('Username/Email sudah terdaftar!', 'Gagal', 'danger');
            header('Location: ' . BASEURL . '/asisten');
            exit;
        }

        if ($this->model('Asisten_model')->cekStambuk($data['stambuk'])) {
            $_SESSION['old'] = $_POST;
            Flasher::setFlash('Stambuk ini sudah ada di sistem!', 'Gagal', 'danger');
            header('Location: ' . BASEURL . '/asisten');
            exit;
        }

        // 3. Persiapan Password & Upload File
        $passwordHash = $this->validateAkun($data['username'], $data['password']);
        $namaFileCustom = preg_replace('/[^A-Za-z0-9]/', '_', $data['nama_asisten']);
        
        $data['photo_profil'] = null;
        if (!empty($_FILES['photo_profil']['name'])) {
            $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', $namaFileCustom . '_profil');
            if ($uploadProfil['status']) $data['photo_profil'] = $uploadProfil['nama_file'];
        }

        $data['photo_path'] = null;
        if (!empty($_FILES['photo_path']['name'])) {
            $uploadSignature = $this->prosesUpload('photo_path', 'public/img/signature/', $namaFileCustom . '_ttd');
            if ($uploadSignature['status']) $data['photo_path'] = $uploadSignature['nama_file'];
        }

        // 4. Proses Eksekusi Database
        try {
            // Tambah User Terlebih Dahulu
            $dataUser = [
                'nama_user' => $data['nama_asisten'], 
                'username'  => $data['username'],
                'password'  => $passwordHash,
                'role'      => 'Asisten'
            ];

            $id_user = $this->model('User_model')->tambah($dataUser);

            if ($id_user > 0) {
                // Ambil ID User yang baru dibuat (untuk Foreign Key)
                $newUser = $this->model('User_model')->getUserByUsername($data['username']);
                
                // Pembersihan array untuk dikirim ke model asisten
                $dataFinal = [
                    'stambuk'       => $data['stambuk'],
                    'nama_asisten'  => $data['nama_asisten'],
                    'angkatan'      => $data['angkatan'],
                    'status'        => $data['status'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'id_user'       => $newUser['id_user'],
                    'photo_profil'  => $data['photo_profil'],
                    'photo_path'    => $data['photo_path']
                ];

                if ($this->model('Asisten_model')->tambah($dataFinal) > 0) {
                    $_SESSION['old'] = [];
                    Flasher::setFlash('Data Asisten Berhasil Ditambahkan', '', 'success');
                } else {
                    // Jika asisten gagal, hapus usernya agar tidak jadi data sampah
                    $this->model('User_model')->prosesHapus($newUser['id_user']);
                    Flasher::setFlash('Gagal menyimpan data asisten.', '', 'danger');
                }
            } else {
                Flasher::setFlash('Gagal membuat akun user.', '', 'danger');
            }

        } catch (PDOException $e) {
            // Tangani jika terjadi Duplicate Entry (Kode 1062) saat Double Submit
            if ($e->errorInfo[1] == 1062) {
                Flasher::setFlash('Data sudah ada atau terkirim ganda. Silakan cek daftar asisten.', 'Info', 'warning');
            } else {
                Flasher::setFlash('Error Database: ' . $e->getMessage(), 'Gagal', 'danger');
            }
        }

        header('Location: ' . BASEURL . '/asisten');
        exit;
    }

    public function ubahModal(){
        $this->isAdmin();
        $id = $_POST['id'];
        $data['userOptions'] = $this->model('Asisten_model')->tampilUser();
        $data['ubahdata'] = $this->model('Asisten_model')->ubah($id);
        $this->view('asisten/ubah_asisten', $data);
    }

    public function prosesUbah() {
        $this->isAdmin();
        $data = $_POST;
        $id_asisten = $data['id_asisten'];
        $id_user = $data['id_user'];

        // 1. Ambil data lama untuk pengecekan
        $asistenLama = $this->model('Asisten_model')->detailAsisten($id_asisten);
        $userLama = $this->model('User_model')->getUserById($id_user);

        // 2. VALIDASI EMAIL (Penting agar tidak Duplicate Entry)
        // Jika email yang diinput BERBEDA dengan email lama, baru kita cek ketersediaannya
        if ($data['username'] !== $userLama['username']) {
            $cekEmail = $this->model('User_model')->getUserByUsernameExceptMe($data['username'], $id_user);
            if ($cekEmail) {
                Flasher::setFlash('Gagal', 'Email sudah dipakai orang lain!', 'danger');
                header('Location: ' . BASEURL . '/asisten');
                exit;
            }
        }

        // 3. Sanitasi Nama File
        $namaBersih = preg_replace('/[^A-Za-z0-9]/', '_', $data['nama_asisten']); 
        $uploadErrors = [];

        // 4. Logika Password SHA-256
        if (empty($data['password'])) {
            $data['password'] = $userLama['password']; // Tetap pakai hash lama
        } else {
            $data['password'] = hash('sha256', $data['password']); // Hash baru
        }

        // 5. Handle Foto Profil
        if ($_FILES['photo_profil']['error'] === UPLOAD_ERR_NO_FILE) {
            $data['photo_profil'] = $asistenLama['photo_profil'];
        } else {
            $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', $namaBersih . '_profil');
            $data['photo_profil'] = $uploadProfil['status'] ? $uploadProfil['nama_file'] : $asistenLama['photo_profil'];
            if (!$uploadProfil['status']) $uploadErrors[] = $uploadProfil['pesan'];
        }

        // 6. Handle Foto TTD
        if ($_FILES['photo_path']['error'] === UPLOAD_ERR_NO_FILE) {
            $data['photo_path'] = $asistenLama['photo_path'];
        } else {
            $uploadTTD = $this->prosesUpload('photo_path', 'public/img/signature/', $namaBersih . '_ttd');
            $data['photo_path'] = $uploadTTD['status'] ? $uploadTTD['nama_file'] : $asistenLama['photo_path'];
            if (!$uploadTTD['status']) $uploadErrors[] = $uploadTTD['pesan'];
        }

        // 7. Eksekusi ke Database
        $updateUser = $this->model('User_model')->ubahDataUser($data);
        $updateAsisten = $this->model('Asisten_model')->ubahData($data);

        if ($updateUser >= 0 && $updateAsisten >= 0) {
            Flasher::setFlash('Berhasil', 'diperbarui', 'success');
        } else {
            Flasher::setFlash('Gagal', 'diperbarui', 'danger');
        }

        header('Location: ' . BASEURL . '/asisten');
        exit;
    }

    public function ubah($id) {
        $data['title'] = 'Ubah Data Asisten'; // Agar <title> di header terisi
        
        // Mengambil data lengkap (Asisten + User) dari model
        $data['ubahdata'] = $this->model('Asisten_model')->getUbahData($id);

        // Jika data tidak ditemukan, kembalikan ke index
        if (!$data['ubahdata']) {
            Flasher::setFlash('Data', 'tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/asisten');
            exit;
        }

        // Kirim $data ke setiap view agar tidak 'Undefined Variable'
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('asisten/ubah_asisten', $data);
        $this->view('templates/footer');
    }

    public function hapus($id){
        $this->isAdmin();
        if($this->model('Asisten_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/asisten');
        exit;
    }

    private function validateAkun($username, $password)
    {
        $username = trim(strtolower($username));

        if ($username === '') {
            throw new Exception('Email wajib diisi!');
        }

        $allowedDomains = [
            '@umi.ac.id',
            '@student.umi.ac.id',
            '@gmail.com'
        ];

        $valid = false;
        foreach ($allowedDomains as $domain) {
            if (substr($username, -strlen($domain)) === $domain) {
                $valid = true;
                break;
            }
        }

        // email khusus
        if ($username === 'iclabs@umi.ac.id') {
            $valid = true;
        }

        if (!$valid) {
            throw new Exception(
                'Email tidak valid! Gunakan domain UMI / Student / Gmail'
            );
        }

        $finalPass = trim($password);
        if ($finalPass === '') {
            $finalPass = 'iclabs-umi';
        }

        return hash('sha256', $finalPass);
    }
}