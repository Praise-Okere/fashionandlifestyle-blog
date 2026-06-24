<?php
// config/constants.php

// Define Base URL using environment variable or default fallback
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost/fashion/');

// Directory for uploads
define('UPLOAD_DIR', realpath(__DIR__ . '/../public/uploads/'));
define('UPLOAD_URL', BASE_URL . 'public/uploads/');

// Other global constants
define('APP_NAME', 'Fashion & Lifestyle Blog');
