<?php
require_once 'Database.php';
class Repository {
    protected $table;
    protected $pdo;

    public function __construct($table) {
        $this->table = $table;
        $this->pdo = Database::connect();
    }
    public function getPdo() {
        return $this->pdo;
    }

    public function findAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($fields) VALUES ($placeholders)");
        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    
}
