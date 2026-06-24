<?php
// classes/Tag.php

class Tag {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM tags ORDER BY tag_name ASC");
        return $stmt->fetchAll();
    }

    public function getTagsForPost($post_id) {
        $stmt = $this->pdo->prepare("
            SELECT t.* FROM tags t
            JOIN post_tags pt ON t.tag_id = pt.tag_id
            WHERE pt.post_id = ?
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    }
}
