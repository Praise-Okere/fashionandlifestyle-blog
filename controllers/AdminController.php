<?php
// controllers/AdminController.php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Post.php';
require_once __DIR__ . '/../classes/Comment.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class AdminController {
    private $db;
    private $postModel;
    private $commentModel;

    public function __construct() {
        RoleMiddleware::isBloggerOrAdmin();
        $this->db = (new Database())->getConnection();
        $this->postModel = new Post($this->db);
        $this->commentModel = new Comment($this->db);
    }

    public function dashboard() {
        // Fetch some stats
        $totalPosts = $this->postModel->countPublishedPosts();
        
        $pendingComments = [];
        if ($_SESSION['role'] === 'admin') {
            $pendingComments = $this->commentModel->getPending();
        }
        
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function comments() {
        RoleMiddleware::isAdmin();
        $pendingComments = $this->commentModel->getPending();
        require_once __DIR__ . '/../views/admin/comments.php';
    }
}
