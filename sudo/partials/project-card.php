<?php
/** @var array $project */
/** @var string $project_link */
?>
<a href="<?php echo $project_link; ?>" class="file-row">
    <span class="file-icon" aria-hidden="true">&#128193;</span>
    <span class="file-main">
        <span class="file-name"><?php echo hsc($project['title']); ?></span>
        <?php if (!empty($project['description'])): ?>
        <span class="file-summary"><?php echo html_entity_decode($project['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></span>
        <?php endif; ?>
    </span>
    <?php if (!empty($project['tags']) && is_array($project['tags'])): ?>
    <span class="file-tags">
        <?php foreach ($project['tags'] as $__tag): ?>
        <span class="file-tag">#<?php echo hsc($__tag); ?></span>
        <?php endforeach; ?>
    </span>
    <?php endif; ?>
    <?php if (!empty($project['date']) && !empty($project['show_date'])): ?>
    <span class="file-date"><?php echo hsc(format_date($project['date'])); ?></span>
    <?php endif; ?>
</a>
