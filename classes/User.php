<?php
// classes/User.php

class User {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($username, $email, $password, $role = 'reader') {
        $password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (username, email, password_hash, role, created_at) 
             VALUES (?, ?, ?, ?, NOW())"
        );
        $stmt->execute([$username, $email, $password_hash, $role]);
        
        return $this->pdo->lastInsertId();
    }

    public function updateProfile($id, $bio, $profile_image = null) {
        if ($profile_image) {
            $stmt = $this->pdo->prepare("UPDATE users SET bio = ?, profile_image = ? WHERE user_id = ?");
            return $stmt->execute([$bio, $profile_image, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE users SET bio = ? WHERE user_id = ?");
            return $stmt->execute([$bio, $id]);
        }
    }
}
