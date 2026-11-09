<?php
if ($list_type === 'category') {
    $heading = $categoryName ?? $filter_value;
} elseif ($list_type === 'tag') {
    $heading = $tagName ?? $filter_value;
} else {
    $heading = sl_type_label($list_type, true);
}
?>
<div class="gazette-columns">
<div class="gazette-content">
<div class="content-list">
    <h1 class="list-heading"><?php echo hsc($heading); ?></h1>

    <?php if (empty($articles) && empty($projects)): ?>
    <p class="empty-state"><?php echo hsc(__t('no_content_yet') ?: 'Nothing here yet.'); ?></p>
    <?php endif; ?>

    <?php if (!empty($articles)): ?>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
            <?php echo render_article_card($article); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($projects)): ?>
    <div class="projects-grid">
        <?php foreach ($projects as $project): ?>
            <?php echo render_project_card($project); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
</div>
<?php echo gazette_render_sidebar_archive(); ?>
</div>
