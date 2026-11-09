<?php
/**
 * Ink Theme — partials/project-card.php
 *
 * Project card styled like article cards, with optional featured image on top.
 *
 * @var array  $project      Project index data
 * @var string $project_link Full project URL
 */
$tags = $project['tags'] ?? [];
$date = !empty($project['date']) ? format_date($project['date']) : '';
$desc = $project['description'] ?? '';
?>
<article class="ink-card ink-project-card">
    <?php if (!empty($project['image'])): ?>
    <div class="ink-project-card-image">
        <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>"
             alt="<?php echo htmlspecialchars($project['title']); ?>">
    </div>
    <?php endif; ?>
    <header class="ink-card-header">
        <h2 class="ink-card-title">
            <a href="<?php echo $project_link; ?>"><?php echo htmlspecialchars($project['title']); ?></a>
        </h2>
        <div class="ink-card-meta">
            <?php if ($date): ?>
            <time class="ink-card-date" datetime="<?php echo htmlspecialchars($project['date']); ?>"><?php echo $date; ?></time>
            <?php endif; ?>
            <?php if (!empty($tags)): ?>
            <div class="ink-card-tags">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <?php foreach ($tags as $i => $tag): ?>
                    <?php if ($i > 0): ?>, <?php endif; ?>
                    <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>"><?php echo htmlspecialchars($tag); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <?php if ($desc): ?>
    <p class="ink-card-summary"><?php echo htmlspecialchars($desc); ?></p>
    <?php endif; ?>
    <a href="<?php echo $project_link; ?>" class="ink-card-readmore" aria-label="<?php echo (__t('view_project') ?: 'View project') . ': ' . htmlspecialchars($project['title']); ?>">
        <span class="ink-card-plus" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </span>
        <?php echo __t('view_project') ?: 'View project'; ?>
    </a>
</article>
