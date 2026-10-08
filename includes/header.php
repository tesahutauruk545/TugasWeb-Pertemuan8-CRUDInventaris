<?php require_once __DIR__ . '/../config/config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(APP_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>../assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1 class="logo">
                <span class="logo-icon">🎵</span>
                <?= e(APP_NAME) ?>
            </h1>
            <button class="menu-toggle" aria-label="Menu">☰</button>
            <ul class="nav-links">
                <li><a href="<?= BASE_URL ?>index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>📦 Produk</a></li>
                <li><a href="<?= BASE_URL ?>create.php" <?= basename($_SERVER['PHP_SELF']) == 'create.php' ? 'class="active"' : '' ?>>➕ Tambah</a></li>
                <li><a href="<?= BASE_URL ?>log.php" <?= basename($_SERVER['PHP_SELF']) == 'log.php' ? 'class="active"' : '' ?>>📋 Log</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container main-content">
        <?php
        $flash = getFlashMessage();
        if ($flash):
            $icon = $flash['type'] === 'success' ? '✅' : ($flash['type'] === 'error' ? '❌' : '️');
        ?>
        <div class="alert alert-<?= e($flash['type']) ?>">
            <span style="font-size: 1.2rem;"><?= $icon ?></span>
            <span><?= e($flash['message']) ?></span>
        </div>
        <?php endif; ?>