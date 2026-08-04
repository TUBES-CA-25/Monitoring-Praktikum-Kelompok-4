<?php

/**
 * Mencegah XSS (Cross-Site Scripting)
 * Membungkus fungsi htmlspecialchars dengan aman.
 * 
 * @param string|null $string Teks yang ingin di-escape
 * @return string Teks yang sudah aman untuk dirender ke HTML
 */
function e($string) {
    if (is_null($string)) {
        return '';
    }
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
