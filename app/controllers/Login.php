<?php

class Login extends Controller {
    public function index()
    {
        $data['title'] = 'Login Page';
        
        // Prioritaskan session old_username jika baru saja gagal login
        if (isset($_SESSION['old_username'])) {
            $data['remember_username'] = $_SESSION['old_username'];
            unset($_SESSION['old_username']); // Hapus setelah dibaca
        } else {
            $data['remember_username'] = isset($_COOKIE['remember_username']) ? $_COOKIE['remember_username'] : '';
        }

        if (isset($_SESSION['id_user'])) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $this->view('login/index', $data);
    }

    public function login() {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Simpan username sementara agar tidak hilang jika login gagal
        $_SESSION['old_username'] = $username;

        $user = $this->model('Login_model')->getUser($username);

        // PENAMBAHAN LOGIKA USERNAME & PASSWORD SALAH (rafli)

        // Cek Session Brute Force
        if (isset($_SESSION['locked_until']) && time() < $_SESSION['locked_until']) {
            $sisaWaktu = ceil(($_SESSION['locked_until'] - time()) / 60);
            Flasher::setFlash('Terkunci', 'Terlalu banyak percobaan. Coba lagi dalam ' . $sisaWaktu . ' menit', 'danger');
            header('Location: ' . BASEURL . '/Login');
            exit;
        }

        if ($user) {
            $isPasswordValid = false;
            
            if (password_verify($password, $user['password'])) {
                $isPasswordValid = true;
            } else if (hash('sha256', $password) === $user['password']) {
                $isPasswordValid = true;
                // Upgrade seamless
                $this->model('Login_model')->updatePassword($user['id_user'], password_hash($password, PASSWORD_DEFAULT));
            }
            
            // Perlakuan khusus untuk password default yang belum dihash di database dummy
            else if ($password === $user['password']) {
                $isPasswordValid = true;
                $this->model('Login_model')->updatePassword($user['id_user'], password_hash($password, PASSWORD_DEFAULT));
            }

            if ($isPasswordValid) {
                // Bersihkan session sementara
                unset($_SESSION['old_username']);
                unset($_SESSION['login_attempts']);
                unset($_SESSION['locked_until']);

                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nama_user'] = $user['nama_user'];
                $_SESSION['photo_profil'] = $user['photo_profil'] ?? null;

                // Logika Remember Me
                if (isset($_POST['remember'])) {
                    setcookie('id_user', $user['id_user'], time() + (86400 * 30), '/'); // 30 hari
                    setcookie('key', hash('sha256', $user['username'] . $password), time() + (86400 * 30), '/');
                    
                    // Untuk form autofill username saja
                    setcookie('remember_username', $username, time() + (86400 * 30), '/');
                } else {
                    setcookie('remember_username', '', time() - 3600, '/');
                }

                header('Location: ' . BASEURL . '/home');
                exit;

            } else {
                $this->handleFailedLogin();
            }

        } else {
            $this->handleFailedLogin(true);
        }
    }

    private function handleFailedLogin($isUsernameError = false) {
        $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
        
        if ($_SESSION['login_attempts'] >= 5) {
            $_SESSION['locked_until'] = time() + (15 * 60); // 15 menit
            Flasher::setFlash('Terkunci', 'Terlalu banyak percobaan gagal. Akun dikunci 15 menit.', 'danger');
        } else {
            if ($isUsernameError) {
                Flasher::setFlash('Gagal Login', 'Username tidak ditemukan', 'danger');
            } else {
                Flasher::setFlash('Gagal Login', 'Password yang anda masukkan salah', 'danger');
            }
        }

        header('Location: ' . BASEURL . '/Login');
        exit;
    }

    public function logout(){
        session_unset();
        session_destroy();

        // Hapus cookie Remember Me
        setcookie('id_user', '', time() - 3600, '/');
        setcookie('key', '', time() - 3600, '/');

        header('Location: ' . BASEURL . '/login');
        exit;
    }
}