<?php
// classes/Auth.php

class Auth {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function login($email, $password) {
        $user = $this->userModel->findByEmail($email);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Setup session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        
        return false;
    }

    public function register($username, $email, $password, $role = 'reader') {
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception('All fields are required.');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }
        
        if ($this->userModel->findByEmail($email)) {
            throw new Exception('Email is already registered.');
        }
        
        return $this->userModel->create($username, $email, $password, $role);
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function getUserRole() {
        return isset($_SESSION['role']) ? $_SESSION['role'] : null;
    }
}
