<?php
// controllers/PostController.php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Post.php';
require_once __DIR__ . '/../classes/Category.php';
require_once __DIR__ . '/../classes/Tag.php';
require_once __DIR__ . '/../helpers/InputValidator.php';
require_once __DIR__ . '/../helpers/FileUploader.php';
require_once __DIR__ . '/../helpers/Paginator.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';
require_once __DIR__ . '/../middleware/CSRFMiddleware.php';

class PostController {
    private $db;
    private $postModel;
    private $categoryModel;
    private $tagModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->postModel = new Post($this->db);
        $this->categoryModel = new Category($this->db);
        $this->tagModel = new Tag($this->db);
    }

    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        
        $totalPosts = $this->postModel->countPublishedPosts();
        $paginator = new Paginator($totalPosts, $page, $limit);
        
        $posts = $this->postModel->getPublishedPosts($paginator->getOffset(), $limit);
        
        require_once __DIR__ . '/../views/posts/index.php';
    }

    public function show() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $post = $this->postModel->getPostById($id);
        
        if (!$post || $post['status'] !== 'published') {
            http_response_code(404);
            die("Post not found");
        }
        
        $tags = $this->tagModel->getTagsForPost($id);
        
        require_once __DIR__ . '/../classes/Comment.php';
        $commentModel = new Comment($this->db);
        $comments = $commentModel->getApprovedByPost($id);
        
        require_once __DIR__ . '/../views/posts/single.php';
    }

    public function create() {
        RoleMiddleware::isBloggerOrAdmin();
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/posts/create.php';
    }

    public function store() {
        RoleMiddleware::isBloggerOrAdmin();
        CSRFMiddleware::verify();

        $title = InputValidator::sanitizeString($_POST['title'] ?? '');
        $content = InputValidator::cleanHtml($_POST['content'] ?? '');
        $category_id = (int)($_POST['category_id'] ?? 0);
        $status = in_array($_POST['status'], ['draft', 'published']) ? $_POST['status'] : 'draft';
        
        $tagsInput = InputValidator::sanitizeString($_POST['tags'] ?? '');
        $tags = array_filter(array_map('trim', explode(',', $tagsInput)));

        $featured_image = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            try {
                $uploader = new FileUploader('posts');
                $featured_image = $uploader->upload($_FILES['featured_image']);
            } catch (Exception $e) {
                $error = $e->getMessage();
                $categories = $this->categoryModel->getAll();
                require_once __DIR__ . '/../views/posts/create.php';
                return;
            }
        }

        try {
            $postId = $this->postModel->create(
                $_SESSION['user_id'], 
                $category_id, 
                $title, 
                $content, 
                $featured_image, 
                $status, 
                $tags
            );
            header("Location: " . BASE_URL . "index.php?route=post/show&id=" . $postId);
            exit;
        } catch (Exception $e) {
            $error = "Failed to create post. Please try again.";
            $categories = $this->categoryModel->getAll();
            require_once __DIR__ . '/../views/posts/create.php';
        }
    }
}
