<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($post['category_name']) ?></li>
            </ol>
        </nav>

        <article class="blog-post">
            <h1 class="blog-post-title mb-1"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="blog-post-meta text-muted">
                <?= date('F j, Y', strtotime($post['created_at'])) ?> by <a href="#"><?= htmlspecialchars($post['username']) ?></a>
            </p>

            <?php if (!empty($tags)): ?>
                <div class="mb-3">
                    <?php foreach ($tags as $tag): ?>
                        <span class="badge bg-info text-dark">#<?= htmlspecialchars($tag['tag_name']) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($post['featured_image']): ?>
                <img src="<?= UPLOAD_URL . 'posts/' . htmlspecialchars($post['featured_image']) ?>" class="img-fluid rounded mb-4" alt="Featured Image">
            <?php endif; ?>

            <div class="post-content">
                <!-- Content is already sanitized upon insertion, and we allow specific tags -->
                <?= $post['content'] ?>
            </div>
        </article>

        <hr class="my-5">

        <div id="comments-section" class="mt-5">
            <h3 style="font-family: var(--font-heading);">Comments (<?= count($comments) ?>)</h3>
            
            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'comment_submitted'): ?>
                <div class="alert alert-success mt-3" style="border-radius: 4px;">Your comment has been submitted and is awaiting approval.</div>
            <?php endif; ?>

            <div class="comments-list mt-4">
                <?php if (empty($comments)): ?>
                    <p class="text-muted">No comments yet. Be the first to share your thoughts!</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card mb-3 border-0" style="background-color: #f1f0ee; border-radius: 8px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background-color: var(--color-gold); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                            <?= strtoupper(substr($comment['username'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold"><?= htmlspecialchars($comment['username']) ?></h6>
                                        <small class="text-muted text-mono" style="font-size: 11px;"><?= date('M d, Y', strtotime($comment['created_at'])) ?></small>
                                    </div>
                                </div>
                                <p class="mb-0 mt-3"><?= nl2br(htmlspecialchars($comment['comment_body'])) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <h4 class="mt-5 mb-3" style="font-family: var(--font-heading);">Leave a Comment</h4>
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="<?= BASE_URL ?>index.php?route=comment/store" method="POST">
                    <?= SecurityHelper::getCSRFInput() ?>
                    <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                    <div class="mb-3">
                        <textarea class="form-control" name="comment_body" rows="4" placeholder="Share your thoughts..." required style="resize: none; border-radius: 4px;"></textarea>
                    </div>
                    <button type="submit" class="btn-gold mt-2">Submit Comment</button>
                </form>
            <?php else: ?>
                <div class="p-4 text-center mt-4" style="background-color: #f1f0ee; border-radius: 8px;">
                    <p class="mb-0 text-muted">You must be <a href="<?= BASE_URL ?>index.php?route=login" class="fw-bold" style="color: var(--color-gold); text-decoration: none;">logged in</a> to leave a comment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
