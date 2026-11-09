<?php
switch ($list_type) {
    case 'category':
        $eyebrow = __t('category') ?: 'Category';
        $displayName = '';
        foreach ($items as $item) {
            if (!empty($item['category'])) { $displayName = $item['category']; break; }
        }
        $heading = htmlspecialchars($displayName ?: urldecode($filter_value));
        break;
    case 'tag':
        $eyebrow = __t('tag') ?: 'Tag';
        $tagName = '';
        foreach ($items as $item) {
            if (!empty($item['tags']) && is_array($item['tags'])) {
                foreach ($item['tags'] as $t) {
                    if (sanitizeSlug($t) === $filter_value) { $tagName = $t; break 2; }
                }
            }
        }
        $heading = '#' . htmlspecialchars($tagName ?: urldecode($filter_value));
        break;
    default:
        $eyebrow = '';
        $heading = htmlspecialchars(sl_type_label($list_type, true));
}
?>
<div class="vt-list-page">
    <header class="vt-list-header">
        <?php if (!empty($eyebrow)): ?><p class="vt-list-eyebrow"><?php echo $eyebrow; ?></p><?php endif; ?>
        <h1 class="vt-list-heading"><?php echo $heading; ?></h1>
    </header>
    <?php if (empty($articles) && empty($projects)): ?>
    <p class="vt-empty"><?php echo __t('vitae_nothing'); ?></p>
    <?php endif; ?>
    <?php if (!empty($projects)): ?>
    <div class="vt-projects-grid vt-projects-grid--list">
        <?php foreach ($projects as $project): echo render_project_card($project); endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if (!empty($articles)): ?>
    <ul class="vt-articles-list" role="list">
        <?php foreach ($articles as $article): echo render_article_card($article); endforeach; ?>
    </ul>
    <?php endif; ?>
</div>
