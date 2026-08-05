<?php
require_once 'app/core/Flasher.php';

class App {

    protected $controller = 'Home'; 
    protected $method = 'index';  
    protected $params = [];     

    public function __construct() {
        $url = $this->parseURL();

        // 1. Ambil nama Controller
        if (isset($url[0])) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        
        // 2. Ambil nama Method
        if (isset($url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // --- DEV OPS STRICT ROUTING CHECK ---
        require_once 'app/config/routes.php';
        $isRouteValid = false;
        
        // Cek apakah controller dan method ada di whitelist routes.php
        if (isset($routes[$this->controller]) && in_array($this->method, $routes[$this->controller])) {
            if (file_exists('app/controllers/' . $this->controller . '.php')) {
                require_once 'app/controllers/' . $this->controller . '.php';
                if (method_exists($this->controller, $this->method)) {
                    $isRouteValid = true;
                }
            }
        }

        // Jika rute tidak terdaftar di routes.php ATAU file/method tidak ada
        if (!$isRouteValid) {
            $this->controller = 'ErrorPage';
            $this->method = 'notFound';
            require_once 'app/controllers/ErrorPage.php';
        }

        // 3. Instansiasi Controller
        $this->controller = new $this->controller;

        // 4. Ambil parameter (id, dll)
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 5. Eksekusi
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            
            if (isset($url[0]) && is_string($url[0])) {
                $url[0] = ucfirst($url[0]);
            }

            return $url;
        }
        
        return [];
    }
}