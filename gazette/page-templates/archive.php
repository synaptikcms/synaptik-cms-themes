<?php /* Template Name: Archive */ ?>
<?php
$__gazArticles = sl_load_index('article');
usort($__gazArticles, function ($a, $b) {
    return strtotime($b['date'] ?? '') <=> strtotime($a['date'] ?? '');
});

$__gazGrouped = [];
foreach ($__gazArticles as $__gazArticle) {
    $__gazTs  = strtotime($__gazArticle['date'] ?? '');
    $__gazKey = $__gazTs ? date('F Y', $__gazTs) : '—';
    $__gazGrouped[$__gazKey][] = $__gazArticle;
}
?>
<article class="content-single gazette-fullwidth">
    <?php echo render_content_title($item); ?>

    <?php echo render_item_custom_fields($item, 'page'); ?>

    <?php if (!empty($item['content'])): ?>
    <div class="prose-body">
        <?php echo render_content_html($item['content'], $item); ?>
    </div>
    <?php endif; ?>
</article>

<div class="gazette-archive-full">
    <?php if (empty($__gazGrouped)): ?>
    <p class="empty-state"><?php echo hsc(__t('no_content_yet') ?: 'Nothing here yet.'); ?></p>
    <?php endif; ?>

    <?php foreach ($__gazGrouped as $__gazMonth => $__gazItems): ?>
    <section class="gazette-archive-month">
        <h2 class="gazette-archive-month-heading"><?php echo hsc($__gazMonth); ?></h2>
        <ul class="gazette-archive-full-list">
            <?php foreach ($__gazItems as $__gazArticle):
                $__gazSlug    = !empty($__gazArticle['custom_slug']) ? $__gazArticle['custom_slug'] : $__gazArticle['slug'];
                $__gazCatSlug = !empty($__gazArticle['category']) ? sanitizeSlug($__gazArticle['category']) : null;
                $__gazLink    = cleanUrl('article', $__gazSlug, null, $__gazCatSlug);
                $__gazTs      = strtotime($__gazArticle['date'] ?? '');
            ?>
            <li class="gazette-archive-full-item">
                <span class="gazette-archive-full-day"><?php echo $__gazTs ? hsc(date('d', $__gazTs)) : '—'; ?></span>
                <a href="<?php echo $__gazLink; ?>"><?php echo hsc($__gazArticle['title']); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endforeach; ?>
</div>
