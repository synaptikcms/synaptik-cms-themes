<?php
$heading = in_array($list_type, ['article', 'page', 'project'], true)
    ? sl_type_label($list_type, true)
    : sl_type_label($list_type, true);
?>
<div class="dispatch-container">
<div class="content-list">
    <h1 class="list-heading"><?php echo hsc($heading); ?></h1>

    <?php if (empty($articles) && empty($projects)): ?>
    <p class="empty-state"><?php echo hsc(__t('no_content_yet') ?: 'Nothing here yet.'); ?></p>
    <?php endif; ?>

    <?php if (!empty($articles)): ?>
        <?php echo dispatch_render_timeline($articles); ?>
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
