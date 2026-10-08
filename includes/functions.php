<?php
require_once __DIR__ . '/../config/database.php';

// Flash message functions
function setFlashMessage($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type, // 'success', 'error', 'warning'
        'message' => $message
    ];
}

function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

// Sanitize output
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// Format harga
function formatHarga($harga) {
    return 'Rp ' . number_format($harga, 0, ',', '.');
}

// Log aktivitas (Bonus)
function logAktivitas($aksi, $tabel, $record_id, $deskripsi) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("INSERT INTO log_aktivitas (aksi, tabel, record_id, deskripsi, user_agent) 
                          VALUES (:aksi, :tabel, :record_id, :deskripsi, :user_agent)");
    $stmt->execute([
        ':aksi' => $aksi,
        ':tabel' => $tabel,
        ':record_id' => $record_id,
        ':deskripsi' => $deskripsi,
        ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
    ]);
}