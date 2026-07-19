<?php

class Login extends Controller {
    public function index()
    {
        $data['title'] = 'Login Page';
        $data['remember_username'] = isset($_COOKIE['remember_username']) ? $_COOKIE['remember_username'] : '';
        $data['remember_password'] = isset($_COOKIE['remember_password']) ? base64_decode($_COOKIE['remember_password']) : '';

        if (isset($_SESSION['id_user'])) {
            header('Location: ' . BASEURL . '/home');
            exit;
        }

        $this->view('login/index', $data);
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->model('Login_model')->getUser($username);

        // PENAMBAHAN LOGIKA USERNAME & PASSWORD SALAH (rafli)

        if ($user) {
            if (hash('sha256', $password) == $user['password']) {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nama_user'] = $user['nama_user'];
                $_SESSION['photo_profil'] = $user['photo_profil'] ?? null;

                // Logika Remember Me
                if (isset($_POST['remember'])) {
                    setcookie('id_user', $user['id_user'], time() + (86400 * 30), '/'); // 30 hari
                    setcookie('key', hash('sha256', $user['username']), time() + (86400 * 30), '/');
                    
                    // Untuk form autofill
                    setcookie('remember_username', $username, time() + (86400 * 30), '/');
                    setcookie('remember_password', base64_encode($password), time() + (86400 * 30), '/');
                } else {
                    setcookie('remember_username', '', time() - 3600, '/');
                    setcookie('remember_password', '', time() - 3600, '/');
                }

                $is_password_default = $this->model('Login_model')->isDefaultPassword($password);

                if (!$is_password_default) {
                    if ($_SESSION['role'] === 'Asisten') {
                        header('Location: ' . BASEURL . '/home');
                    } else {
                        header('Location: ' . BASEURL . '/home'); 
                    }
                } else {
                    header('Location: ' . BASEURL . '/home');
                }
                exit;

            } else {
                Flasher::setFlash('Gagal Login', 'Password yang anda masukkan salah', 'danger');
                header('Location: ' . BASEURL . '/Login');
                exit;
            }

        } else {
            Flasher::setFlash('Gagal Login', 'Username tidak ditemukan', 'danger');
            header('Location: ' . BASEURL . '/Login');
            exit;
        }
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