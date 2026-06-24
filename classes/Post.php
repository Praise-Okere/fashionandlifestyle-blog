<?php
// classes/Post.php

class Post {
    private $pdo;

    public function __construct($db) {
        $this->pdo = $db;
    }

    public function create($user_id, $category_id, $title, $content, $featured_image = null, $status = 'draft', $tags = []) {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare(
                "INSERT INTO posts (user_id, category_id, title, content, featured_image, status, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, NOW())"
            );
            $stmt->execute([$user_id, $category_id, $title, $content, $featured_image, $status]);
            $post_id = $this->pdo->lastInsertId();

            if (!empty($tags)) {
                $this->assignTags($post_id, $tags);
            }

            $this->pdo->commit();
            return $post_id;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function update($post_id, $category_id, $title, $content, $featured_image = null, $status = 'draft', $tags = []) {
        try {
            $this->pdo->beginTransaction();

            if ($featured_image) {
                $stmt = $this->pdo->prepare(
                    "UPDATE posts SET category_id = ?, title = ?, content = ?, featured_image = ?, status = ? WHERE post_id = ?"
                );
                $stmt->execute([$category_id, $title, $content, $featured_image, $status, $post_id]);
            } else {
                $stmt = $this->pdo->prepare(
                    "UPDATE posts SET category_id = ?, title = ?, content = ?, status = ? WHERE post_id = ?"
                );
                $stmt->execute([$category_id, $title, $content, $status, $post_id]);
            }

            // Simple tag update: delete old, insert new
            $stmt = $this->pdo->prepare("DELETE FROM post_tags WHERE post_id = ?");
            $stmt->execute([$post_id]);
            
            if (!empty($tags)) {
                $this->assignTags($post_id, $tags);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    private function assignTags($post_id, $tags) {
        foreach ($tags as $tag_name) {
            $tag_name = trim($tag_name);
            if (empty($tag_name)) continue;

            $stmt = $this->pdo->prepare("INSERT IGNORE INTO tags (tag_name) VALUES (?)");
            $stmt->execute([$tag_name]);
            
            $stmt = $this->pdo->prepare("SELECT tag_id FROM tags WHERE tag_name = ?");
            $stmt->execute([$tag_name]);
            $tag = $stmt->fetch();
            
            if ($tag) {
                $stmt = $this->pdo->prepare("INSERT IGNORE INTO post_tags (post_id, tag_id) VALUES (?, ?)");
                $stmt->execute([$post_id, $tag['tag_id']]);
            }
        }
    }

    public function getPublishedPosts($offset = 0, $limit = 10, $category_id = null) {
        $query = "SELECT p.*, u.username, c.category_name 
                  FROM posts p
                  JOIN users u ON p.user_id = u.user_id
                  JOIN categories c ON p.category_id = c.category_id
                  WHERE p.status = 'published'";
        
        $params = [];
        if ($category_id) {
            $query .= " AND p.category_id = ?";
            $params[] = $category_id;
        }
        
        $query .= " ORDER BY p.created_at DESC LIMIT $limit OFFSET $offset";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countPublishedPosts($category_id = null) {
        $query = "SELECT COUNT(*) as count FROM posts WHERE status = 'published'";
        $params = [];
        if ($category_id) {
            $query .= " AND category_id = ?";
            $params[] = $category_id;
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch()['count'];
    }

    public function getPostById($id) {
        $stmt = $this->pdo->prepare("
            SELECT p.*, u.username, u.bio, u.profile_image, c.category_name 
            FROM posts p
            JOIN users u ON p.user_id = u.user_id
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.post_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
