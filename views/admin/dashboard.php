<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row py-4">
    <div class="col-md-3 border-end pe-4">
        <h6 class="text-uppercase text-muted text-mono mb-4" style="letter-spacing: 1px; font-size: 12px;">Dashboard Menu</h6>
        <div class="nav flex-column dashboard-nav">
            <a href="<?= BASE_URL ?>index.php?route=admin/dashboard" class="nav-link text-dark fw-bold mb-2 ps-3" style="border-left: 2px solid var(--color-gold);">Overview</a>
            <a href="<?= BASE_URL ?>index.php?route=post/create" class="nav-link text-muted mb-2 ps-3" style="border-left: 2px solid transparent;">Create New Post</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>index.php?route=admin/comments" class="nav-link text-muted mb-2 ps-3 d-flex justify-content-between align-items-center" style="border-left: 2px solid transparent;">
                    Manage Comments
                    <?php if (count($pendingComments) > 0): ?>
                        <span class="badge rounded-pill" style="background-color: var(--color-gold);"><?= count($pendingComments) ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="col-md-9 ps-5">
        <h2 class="mb-1" style="font-family: var(--font-heading);">Welcome back, <?= htmlspecialchars($_SESSION['username']) ?>.</h2>
        <p class="text-muted text-mono mb-5" style="font-size: 13px;">ROLE: <?= strtoupper(htmlspecialchars($_SESSION['role'])) ?></p>
        
        <div class="row g-4">
            <div class="col-md-5">
                <div class="luxury-card p-4 text-center h-100 d-flex flex-column justify-content-center">
                    <h6 class="text-uppercase text-muted text-mono mb-3" style="letter-spacing: 1px; font-size: 12px;">Total Published Posts</h6>
                    <p class="display-4 fw-bold mb-0" style="font-family: var(--font-heading); color: var(--color-gold);"><?= $totalPosts ?></p>
                </div>
            </div>
            
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <div class="col-md-5">
                    <div class="luxury-card p-4 text-center h-100 d-flex flex-column justify-content-center">
                        <h6 class="text-uppercase text-muted text-mono mb-3" style="letter-spacing: 1px; font-size: 12px;">Pending Comments</h6>
                        <p class="display-4 fw-bold mb-0" style="font-family: var(--font-heading); color: var(--color-gold);"><?= count($pendingComments) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
