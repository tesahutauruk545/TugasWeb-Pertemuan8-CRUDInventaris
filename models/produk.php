<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

class Produk {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Get semua produk dengan JOIN (Requirement #4)
    public function getAll($search = '', $page = 1, $per_page = 10) {
        $offset = ($page - 1) * $per_page;
        
        $sql = "SELECT p.*, k.nama_kategori, s.nama_supplier 
                FROM produk p
                LEFT JOIN kategori k ON p.kategori_id = k.id
                LEFT JOIN supplier s ON p.supplier_id = s.id";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " WHERE p.nama_produk LIKE :search OR k.nama_kategori LIKE :search2";
            $params[':search'] = "%{$search}%";
            $params[':search2'] = "%{$search}%";
        }
        
        $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Count total produk untuk pagination
    public function getTotal($search = '') {
        $sql = "SELECT COUNT(*) as total FROM produk p
                LEFT JOIN kategori k ON p.kategori_id = k.id
                LEFT JOIN supplier s ON p.supplier_id = s.id";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " WHERE p.nama_produk LIKE :search OR k.nama_kategori LIKE :search2";
            $params[':search'] = "%{$search}%";
            $params[':search2'] = "%{$search}%";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()['total'];
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT p.*, k.nama_kategori, s.nama_supplier 
                                    FROM produk p
                                    LEFT JOIN kategori k ON p.kategori_id = k.id
                                    LEFT JOIN supplier s ON p.supplier_id = s.id
                                    WHERE p.id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Create produk (Requirement #7 - prepared statements)
    public function create($data) {
        $sql = "INSERT INTO produk (nama_produk, kategori_id, supplier_id, harga, stok, deskripsi) 
                VALUES (:nama_produk, :kategori_id, :supplier_id, :harga, :stok, :deskripsi)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nama_produk' => $data['nama_produk'],
            ':kategori_id' => $data['kategori_id'],
            ':supplier_id' => $data['supplier_id'],
            ':harga' => $data['harga'],
            ':stok' => $data['stok'],
            ':deskripsi' => $data['deskripsi'] ?? null
        ]);
    }

    // Update produk
    public function update($id, $data) {
        $sql = "UPDATE produk 
                SET nama_produk = :nama_produk, 
                    kategori_id = :kategori_id, 
                    supplier_id = :supplier_id, 
                    harga = :harga, 
                    stok = :stok, 
                    deskripsi = :deskripsi 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nama_produk' => $data['nama_produk'],
            ':kategori_id' => $data['kategori_id'],
            ':supplier_id' => $data['supplier_id'],
            ':harga' => $data['harga'],
            ':stok' => $data['stok'],
            ':deskripsi' => $data['deskripsi'] ?? null
        ]);
    }

    // Delete dengan transaction (Bonus)
    public function delete($id) {
        try {
            $this->db->beginTransaction();
            
            // Get produk info untuk log
            $produk = $this->getById($id);
            
            // Delete produk
            $stmt = $this->db->prepare("DELETE FROM produk WHERE id = :id");
            $stmt->execute([':id' => $id]);
            
            // Log aktivitas
            logAktivitas('DELETE', 'produk', $id, "Menghapus produk: {$produk['nama_produk']}");
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}