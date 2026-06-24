<?php
// controllers/CommentController.php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Comment.php';
require_once __DIR__ . '/../helpers/InputValidator.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';
require_once __DIR__ . '/../middleware/CSRFMiddleware.php';

class CommentController {
    private $db;
    private $commentModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->commentModel = new Comment($this->db);
    }

    public function store() {
        AuthMiddleware::checkAuthenticated();
        CSRFMiddleware::verify();

        $post_id = (int)($_POST['post_id'] ?? 0);
        $body = InputValidator::sanitizeString($_POST['comment_body'] ?? '');

        if (empty($body) || strlen($body) > 1000) {
            die("Comment must be between 1 and 1000 characters.");
        }

        if ($post_id > 0) {
            $this->commentModel->create($post_id, $_SESSION['user_id'], $body);
        }

        // Redirect back to post
        header("Location: " . BASE_URL . "index.php?route=post/show&id=" . $post_id . "&msg=comment_submitted");
        exit;
    }

    public function approve() {
        RoleMiddleware::isAdmin();
        
        $comment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($comment_id > 0) {
            $this->commentModel->approve($comment_id);
        }
        
        header("Location: " . BASE_URL . "index.php?route=admin/comments");
        exit;
    }

    public function delete() {
        RoleMiddleware::isAdmin();
        
        $comment_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($comment_id > 0) {
            $this->commentModel->delete($comment_id);
        }
        
        header("Location: " . BASE_URL . "index.php?route=admin/comments");
        exit;
    }
}
