<?php
// classes/Category.php

class Category {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY category_name ASC");
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE category_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($name, $description = '') {
        $stmt = $this->pdo->prepare("INSERT INTO categories (category_name, description) VALUES (?, ?)");
        return $stmt->execute([$name, $description]);
    }
}
