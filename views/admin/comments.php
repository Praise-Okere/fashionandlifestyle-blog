<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="row py-4">
    <div class="col-md-3 border-end pe-4">
        <h6 class="text-uppercase text-muted text-mono mb-4" style="letter-spacing: 1px; font-size: 12px;">Dashboard Menu</h6>
        <div class="nav flex-column dashboard-nav">
            <a href="<?= BASE_URL ?>index.php?route=admin/dashboard" class="nav-link text-muted mb-2 ps-3" style="border-left: 2px solid transparent;">Overview</a>
            <a href="<?= BASE_URL ?>index.php?route=post/create" class="nav-link text-muted mb-2 ps-3" style="border-left: 2px solid transparent;">Create New Post</a>
            <a href="<?= BASE_URL ?>index.php?route=admin/comments" class="nav-link text-dark fw-bold mb-2 ps-3 d-flex justify-content-between align-items-center" style="border-left: 2px solid var(--color-gold);">
                Manage Comments
                <?php if (count($pendingComments) > 0): ?>
                    <span class="badge rounded-pill" style="background-color: var(--color-gold);"><?= count($pendingComments) ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
    
    <div class="col-md-9 ps-5">
        <h2 class="mb-4" style="font-family: var(--font-heading);">Pending Comments</h2>
        
        <?php if (empty($pendingComments)): ?>
            <div class="p-4 text-center" style="background-color: #f1f0ee; border-radius: 8px;">
                <p class="mb-0 text-muted">No pending comments to review!</p>
            </div>
        <?php else: ?>
            <div class="luxury-card p-0 overflow-hidden">
                <table class="table table-hover mb-0 border-0" style="background-color: transparent;">
                    <thead style="background-color: #f9f8f6; border-bottom: 1px solid #e8e8e8;">
                        <tr>
                            <th class="text-uppercase text-muted text-mono py-3 ps-4 border-0" style="font-size: 11px; letter-spacing: 1px;">User</th>
                            <th class="text-uppercase text-muted text-mono py-3 border-0" style="font-size: 11px; letter-spacing: 1px;">Comment</th>
                            <th class="text-uppercase text-muted text-mono py-3 border-0" style="font-size: 11px; letter-spacing: 1px;">Post</th>
                            <th class="text-uppercase text-muted text-mono py-3 border-0" style="font-size: 11px; letter-spacing: 1px;">Date</th>
                            <th class="text-uppercase text-muted text-mono py-3 pe-4 border-0 text-end" style="font-size: 11px; letter-spacing: 1px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="border-top: none;">
                        <?php foreach ($pendingComments as $comment): ?>
                            <tr style="border-bottom: 1px solid #e8e8e8;">
                                <td class="ps-4 py-3 align-middle fw-bold"><?= htmlspecialchars($comment['username']) ?></td>
                                <td class="py-3 align-middle text-muted" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($comment['comment_body']) ?></td>
                                <td class="py-3 align-middle" style="font-family: var(--font-heading);"><?= htmlspecialchars($comment['post_title']) ?></td>
                                <td class="py-3 align-middle text-mono text-muted" style="font-size: 12px;"><?= date('M d, Y', strtotime($comment['created_at'])) ?></td>
                                <td class="pe-4 py-3 align-middle text-end">
                                    <a href="<?= BASE_URL ?>index.php?route=comment/approve&id=<?= $comment['comment_id'] ?>" class="btn btn-sm btn-outline-dark" style="font-size: 12px;">Approve</a>
                                    <a href="<?= BASE_URL ?>index.php?route=comment/delete&id=<?= $comment['comment_id'] ?>" class="btn btn-sm text-danger border-0 shadow-none" style="font-size: 12px;" onclick="return confirm('Delete this comment?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
