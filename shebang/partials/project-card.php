<?php
/** @var array $project */
/** @var string $project_link */
/** @var string $card_class */
?>
<article class="<?php echo hsc($card_class); ?>">
    <?php if (!empty($project['image'])): ?>
    <a href="<?php echo $project_link; ?>" class="project-thumbnail">
        <img src="<?php echo getBaseUrl() . hsc($project['image']); ?>" alt="<?php echo hsc(!empty($project['image_alt']) ? $project['image_alt'] : $project['title']); ?>" loading="lazy">
    </a>
    <?php endif; ?>
    <div class="project-overlay">
        <h3><a href="<?php echo $project_link; ?>"><?php echo hsc($project['title']); ?></a></h3>
        <?php if (!empty($project['date']) && !empty($project['show_date'])): ?>
        <div class="project-date"><?php echo hsc(format_date($project['date'])); ?></div>
        <?php endif; ?>
        <?php if (!empty($project['tags']) && is_array($project['tags'])):
            $__tagStore = sl_load_tags();
        ?>
        <div class="project-tags">
            <?php foreach ($project['tags'] as $__tag):
                $__tagSlug = sanitizeSlug($__tag);
                if ($__tagSlug === '') continue;
                $__tagName = $__tagStore[$__tagSlug]['name'] ?? $__tag;
            ?>
            <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . $__tagSlug . '/'; ?>" class="tag-link"><?php echo hsc($__tagName); ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($project['description'])): ?>
        <div class="project-excerpt"><?php echo html_entity_decode($project['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></div>
        <?php elseif (!empty($project['meta_description'])): ?>
        <div class="project-seo-desc"><?php echo html_entity_decode($project['meta_description'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></div>
        <?php endif; ?>
        <a href="<?php echo $project_link; ?>" class="view-project"><?php echo hsc(__t('view_project', 'View project')); ?></a>
    </div>
</article>
