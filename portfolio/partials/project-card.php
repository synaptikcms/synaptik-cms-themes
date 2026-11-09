<?php
/**
 * Portfolio Theme — partials/project-card.php
 *
 * @var array  $project
 * @var string $project_link
 * @var string $card_class
 */
static $projIndex = 0;
$accentCls = function_exists('portfolio_accent_class') ? portfolio_accent_class($projIndex) : '';
$bentoCls  = function_exists('portfolio_bento_size')   ? portfolio_bento_size($projIndex)   : 'bento-md';
$projIndex++;
?>
<article class="bento-card <?php echo $bentoCls . ' ' . $accentCls; ?>" data-reveal>
    <?php if (!empty($project['image'])): ?>
    <div class="bento-img">
        <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>"
             alt="<?php echo htmlspecialchars($project['title']); ?>"
             loading="lazy">
    </div>
    <?php endif; ?>
    <div class="bento-body">
        <div class="bento-meta">
            <?php if (!empty($project['category'])): ?>
            <span class="bento-cat"><?php echo htmlspecialchars($project['category']); ?></span>
            <?php endif; ?>
            <?php if (!empty($project['date']) && !empty($project['show_date'])): ?>
            <span class="bento-date"><?php echo format_date($project['date']); ?></span>
            <?php endif; ?>
        </div>
        <h3 class="bento-title"><a href="<?php echo $project_link; ?>"><?php echo htmlspecialchars($project['title']); ?></a></h3>
        <?php if (!empty($project['description'])): ?>
        <p class="bento-desc"><?php echo htmlspecialchars(mb_strimwidth(strip_tags($project['description']), 0, 100, '…')); ?></p>
        <?php endif; ?>
        <a href="<?php echo $project_link; ?>" class="bento-link" aria-label="<?php echo htmlspecialchars($project['title']); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
        </a>
    </div>
</article>
