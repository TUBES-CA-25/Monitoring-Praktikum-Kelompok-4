<?php
session_start();

class Login extends Controller {
    public function index()
    {
        $data['title'] = 'Login';

        if (isset($_SESSION['id_user'])) {
            header('Location: ' . BASEURL);
            exit;
        }

        $this->view('login/index', $data);
    }

    public function login(){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $role = $this->model("Login_model")->getRole($username);
        $nama_user = $this->model("Login_model")->getNamaUser($username);

        $id_user = $this->model('Login_model')->validateLogin($username, $password);

        if ($id_user) {
            $is_password_default = $this->model('Login_model')->isDefaultPassword($password);
            session_start();
            $_SESSION['id_user'] = $id_user;
            $_SESSION['role'] = $role['role'];
            $_SESSION['nama_user'] = $nama_user;

            if (!$is_password_default) {
                if ($_SESSION['role'] === 'Asisten') {
                    header('Location: ' . BASEURL . '/home');
                } else {
                    header('Location: ' . BASEURL . '/login');
                }
            } else {
                header('Location: ' . BASEURL . '/home');
            }
            exit();
        } else {
            header('Location: ' . BASEURL . '/login');
            exit();
        }
    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();

        header('Location: ' . BASEURL . '/login');
        exit;
    }
}
?>
