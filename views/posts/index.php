<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Hero Section -->
<div class="hero-section" style="background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop');">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Discover Fashion & Lifestyle</h1>
        <p>Curated stories from creators worldwide</p>
        <a href="#posts" class="btn-gold mt-4">Explore Now</a>
    </div>
</div>

<div class="row" id="posts">
    <div class="col-12">
        <?php if (empty($posts)): ?>
            <div class="text-center py-5">
                <p class="text-muted fs-5">No posts available at the moment. Check back soon!</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($posts as $post): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="<?= BASE_URL ?>index.php?route=post/show&id=<?= $post['post_id'] ?>" class="text-decoration-none">
                            <div class="blog-card">
                                <div class="blog-card-img-wrapper">
                                    <?php if ($post['featured_image']): ?>
                                        <img src="<?= UPLOAD_URL . 'posts/' . htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: #E8E8E8;">
                                            <span class="text-muted small-meta">NO IMAGE</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="blog-card-body">
                                    <span class="category-tag"><?= htmlspecialchars($post['category_name']) ?></span>
                                    <h4 class="blog-card-title"><?= htmlspecialchars($post['title']) ?></h4>
                                    
                                    <div class="blog-card-meta mt-3">
                                        <span class="fw-medium" style="color: var(--color-text);"><?= htmlspecialchars($post['username']) ?></span>
                                        <span class="mx-2">&mdash;</span>
                                        <?= date('M d, Y', strtotime($post['created_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-5 d-flex justify-content-center">
                <?= $paginator->createLinks(BASE_URL . 'index.php?route=home') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
