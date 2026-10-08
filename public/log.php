<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance()->getConnection();
$stmt = $db->query("SELECT * FROM log_aktivitas ORDER BY created_at DESC LIMIT 50");
$logs = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h2>📋 Log Aktivitas</h2>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if (empty($logs)): ?>
    <div class="empty-state">
        <div class="empty-state-icon"></div>
        <p>Belum ada aktivitas yang tercatat. Coba hapus atau edit produk!</p>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Aksi</th>
                    <th>Tabel</th>
                    <th>Record ID</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): 
                    $aksiClass = $log['aksi'] === 'DELETE' ? 'badge-danger' : 'badge-info';
                ?>
                <tr>
                    <td><?= e(date('d/m/Y H:i', strtotime($log['created_at']))) ?></td>
                    <td><span class="badge <?= $aksiClass ?>"><?= e($log['aksi']) ?></span></td>
                    <td><?= e($log['tabel']) ?></td>
                    <td>#<?= e($log['record_id']) ?></td>
                    <td><?= e($log['deskripsi']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>