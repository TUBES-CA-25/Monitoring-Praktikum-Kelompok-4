<?php

class User extends Controller {
    
    public function index() {
        $this->isAdmin();
        $data['title'] = 'Data User';
        $data['user'] = $this->model('User_model')->tampil();
        
        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');
        $this->view('user/index', $data);
        $this->view('templates/footer');
    }
    
    public function modalTambah(){
        $this->isAdmin();
        $this->view('user/tambah_user');
    }

    public function tambah() {
        $this->isAdmin();
        $data = $_POST;
        
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if ($this->model('User_model')->tambah($data) > 0) {
            Flasher::setFlash(' berhasil ditambahkan', '', 'success');
        } else {
            Flasher::setFlash(' tidak berhasil ditambahkan', '', 'danger');
        }
        
        header('Location: ' . BASEURL . '/user');
        exit;
    }

    public function ubahModal(){
        $id = $_POST['id'];
        $data['ubahdata'] = $this->model('User_model')->ubah($id);
        $asistenData = $this->model('Asisten_model')->cariDataAsistenByUserId($id);
        $data['foto_asisten'] = $asistenData; 
        $this->view('user/ubah_user', $data);
    }
    
    public function prosesUbah() {
        $data = $_POST;
        $id_user = $data['id_user'];
        
        $userLama = $this->model('User_model')->getUserById($id_user);
        $asistenLama = $this->model('Asisten_model')->getByUserId($id_user); 

        // 1. Password
        if (empty($data['password'])) {
            // Jika input kosong, ambil password lama (sudah dalam bentuk hash)
            $data['password'] = $userLama['password'];
        } else {
            // Jika diisi, gunakan bcrypt
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // 2. Upload Foto Profil (hanya ganti jika ada file baru yang diupload)
        $uploadProfil = $this->prosesUpload('photo_profil', 'public/img/uploads/', 'profil_' . $id_user);
        if ($uploadProfil['status'] === true && isset($uploadProfil['no_upload']) && !$uploadProfil['no_upload'] && !empty($uploadProfil['nama_file'])) {
            // File baru berhasil diupload → pakai file baru
            $data['photo_profil'] = $uploadProfil['nama_file'];
        } else {
            // Tidak ada upload baru → pertahankan file lama
            $data['photo_profil'] = $asistenLama ? ($asistenLama['photo_profil'] ?? null) : ($userLama['photo_profil'] ?? null);
        }

        // 3. Upload TTD (hanya ganti jika ada file baru yang diupload)
        $uploadTTD = $this->prosesUpload('photo_path', 'public/img/signature/', 'ttd_' . $id_user);
        if ($uploadTTD['status'] === true && isset($uploadTTD['no_upload']) && !$uploadTTD['no_upload'] && !empty($uploadTTD['nama_file'])) {
            // File baru berhasil diupload → pakai file baru
            $data['photo_path'] = $uploadTTD['nama_file'];
        } else {
            // Tidak ada upload baru → pertahankan file lama
            $data['photo_path'] = $asistenLama ? ($asistenLama['photo_path'] ?? null) : ($userLama['photo_path'] ?? null);
        }

        // 4. Update Database (Tabel User)
        $updateUser = $this->model('User_model')->ubahDataUser($data);
        
        // 5. Update Database (Tabel Asisten - Khusus Foto & TTD) jika user adalah asisten
        $updateAsisten = 0;
        if ($asistenLama) {
            $updateAsisten = $this->model('Asisten_model')->updateFilesByUserId(
                $id_user, 
                $data['photo_profil'], 
                $data['photo_path']
            );
        }

        if ($updateUser >= 0 && $updateAsisten >= 0) {
            // Perbarui session agar foto profil langsung berubah di sidebar
            if ($id_user == $_SESSION['id_user']) {
                $_SESSION['photo_profil'] = $data['photo_profil'];
            }
            Flasher::setFlash('Berhasil', 'diperbarui', 'success');
        } else {
            Flasher::setFlash('Gagal', 'memperbarui data', 'danger');
        }

        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Asisten') {
            header('Location: ' . BASEURL . '/asisten');
        } else {
            header('Location: ' . BASEURL . '/user');
        }
        exit;
    }

    public function hapus($id){
        $this->isAdmin();
        if($this->model('User_model')->prosesHapus($id)){
            Flasher::setFlash(' berhasil dihapus', '', 'success');
        }else{
            Flasher::setFlash(' tidak berhasil dihapus', '', 'danger');
        }
        header('Location: '.BASEURL. '/user');
        exit;
    }

    public function profil() {
        if (!isset($_SESSION['id_user'])) {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        $id_user = $_SESSION['id_user'];
        // Ambil data user dari model
        $data['user'] = $this->model('User_model')->getUserById($id_user);
        $data['title'] = 'Profil Saya';

        // Jika data tidak ditemukan di database, gunakan data session agar tidak error
        if (!$data['user']) {
            $data['user'] = [
                'id_user' => $_SESSION['id_user'],
                'username' => $_SESSION['username'],
                'nama_user' => $_SESSION['nama_user'],
                'role' => $_SESSION['role']
            ];
        }

        $this->view('templates/header', $data);
        $this->view('templates/topbar');
        $this->view('templates/sidebar');

        if ($_SESSION['role'] == 'Admin') {
            $this->view('user/profil', $data); 
        } else {
            // Jika asisten, arahkan ke halaman profil asisten yang sesuai
            header('Location: ' . BASEURL . '/asisten'); 
            exit;
        }

        $this->view('templates/footer');
    }

    public function updateProfil() {
        $id_user = $_POST['id_user'];
        $passwordBaru = $_POST['password'];
        
        // Ambil data lama agar properti yang tidak diubah tetap aman
        $userLama = $this->model('User_model')->getUserById($id_user);

        // Jika password diisi, hash dengan bcrypt. Jika kosong, pertahankan password lama.
        $password = !empty($passwordBaru) ? password_hash($passwordBaru, PASSWORD_DEFAULT) : $userLama['password'];

        $dataUpdate = [
            'id_user'   => $id_user,
            'username'  => $_POST['username'],
            'nama_user' => $_POST['nama_user'],
            'password'  => $password,
            'role'      => $userLama['role']
        ];

        if ($this->model('User_model')->ubahDataUserLengkap($dataUpdate) >= 0) {
            // Perbarui session agar langsung terlihat perubahannya
            $_SESSION['nama_user'] = $dataUpdate['nama_user'];
            $_SESSION['username'] = $dataUpdate['username'];
            
            if (!empty($passwordBaru)) {
                Flasher::setFlash('Berhasil', 'Profil dan Password telah diperbarui', 'success');
            } else {
                Flasher::setFlash('Berhasil', 'Profil Admin telah diperbarui', 'success');
            }
        } else {
            Flasher::setFlash('Gagal', 'Gagal memperbarui profil', 'danger');
        }

        header('Location: ' . BASEURL . '/user/profil');
        exit;
    }



}