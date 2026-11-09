<?php /* Template Name: Changelog */ ?>
<?php
$__dispArticles = sl_load_index('article');
usort($__dispArticles, function ($a, $b) {
    return strtotime($b['date'] ?? '') <=> strtotime($a['date'] ?? '');
});

$__dispGrouped = [];
foreach ($__dispArticles as $__dispArticle) {
    $__dispTs  = strtotime($__dispArticle['date'] ?? '');
    $__dispKey = $__dispTs ? date('Y', $__dispTs) : '—';
    $__dispGrouped[$__dispKey][] = $__dispArticle;
}
?>
<div class="dispatch-container">
<article class="content-single">
    <?php echo render_content_title($item); ?>

    <?php if (!empty($item['content'])): ?>
    <div class="prose-body">
        <?php echo render_content_html($item['content'], $item); ?>
    </div>
    <?php endif; ?>
</article>

<?php if (empty($__dispGrouped)): ?>
<p class="empty-state"><?php echo hsc(__t('no_content_yet') ?: 'Nothing here yet.'); ?></p>
<?php endif; ?>

<?php foreach ($__dispGrouped as $__dispYear => $__dispItems): ?>
<section class="home-section">
    <h2 class="dispatch-label"><?php echo hsc($__dispYear); ?></h2>
    <?php echo dispatch_render_timeline($__dispItems, false); ?>
</section>
<?php endforeach; ?>
</div>
