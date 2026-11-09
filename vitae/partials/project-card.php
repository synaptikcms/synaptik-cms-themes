<?php
/*
 * Vitae Theme — partials/project-card.php
 *
 * Variables injected by render_project_card() in tf-cards.php:
 *   $project       array   Project index data
 *   $project_link  string  Fully-resolved URL (category path included) — use this, never recalculate
 *   $card_class    string  Pre-computed CSS class
 */
$hasImage = !empty($project['image']);
?>
<article class="vt-project-card vt-reveal" style="--vt-card-i:<?php echo (int)($i ?? 0); ?>">
    <?php if ($hasImage): ?>
    <a href="<?php echo $project_link; ?>" class="vt-card-img-wrap" tabindex="-1" aria-hidden="true">
        <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>"
             alt="<?php echo htmlspecialchars($project['title']); ?>" loading="lazy" class="vt-card-img">
        <div class="vt-card-overlay" aria-hidden="true"></div>
    </a>
    <?php endif; ?>
    <div class="vt-card-body">
        <?php if (!empty($project['category'])): ?>
        <span class="vt-chip vt-chip--sm"><?php echo htmlspecialchars($project['category']); ?></span>
        <?php endif; ?>
        <h3 class="vt-card-title">
            <a href="<?php echo $project_link; ?>"><?php echo htmlspecialchars($project['title']); ?></a>
        </h3>
        <?php if (!empty($project['description'])): ?>
        <p class="vt-card-desc"><?php echo htmlspecialchars(mb_substr(strip_tags($project['description']), 0, 110)); ?>…</p>
        <?php endif; ?>
        <a href="<?php echo $project_link; ?>" class="vt-card-link" aria-label="<?php echo htmlspecialchars($project['title']); ?>">
            <?php echo __t('view_project'); ?>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>
</article>
