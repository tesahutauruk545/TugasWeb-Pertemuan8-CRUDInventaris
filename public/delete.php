<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Produk.php';

$produkModel = new Produk();

$id = intval($_GET['id'] ?? 0);
$produk = $produkModel->getById($id);

if (!$produk) {
    setFlashMessage('error', 'Produk tidak ditemukan!');
    header('Location: index.php');
    exit;
}

if ($produkModel->delete($id)) {
    setFlashMessage('success', "Produk '{$produk['nama_produk']}' berhasil dihapus! 🗑️");
} else {
    setFlashMessage('error', 'Gagal menghapus produk!');
}

header('Location: index.php');
exit;