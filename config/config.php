<?php
// Konstanta aplikasi
define('DB_HOST', 'localhost');
define('DB_NAME', 'inventaris_db');
define('DB_USER', 'root');
define('DB_PASS', '');

define('APP_NAME', 'Inventaris Alat Musik');
define('BASE_URL', 'http://localhost/inventaris-musik/public/');

// Session untuk flash message
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}