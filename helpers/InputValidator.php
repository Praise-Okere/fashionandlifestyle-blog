<?php
// helpers/InputValidator.php

class InputValidator {
    public static function sanitizeString($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeEmail($email) {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validateLength($input, $min, $max) {
        $length = strlen(trim($input));
        return $length >= $min && $length <= $max;
    }
    
    public static function cleanHtml($content) {
        // Strip out dangerous tags but allow basic formatting
        return strip_tags($content, '<p><br><strong><em><ul><li><ol><h1><h2><h3><h4><h5><h6><a><img><blockquote>');
    }
}
