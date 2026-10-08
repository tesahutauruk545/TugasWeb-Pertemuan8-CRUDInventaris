<?php
require_once __DIR__ . '/../config/database.php';

class Kategori {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM kategori ORDER BY nama_kategori");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM kategori WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}