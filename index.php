<?php
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
error_reporting(E_ALL);

// session_start();

// $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// $url = explode("/", $url);

// $folder = '/master-php-mvc/';

//    if (!isset($_SESSION['nama'])) {
//         header("Location: http://localhost/master-php-mvc/Login");
//     } else {

//         $id = $_SESSION['id'];
require_once 'app/config/config.php';

if (defined('MAINTENANCE_MODE') && MAINTENANCE_MODE === true) {
    http_response_code(503);
    require_once 'app/views/errors/503.php';
    exit;
}

// Global Error Handlers for 500 Internal Server Error
function customExceptionHandler($e) {
    if (ob_get_level()) ob_end_clean();
    http_response_code(500);
    // You can log $e->getMessage() here if needed
    require_once 'app/views/errors/500.php';
    exit;
}

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    if (error_reporting() === 0) return false;
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

function customShutdownHandler() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        if (ob_get_level()) ob_end_clean();
        http_response_code(500);
        require_once 'app/views/errors/500.php';
    }
}

set_exception_handler('customExceptionHandler');
// set_error_handler('customErrorHandler');
register_shutdown_function('customShutdownHandler');

require_once 'app/init.php';

$app = new App;
    