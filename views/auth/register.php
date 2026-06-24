<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../helpers/SecurityHelper.php'; ?>

<div class="row justify-content-center py-5 mt-4">
    <div class="col-md-5">
        <div class="luxury-card p-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="font-family: var(--font-heading);">Create an Account</h2>
                <p class="text-muted">Join our fashion community today</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" style="border-radius: 4px;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form action="<?= BASE_URL ?>index.php?route=register" method="POST">
                <?= SecurityHelper::getCSRFInput() ?>
                <div class="mb-4">
                    <label for="username" class="form-label text-mono text-uppercase text-muted" style="font-size: 12px; letter-spacing: 1px;">Username</label>
                    <input type="text" class="form-control form-control-lg" id="username" name="username" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label text-mono text-uppercase text-muted" style="font-size: 12px; letter-spacing: 1px;">Email address</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                </div>
                <div class="mb-5">
                    <label for="password" class="form-label text-mono text-uppercase text-muted" style="font-size: 12px; letter-spacing: 1px;">Password</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" required minlength="6">
                </div>
                <button type="submit" class="btn-gold w-100 fs-6 py-3">Sign Up</button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-muted">Already have an account? <a href="<?= BASE_URL ?>index.php?route=login" class="btn-link-gold">Login here</a></p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
