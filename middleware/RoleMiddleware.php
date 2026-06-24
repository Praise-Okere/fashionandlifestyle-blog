<?php
// middleware/RoleMiddleware.php

class RoleMiddleware {
    public static function checkRole($allowedRoles) {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
            header("Location: " . BASE_URL . "index.php?route=login");
            exit;
        }

        $userRole = $_SESSION['role'];
        if (!in_array($userRole, $allowedRoles)) {
            // Unauthorized access
            http_response_code(403);
            die("Access Denied. You do not have permission to access this page.");
        }
    }

    public static function isAdmin() {
        self::checkRole(['admin']);
    }

    public static function isBloggerOrAdmin() {
        self::checkRole(['admin', 'blogger']);
    }
}
