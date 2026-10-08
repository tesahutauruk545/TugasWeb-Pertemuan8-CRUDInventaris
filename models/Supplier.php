<?php
require_once __DIR__ . '/../config/database.php';

class Supplier {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM supplier ORDER BY nama_supplier");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM supplier WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}