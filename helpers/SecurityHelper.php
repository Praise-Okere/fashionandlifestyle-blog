<?php
// helpers/SecurityHelper.php

class SecurityHelper {
    public static function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCSRFToken($token) {
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        }
        return false;
    }

    public static function getCSRFInput() {
        $token = self::generateCSRFToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}
