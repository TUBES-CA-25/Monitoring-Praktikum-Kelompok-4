<?php

class ErrorPage extends Controller {
    public function show($code = 404) {
        http_response_code($code);
        
        $messages = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            419 => 'Page Expired',
            429 => 'Too Many Requests',
            500 => 'Server Error',
            503 => 'Service Unavailable'
        ];
        
        $data['title'] = $code . ' ' . ($messages[$code] ?? 'Error');
        $data['code'] = $code;
        $data['message'] = $messages[$code] ?? 'Error';
        
        $this->view('errors/layout', $data);
    }

    public function notFound() {
        $this->show(404);
    }
}
