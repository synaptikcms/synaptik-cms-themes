<?php
/**
 * Vanta Theme — partials/project-card.php
 *
 * Card for project listings.
 *
 * Available variables:
 * @var array  $project       Project index data
 * @var string $project_link  Fully-qualified URL to the project
 * @var string $card_class    Pre-computed CSS classes
 */
?>
<a href="<?php echo $project_link; ?>" class="project-card <?php echo $card_class; ?>">

    <?php if (!empty($project['image'])): ?>
    <div class="project-card-thumb">
        <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>"
             alt="<?php echo htmlspecialchars($project['title']); ?>"
             loading="lazy">
    </div>
    <?php else: ?>
    <div class="project-card-no-image">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="2" y="3" width="20" height="14" rx="2"/>
            <line x1="8" y1="21" x2="16" y2="21"/>
            <line x1="12" y1="17" x2="12" y2="21"/>
        </svg>
    </div>
    <?php endif; ?>

    <div class="project-card-body">
        <h3 class="project-card-title"><?php echo htmlspecialchars($project['title']); ?></h3>

        <?php if (!empty($project['description'])): ?>
        <p class="project-card-desc">
            <?php echo htmlspecialchars(_clean_excerpt($project['description'], 110)); ?>
        </p>
        <?php endif; ?>

        <div class="project-card-footer">
            <?php if (!empty($project['date']) && !empty($project['show_date'])): ?>
            <span class="card-date"><?php echo htmlspecialchars(format_date($project['date'])); ?></span>
            <?php else: ?>
            <span></span>
            <?php endif; ?>
            <span class="project-card-cta">
                <?php echo __t('view_project') ?: 'View project'; ?>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </span>
        </div>
    </div>

</a>
