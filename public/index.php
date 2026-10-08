<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Produk.php';
require_once __DIR__ . '/../config/database.php';

$produkModel = new Produk();
$db = Database::getInstance()->getConnection();

// Search & Pagination
$search = $_GET['search'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 10;

$produk = $produkModel->getAll($search, $page, $per_page);
$total = $produkModel->getTotal($search);
$total_pages = ceil($total / $per_page);

// Stats untuk dashboard
$totalProduk = $db->query("SELECT COUNT(*) as total FROM produk")->fetch()['total'];
$stokMenipis = $db->query("SELECT COUNT(*) as total FROM produk WHERE stok > 0 AND stok <= 10")->fetch()['total'];
$stokHabis = $db->query("SELECT COUNT(*) as total FROM produk WHERE stok = 0")->fetch()['total'];
$nilaiInventaris = $db->query("SELECT SUM(harga * stok) as total FROM produk")->fetch()['total'] ?? 0;

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h2> Dashboard Inventaris</h2>
    <a href="create.php" class="btn btn-primary">➕ Tambah Produk</a>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">🎸</div>
        <div class="stat-value"><?= number_format($totalProduk) ?></div>
        <div class="stat-label">Total Produk</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⚠️</div>
        <div class="stat-value"><?= number_format($stokMenipis) ?></div>
        <div class="stat-label">Stok Menipis</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🚫</div>
        <div class="stat-value"><?= number_format($stokHabis) ?></div>
        <div class="stat-label">Stok Habis</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-value"><?= formatHarga($nilaiInventaris) ?></div>
        <div class="stat-label">Nilai Inventaris</div>
    </div>
</div>

<!-- Search Form -->
<form method="GET" class="search-form">
    <input type="text" name="search" value="<?= e($search) ?>" placeholder="🔍 Cari produk atau kategori...">
    <button type="submit" class="btn btn-primary">Cari</button>
    <?php if ($search): ?>
        <a href="index.php" class="btn btn-secondary">Reset</a>
    <?php endif; ?>
</form>

<?php if (empty($produk)): ?>
    <div class="empty-state">
        <div class="empty-state-icon">🎵</div>
        <p>Tidak ada produk ditemukan. Yuk tambah produk baru!</p>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Supplier</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $p): 
                    $stokClass = $p['stok'] > 10 ? 'badge-success' : ($p['stok'] > 0 ? 'badge-warning' : 'badge-danger');
                    $stokLabel = $p['stok'] > 10 ? 'Aman' : ($p['stok'] > 0 ? 'Menipis' : 'Habis');
                ?>
                <tr>
                    <td>#<?= e($p['id']) ?></td>
                    <td><strong><?= e($p['nama_produk']) ?></strong></td>
                    <td><?= e($p['nama_kategori'] ?? '-') ?></td>
                    <td><?= e($p['nama_supplier'] ?? '-') ?></td>
                    <td><?= formatHarga($p['harga']) ?></td>
                    <td>
                        <span class="badge <?= $stokClass ?>">
                            <?= e($p['stok']) ?> - <?= $stokLabel ?>
                        </span>
                    </td>
                    <td class="actions">
                        <a href="update.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                        <a href="delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger">🗑️ Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" 
               class="page-link <?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>