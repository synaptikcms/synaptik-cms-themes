<?php
switch ($list_type) {
    case 'category':
        $label = __t('category') ?: 'Category';
        $displayName = '';
        foreach ($items as $it) {
            if (!empty($it['category'])) { $displayName = $it['category']; break; }
        }
        $heading = htmlspecialchars($displayName ?: urldecode($filter_value));
        break;
    case 'tag':
        $label = __t('tag') ?: 'Tag';
        $tagName = '';
        foreach ($items as $it) {
            if (!empty($it['tags']) && is_array($it['tags'])) {
                foreach ($it['tags'] as $t) {
                    if (sanitizeSlug($t) === $filter_value) { $tagName = $t; break 2; }
                }
            }
        }
        $heading = '#' . htmlspecialchars($tagName ?: urldecode($filter_value));
        break;
    default:
        $label   = '';
        $heading = in_array($list_type, ['article', 'page', 'project'], true)
            ? htmlspecialchars(sl_type_label($list_type, true))
            : htmlspecialchars(sl_type_label($list_type, true));
}
?>
<div class="ink-list-page">
    <header class="ink-list-header">
        <?php if ($label): ?><p class="ink-list-eyebrow"><?php echo $label; ?></p><?php endif; ?>
        <h1 class="ink-list-heading"><?php echo $heading; ?></h1>
    </header>

    <?php if (empty($articles) && empty($projects)): ?>
        <p class="ink-empty"><?php echo __t('page_not_found_desc') ?: 'Nothing here yet.'; ?></p>
    <?php endif; ?>

    <?php if (!empty($articles)): ?>
    <div class="ink-masonry">
        <?php foreach ($articles as $article): ?>
            <?php echo render_article_card($article); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($projects)): ?>
    <?php if (!empty($articles)): ?><div class="ink-list-group-label"><?php echo sl_type_label('project', true); ?></div><?php endif; ?>
    <div class="ink-masonry">
        <?php foreach ($projects as $project): ?>
            <?php echo render_project_card($project); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
