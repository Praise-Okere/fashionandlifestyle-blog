<?php
// public/index.php

// 1. Session Start and Security Setup
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS
ini_set('session.cookie_samesite', 'Strict');
session_start();
session_regenerate_id(true); // Prevent Session Fixation

// 2. Load Configuration and Error Handlers
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../config/error_handler.php';

// 3. Simple Front Controller / Router
$route = isset($_GET['route']) ? $_GET['route'] : 'home';

// Basic routing
if ($route === 'login') {
    require_once __DIR__ . '/../controllers/AuthController.php';
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->processLogin();
    } else {
        $controller->showLogin();
    }
} elseif ($route === 'register') {
    require_once __DIR__ . '/../controllers/AuthController.php';
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->processRegister();
    } else {
        $controller->showRegister();
    }
} elseif ($route === 'logout') {
    require_once __DIR__ . '/../controllers/AuthController.php';
    $controller = new AuthController();
    $controller->logout();
} elseif ($route === 'post/show') {
    require_once __DIR__ . '/../controllers/PostController.php';
    (new PostController())->show();
} elseif ($route === 'post/create') {
    require_once __DIR__ . '/../controllers/PostController.php';
    (new PostController())->create();
} elseif ($route === 'post/store') {
    require_once __DIR__ . '/../controllers/PostController.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        (new PostController())->store();
    } else {
        header("Location: " . BASE_URL . "index.php");
    }
} elseif ($route === 'comment/store') {
    require_once __DIR__ . '/../controllers/CommentController.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        (new CommentController())->store();
    }
} elseif ($route === 'comment/approve') {
    require_once __DIR__ . '/../controllers/CommentController.php';
    (new CommentController())->approve();
} elseif ($route === 'comment/delete') {
    require_once __DIR__ . '/../controllers/CommentController.php';
    (new CommentController())->delete();
} elseif ($route === 'admin/dashboard') {
    require_once __DIR__ . '/../controllers/AdminController.php';
    (new AdminController())->dashboard();
} elseif ($route === 'admin/comments') {
    require_once __DIR__ . '/../controllers/AdminController.php';
    (new AdminController())->comments();
} elseif ($route === 'home' || $route === '') {
    require_once __DIR__ . '/../controllers/PostController.php';
    (new PostController())->index();
} else {
    // 404 Route
    http_response_code(404);
    require_once __DIR__ . '/../views/layouts/header.php';
    echo "<h1>404 Not Found</h1>";
    echo "<p>The page you requested does not exist.</p>";
    require_once __DIR__ . '/../views/layouts/footer.php';
}
