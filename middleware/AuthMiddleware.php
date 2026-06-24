<?php
// middleware/AuthMiddleware.php

class AuthMiddleware {
    public static function checkAuthenticated() {
        if (!isset($_SESSION['user_id'])) {
            // Not logged in, redirect to login page
            header("Location: " . BASE_URL . "index.php?route=login");
            exit;
        }
    }

    public static function checkGuest() {
        if (isset($_SESSION['user_id'])) {
            // Already logged in, redirect to dashboard/home
            header("Location: " . BASE_URL . "index.php?route=home");
            exit;
        }
    }
}
