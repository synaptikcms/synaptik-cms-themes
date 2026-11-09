<?php
/**
 * Vanta Theme — content-list.php
 *
 * Article/project/category/tag list pages.
 * Injected variables: $list_type, $articles, $projects, $items,
 *                     $filter_value, $data, $settings
 */
switch ($list_type) {
    case 'category':
        $eyebrow = __t('breadcrumb_category') ?: 'Category';
        $displayName = '';
        foreach ($items as $item) {
            if (!empty($item['category'])) { $displayName = $item['category']; break; }
        }
        $heading = htmlspecialchars($displayName ?: urldecode($filter_value));
        break;

    case 'tag':
        $eyebrow = __t('breadcrumb_tag') ?: 'Tag';
        $tagName  = '';
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

<div class="vanta-list-page">

    <header class="list-page-header">
        <?php if (!empty($eyebrow)): ?>
        <p class="list-page-eyebrow"><?php echo $eyebrow; ?></p>
        <?php endif; ?>
        <h1 class="list-page-heading"><?php echo $heading; ?></h1>
    </header>

    <?php if (empty($articles) && empty($projects)): ?>
        <p class="empty-state"><?php echo __t('no_type_found') ?: 'Nothing here yet.'; ?></p>
    <?php endif; ?>

    <?php if (!empty($articles)): ?>
        <?php if ($list_type === 'category' || $list_type === 'tag'): ?>
        <div class="list-category-group">
            <p class="list-category-label"><?php echo sl_type_label('article', true); ?></p>
        <?php endif; ?>

        <div class="articles-grid">
            <?php foreach ($articles as $article): ?>
                <?php echo render_article_card($article); ?>
            <?php endforeach; ?>
        </div>

        <?php if ($list_type === 'category' || $list_type === 'tag'): ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($projects)): ?>
        <?php if ($list_type === 'category' || $list_type === 'tag'): ?>
        <div class="list-category-group" style="margin-top:3rem;">
            <p class="list-category-label"><?php echo sl_type_label('project', true); ?></p>
        <?php endif; ?>

        <div class="projects-grid">
            <?php foreach ($projects as $project): ?>
                <?php echo render_project_card($project); ?>
            <?php endforeach; ?>
        </div>

        <?php if ($list_type === 'category' || $list_type === 'tag'): ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>

</div>
