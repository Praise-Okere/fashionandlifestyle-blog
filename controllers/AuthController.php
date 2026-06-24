<?php
// controllers/AuthController.php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../helpers/InputValidator.php';
require_once __DIR__ . '/../middleware/CSRFMiddleware.php';

class AuthController {
    private $auth;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $userModel = new User($this->db);
        $this->auth = new Auth($userModel);
    }

    public function showLogin() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function processLogin() {
        CSRFMiddleware::verify();

        $email = InputValidator::sanitizeEmail($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($this->auth->login($email, $password)) {
            header("Location: " . BASE_URL . "index.php?route=home");
            exit;
        } else {
            $error = "Invalid email or password.";
            require_once __DIR__ . '/../views/auth/login.php';
        }
    }

    public function showRegister() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function processRegister() {
        CSRFMiddleware::verify();

        $username = InputValidator::sanitizeString($_POST['username'] ?? '');
        $email = InputValidator::sanitizeEmail($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        try {
            $userId = $this->auth->register($username, $email, $password);
            if ($userId) {
                // Auto-login after registration
                $this->auth->login($email, $password);
                header("Location: " . BASE_URL . "index.php?route=home");
                exit;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            require_once __DIR__ . '/../views/auth/register.php';
        }
    }

    public function logout() {
        $this->auth->logout();
        header("Location: " . BASE_URL . "index.php?route=login");
        exit;
    }
}
