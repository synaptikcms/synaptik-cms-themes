<?php
$heading = in_array($list_type, ['article', 'page', 'project'], true)
    ? sl_type_label($list_type, true)
    : sl_type_label($list_type, true);
?>
<div class="content-list">
    <p class="prompt-line"><span class="prompt-sign">$</span> ls <?php echo hsc($heading); ?>/</p>

    <?php if (empty($articles) && empty($projects)): ?>
    <p class="empty-state"><?php echo hsc(__t('no_content_yet') ?: 'Nothing here yet.'); ?></p>
    <?php endif; ?>

    <?php if (!empty($articles)): ?>
    <div class="file-list">
        <?php foreach ($articles as $article): ?>
            <?php echo render_article_card($article); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($projects)): ?>
    <div class="file-list">
        <?php foreach ($projects as $project): ?>
            <?php echo render_project_card($project); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
