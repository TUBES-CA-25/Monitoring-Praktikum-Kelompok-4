<?php

class Flasher {
    public static function setFlash($pesan, $aksi, $tipe) {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'aksi' => $aksi,
            'tipe' => $tipe
        ];
    }
    
    public static function flash() {
        if (isset($_SESSION['flash'])) {
            echo '<div id="flash-message" class="alert alert-' . $_SESSION['flash']['tipe'] . ' alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 300px;">
                    <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>';
            unset($_SESSION['flash']); 
            echo '<script>
                setTimeout(function() {
                    let flash = document.getElementById("flash-message");
                    if (flash) flash.remove();
                }, 5000);
            </script>';
        }
    }

    public static function flashLogin() {
        if (isset($_SESSION['flash'])) {
            $tipe = $_SESSION['flash']['tipe'] == 'danger' ? 'danger' : 'success';
            echo '<div id="flash-message" class="alert-' . $tipe . '-custom mb-3" role="alert" style="position: relative;">
                    <strong>' . $_SESSION['flash']['pesan'] . '</strong> ' . $_SESSION['flash']['aksi'] . '
                   </div>';
            unset($_SESSION['flash']); 
        }
    }
}