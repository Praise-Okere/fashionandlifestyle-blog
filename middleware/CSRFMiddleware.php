<?php
// middleware/CSRFMiddleware.php

require_once __DIR__ . '/../helpers/SecurityHelper.php';

class CSRFMiddleware {
    public static function verify() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
            if (!SecurityHelper::verifyCSRFToken($token)) {
                http_response_code(403);
                die("CSRF Token Verification Failed.");
            }
        }
    }
}
