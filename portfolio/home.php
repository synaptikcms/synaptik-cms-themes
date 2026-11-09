<?php
/**
 * Portfolio Theme — home.php
 * Homepage template with hero section and bento-grid content display.
 */

$articles = $data['article'] ?? [];
$projects = $data['project'] ?? [];

// Sort by date desc
usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));

$showArticles = !empty($settings['show_articles_on_homepage']) && !empty($articles);
$showProjects = !empty($settings['show_projects_on_homepage']) && !empty($projects);
?>

<section class="hero" aria-label="Hero">
    <div class="hero-inner">
        <div class="hero-text">
            <p class="hero-eyebrow"><?php echo __t('portfolio_hero_eyebrow'); ?></p>
            <h1 class="hero-title">
                <?php echo htmlspecialchars($settings['site_title']); ?>
            </h1>
            <?php if (!empty($settings['site_description'])): ?>
            <p class="hero-desc"><?php echo htmlspecialchars($settings['site_description']); ?></p>
            <?php endif; ?>
            <div class="hero-cta">
                <?php if ($showProjects): ?>
                <a href="<?php echo cleanUrl('projects'); ?>" class="btn btn-primary">
                    <?php echo sprintf(__t('view_all_projects', 'View All %s'), sl_type_label('project', true)); ?>
                </a>
                <?php endif; ?>
                <?php if ($showArticles): ?>
                <a href="<?php echo cleanUrl('articles'); ?>" class="btn btn-ghost">
                    <?php echo __t('latest_work'); ?> &rarr;
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="hero-marquee" aria-hidden="true">
            <div class="marquee-track">
                <span>Design</span><span>·</span>
                <span>Art</span><span>·</span>
                <span>Photography</span><span>·</span>
                <span>Motion</span><span>·</span>
                <span>Illustration</span><span>·</span>
                <span>Branding</span><span>·</span>
                <span>Design</span><span>·</span>
                <span>Art</span><span>·</span>
                <span>Photography</span><span>·</span>
                <span>Motion</span><span>·</span>
                <span>Illustration</span><span>·</span>
                <span>Branding</span><span>·</span>
            </div>
        </div>
    </div>
</section>

<?php if ($showProjects): ?>
<?php
$featuredProjects = array_filter($projects, fn($p) => !empty($p['show_on_homepage']));
if (empty($featuredProjects)) {
    $featuredProjects = array_slice($projects, 0, 9);
}
$featuredProjects = array_values(array_slice($featuredProjects, 0, 9));
?>
<section class="section-projects" aria-label="<?php echo sprintf(__t('featured_projects', 'Featured %s'), sl_type_label('project', true)); ?>">
    <div class="section-header">
        <h2 class="section-title"><?php echo sprintf(__t('featured_projects', 'Featured %s'), sl_type_label('project', true)); ?></h2>
        <a href="<?php echo cleanUrl('projects'); ?>" class="section-more"><?php echo __t('view_all'); ?> &rarr;</a>
    </div>
    <div class="bento-grid" id="bento-grid">
        <?php foreach ($featuredProjects as $i => $project):
            $cat        = !empty($project['category']) ? sanitizeSlug($project['category']) : null;
            $link       = cleanUrl('project', sl_effective_slug($project), null, $cat);
            $accentCls  = function_exists('portfolio_accent_class') ? portfolio_accent_class($i) : '';
            $bentoCls   = function_exists('portfolio_bento_size')   ? portfolio_bento_size($i)   : 'bento-md';
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
                <h3 class="bento-title"><a href="<?php echo $link; ?>"><?php echo htmlspecialchars($project['title']); ?></a></h3>
                <?php if (!empty($project['description'])): ?>
                <p class="bento-desc"><?php echo htmlspecialchars(mb_strimwidth(strip_tags($project['description']), 0, 100, '…')); ?></p>
                <?php endif; ?>
                <a href="<?php echo $link; ?>" class="bento-link" aria-label="<?php echo htmlspecialchars($project['title']); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                </a>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php if ($showArticles): ?>
<?php
$perPage  = (int)($settings['articles_per_page'] ?? 6);
$featured = array_filter($articles, fn($a) => !empty($a['show_on_homepage']));
if (empty($featured)) {
    $featured = array_slice($articles, 0, $perPage);
}
$featured = array_values(array_slice($featured, 0, $perPage));
?>
<section class="section-articles" aria-label="<?php echo __t('latest_work'); ?>">
    <div class="section-header">
        <h2 class="section-title"><?php echo __t('latest_work'); ?></h2>
        <a href="<?php echo cleanUrl('articles'); ?>" class="section-more"><?php echo __t('view_all'); ?> &rarr;</a>
    </div>
    <div class="article-scroll-row">
        <?php foreach ($featured as $i => $article):
            $cat  = !empty($article['category']) ? sanitizeSlug($article['category']) : null;
            $link = cleanUrl('article', sl_effective_slug($article), null, $cat);
        ?>
        <article class="scroll-card" data-reveal>
            <?php if (!empty($article['image'])): ?>
            <div class="scroll-card-img">
                <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>"
                     alt="<?php echo htmlspecialchars($article['title']); ?>"
                     loading="lazy">
            </div>
            <?php endif; ?>
            <div class="scroll-card-body">
                <?php if (!empty($article['tags']) && is_array($article['tags'])): ?>
                <div class="scroll-card-tags">
                    <?php foreach (array_slice($article['tags'], 0, 2) as $tag): ?>
                    <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>" class="tag-pill"><?php echo htmlspecialchars($tag); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <h3><a href="<?php echo $link; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h3>
                <p><?php echo get_article_summary($article, 120); ?></p>
                <a href="<?php echo $link; ?>" class="read-more-link"><?php echo __t('read_more'); ?> &rarr;</a>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
