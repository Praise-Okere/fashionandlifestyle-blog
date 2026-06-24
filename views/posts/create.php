<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../helpers/SecurityHelper.php'; ?>

<div class="row py-4">
    <div class="col-md-3 border-end pe-4">
        <h6 class="text-uppercase text-muted text-mono mb-4" style="letter-spacing: 1px; font-size: 12px;">Dashboard Menu</h6>
        <div class="nav flex-column dashboard-nav">
            <a href="<?= BASE_URL ?>index.php?route=admin/dashboard" class="nav-link text-muted mb-2 ps-3" style="border-left: 2px solid transparent;">Overview</a>
            <a href="<?= BASE_URL ?>index.php?route=post/create" class="nav-link text-dark fw-bold mb-2 ps-3" style="border-left: 2px solid var(--color-gold);">Create New Post</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="<?= BASE_URL ?>index.php?route=admin/comments" class="nav-link text-muted mb-2 ps-3 d-flex justify-content-between align-items-center" style="border-left: 2px solid transparent;">
                    Manage Comments
                    <?php if (isset($pendingComments) && count($pendingComments) > 0): ?>
                        <span class="badge rounded-pill" style="background-color: var(--color-gold);"><?= count($pendingComments) ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="col-md-9 ps-5">
        <h2 class="mb-4" style="font-family: var(--font-heading);">Create New Post</h2>
        
        <div class="luxury-card p-5">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" style="border-radius: 4px;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form action="<?= BASE_URL ?>index.php?route=post/store" method="POST" enctype="multipart/form-data">
                <?= SecurityHelper::getCSRFInput() ?>
                
                <div class="mb-4">
                    <label for="title" class="form-label text-uppercase text-muted text-mono" style="font-size: 12px; letter-spacing: 1px;">Post Title</label>
                    <input type="text" class="form-control form-control-lg" id="title" name="title" required style="border-radius: 4px;">
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label text-uppercase text-muted text-mono" style="font-size: 12px; letter-spacing: 1px;">Category</label>
                        <select class="form-select form-select-lg" id="category_id" name="category_id" required style="border-radius: 4px; font-size: 15px;">
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label text-uppercase text-muted text-mono" style="font-size: 12px; letter-spacing: 1px;">Status</label>
                        <select class="form-select form-select-lg" id="status" name="status" style="border-radius: 4px; font-size: 15px;">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="featured_image" class="form-label text-uppercase text-muted text-mono" style="font-size: 12px; letter-spacing: 1px;">Featured Image</label>
                    <input class="form-control form-control-lg" type="file" id="featured_image" name="featured_image" accept="image/jpeg, image/png, image/webp" style="border-radius: 4px; font-size: 15px;">
                    <div class="form-text mt-2 text-mono" style="font-size: 11px;">Max size 5MB. Formats: JPEG, PNG, WebP.</div>
                </div>
                
                <div class="mb-4">
                    <label for="content" class="form-label text-uppercase text-muted text-mono" style="font-size: 12px; letter-spacing: 1px;">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="15" style="border-radius: 4px;"></textarea>
                </div>
                
                <div class="mb-5">
                    <label for="tags" class="form-label text-uppercase text-muted text-mono" style="font-size: 12px; letter-spacing: 1px;">Tags (comma-separated)</label>
                    <input type="text" class="form-control form-control-lg" id="tags" name="tags" placeholder="e.g. fashion, summer, styles" style="border-radius: 4px; font-size: 15px;">
                </div>
                
                <div class="d-flex gap-3">
                    <button type="submit" class="btn-gold px-5 py-3 border-0">Save Post</button>
                    <a href="<?= BASE_URL ?>index.php?route=admin/dashboard" class="btn btn-outline-dark px-5 py-3" style="border-radius: 4px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: '#content',
        plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
        toolbar_mode: 'floating',
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
