<?php
// classes/Comment.php

class Comment {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function create($post_id, $user_id, $body) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO comments (post_id, user_id, comment_body, status, created_at)
             VALUES (?, ?, ?, 'pending', NOW())"
        );
        return $stmt->execute([$post_id, $user_id, $body]);
    }

    public function approve($comment_id) {
        $stmt = $this->pdo->prepare("UPDATE comments SET status = 'approved' WHERE comment_id = ?");
        return $stmt->execute([$comment_id]);
    }

    public function delete($comment_id) {
        $stmt = $this->pdo->prepare("DELETE FROM comments WHERE comment_id = ?");
        return $stmt->execute([$comment_id]);
    }

    public function getApprovedByPost($post_id) {
        $stmt = $this->pdo->prepare("
            SELECT c.*, u.username, u.profile_image 
            FROM comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.post_id = ? AND c.status = 'approved'
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    }

    public function getPending() {
        $stmt = $this->pdo->query("
            SELECT c.*, p.title as post_title, u.username 
            FROM comments c
            JOIN posts p ON c.post_id = p.post_id
            JOIN users u ON c.user_id = u.user_id
            WHERE c.status = 'pending'
            ORDER BY c.created_at DESC
        ");
        return $stmt->fetchAll();
    }
}
