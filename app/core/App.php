<?php
require_once 'app/core/Flasher.php';

class App {

    protected $controller = 'Home'; // Default controller
    protected $method = 'index';    // Default method
    protected $params = [];         // Default params

    public function __construct() {
        $url = $this->parseURL();

        // 1. CEK CONTROLLER
        // Cek apakah ada file controller sesuai index ke-0 URL
        if (isset($url[0]) && file_exists('app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        
        // Panggil controller (Kalau URL kosong, dia tetap pakai 'Home' bawaan properti di atas)
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. CEK METHOD
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. CEK PARAMS
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // JALANKAN CONTROLLER & METHOD, SERTA KIRIMKAN PARAMS JIKA ADA
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            
            // Fix Case Sensitivity (Huruf Besar Awal)
            if (isset($url[0]) && is_string($url[0])) {
                $url[0] = ucfirst($url[0]);
            }

            return $url;
        }
        
        // PENTING: Kembalikan null atau array kosong jika tidak ada URL
        return [];
    }
}