<?php

class Login extends Controller {
    public function index()
    {
        $data['title'] = 'Login Page';

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

        if ($user) {
            if (hash('sha256', $password) == $user['password']) {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nama_user'] = $user['nama_user'];

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
        header('Location: ' . BASEURL . '/login');
        exit;
    }
}