<?php

class Controller{
    public function __construct(){
        session_start(); 
        if (isset($_SESSION['role'])) {
            $this->id_asisten = isset($_SESSION['id_asisten']) ? $_SESSION['id_asisten'] : null;
        } else {
            $this->id_asisten = null;
        }

        $this->db = new Database();
    }
    public function view($view, $data = []){
        if(!isset($_SESSION['id_user'])){
            require_once 'app/views/login/index.php';
        }else{
            require_once 'app/views/' . $view . '.php';
        }
    }
    public function model($model){
        require_once 'app/models/' . $model . '.php';
        return new $model;
    }
    public function isLogin() {
        if (!$_SESSION['id_user']) {
            header('Location:' . BASEURL);
            exit;
        }
    }
    public function isAdmin() {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {  
            if ($_SESSION['role'] == 'Asisten') {
                header('Location:' . BASEURL);
            } else {
            }
            exit;
        }
    }
    public function isAsisten() {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Asisten') {  
            if ($_SESSION['role'] == 'Admin') {
                header('Location:' . BASEURL);
            } else {
            }
            exit;
        }
    }
    // public function isNot() {
    //     if (!($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'korlab')) {  
    //         header('Location:' . BASEURL . '/pelanggaran');
    //         exit;
    //     }
    // }
    // public function isAsistenOrKorlab() {
    //     $allowedRoles = ['asisten', 'korlab'];    
    //     if (!in_array($_SESSION['role'], $allowedRoles)) {  
    //         header('Location:' . BASEURL);
    //         exit;
    //     }
    // }
    // public function isAdminOrKorlab() {
    //     $allowedRoles = ['admin', 'korlab'];
    
    //     if (!in_array($_SESSION['role'], $allowedRoles)) {  
    //         header('Location:' . BASEURL . '/pelanggaran');
    //         exit;
    //     }
    // }
}
?>
