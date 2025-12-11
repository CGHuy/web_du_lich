<?php
// Component breadcrumb nhận mảng $breadcrumbs
if (!isset($breadcrumbs) || !is_array($breadcrumbs))
    return;
?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $i => $item): ?>
        <span class="breadcrumb-item<?= $i === count($breadcrumbs) - 1 ? ' breadcrumb-current' : '' ?>">
            <?php if (!empty($item['url']) && $i !== count($breadcrumbs) - 1): ?>
                <a class="breadcrumb-link"
                    href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['label']) ?></a>
            <?php else: ?>
                <?= htmlspecialchars($item['label']) ?>
            <?php endif; ?>
        </span>
        <?php if ($i < count($breadcrumbs) - 1): ?>
            <span class="breadcrumb-separator">/</span>
        <?php endif; ?>
    <?php endforeach; ?>
</div>