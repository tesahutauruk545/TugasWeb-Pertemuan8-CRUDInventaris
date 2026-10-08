<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Produk.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Supplier.php';

$produkModel = new Produk();
$kategoriModel = new Kategori();
$supplierModel = new Supplier();

$id = intval($_GET['id'] ?? 0);
$produk = $produkModel->getById($id);

if (!$produk) {
    setFlashMessage('error', 'Produk tidak ditemukan!');
    header('Location: index.php');
    exit;
}

$kategori = $kategoriModel->getAll();
$supplier = $supplierModel->getAll();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama_produk' => trim($_POST['nama_produk'] ?? ''),
        'kategori_id' => intval($_POST['kategori_id'] ?? 0),
        'supplier_id' => intval($_POST['supplier_id'] ?? 0),
        'harga' => floatval(str_replace(',', '', $_POST['harga'] ?? 0)),
        'stok' => intval($_POST['stok'] ?? 0),
        'deskripsi' => trim($_POST['deskripsi'] ?? '')
    ];

    if (empty($data['nama_produk']) || $data['harga'] <= 0) {
        $error = 'Nama produk dan harga harus diisi dengan benar!';
    } else {
        if ($produkModel->update($id, $data)) {
            logAktivitas('UPDATE', 'produk', $id, "Mengupdate produk: {$data['nama_produk']}");
            setFlashMessage('success', 'Produk berhasil diupdate! ✨');
            header('Location: index.php');
            exit;
        } else {
            $error = 'Gagal mengupdate produk!';
        }
    }
}

$formData = $_POST ?: $produk;

include __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
    <h2>✏️ Edit Produk</h2>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-error">❌ <?= e($error) ?></div>
<?php endif; ?>

<form method="POST" class="form">
    <div class="form-group">
        <label for="nama_produk">🎸 Nama Produk *</label>
        <input type="text" id="nama_produk" name="nama_produk" 
               value="<?= e($formData['nama_produk']) ?>" required>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="kategori_id">📂 Kategori *</label>
            <select id="kategori_id" name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id'] ?>" 
                        <?= $formData['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                        <?= e($k['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="supplier_id">🏭 Supplier *</label>
            <select id="supplier_id" name="supplier_id" required>
                <option value="">-- Pilih Supplier --</option>
                <?php foreach ($supplier as $s): ?>
                    <option value="<?= $s['id'] ?>"
                        <?= $formData['supplier_id'] == $s['id'] ? 'selected' : '' ?>>
                        <?= e($s['nama_supplier']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="harga">💰 Harga (Rp) *</label>
            <input type="text" id="harga" name="harga" 
                   value="<?= e($formData['harga']) ?>" required>
        </div>

        <div class="form-group">
            <label for="stok">📦 Stok *</label>
            <input type="number" id="stok" name="stok" 
                   value="<?= e($formData['stok']) ?>" min="0" required>
        </div>
    </div>

    <div class="form-group">
        <label for="deskripsi">📝 Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="4"><?= e($formData['deskripsi']) ?></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"> Update Produk</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?php include __DIR__ . '/../includes/footer.php'; ?>