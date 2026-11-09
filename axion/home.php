<?php
/**
 * Axion Theme for Synaptik CMS — home.php
 *
 * Editorial homepage layout (Synaptik Core inspired):
 *   1. Hero: eyebrow, oversized left-aligned headline, lede, badge.
 *   2. Showcase block: large featured visual surfaced from latest article/project.
 *   3. Manifesto: split block (label + statement).
 *   4. Capabilities: three-column principles strip.
 *   5. Feature blocks: alternating left/right sections from the latest articles.
 *   6. Projects bento: asymmetric featured projects grid.
 *   7. Closer band: oversized CTA call to action.
 */

$articles = !empty($data['article']) ? $data['article'] : [];
usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
$articles = array_values(array_filter($articles, fn($a) => !isset($a['show_on_homepage']) || $a['show_on_homepage'] === true));

$projects = !empty($data['project']) ? $data['project'] : [];
usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
$projects = array_values(array_filter($projects, fn($p) => !isset($p['show_on_homepage']) || $p['show_on_homepage'] === true));

$hero_visual = '';
foreach (array_merge($articles, $projects) as $i) {
  if (!empty($i['image'])) { $hero_visual = $i['image']; break; }
}

$articlesPerPage = (int)($settings['articles_per_page'] ?? 6);
$currentPage     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$totalArticles   = count($articles);
$totalPages      = max(1, (int)ceil($totalArticles / $articlesPerPage));
$showArticles    = !empty($settings['show_articles_on_homepage']);
$showProjects    = !empty($settings['show_projects_on_homepage']);
?>

<!-- ===== HERO ===== -->
<section class="ax-hero">
  <div class="ax-hero-inner">
    <span class="ax-eyebrow" data-reveal><?php echo htmlspecialchars(strtoupper($settings['site_title'] ?? 'Home')); ?></span>
    <h1 class="ax-hero-title" data-reveal><?php echo htmlspecialchars($settings['site_description'] ?: $settings['site_title']); ?></h1>
    <p class="ax-hero-lede" data-reveal>
      <?php echo __t('hero_lede_default', 'Built on a flat-file foundation, designed for clarity, shipped without a database. Every page, every article, every project — written once, served fast, owned entirely.'); ?>
    </p>
    <div class="ax-hero-actions" data-reveal>
      <a href="<?php echo cleanUrl('article'); ?>" class="ax-btn ax-btn-primary"><?php echo sprintf(__t('explore_articles', 'Explore %s'), sl_type_label('article', true)); ?></a>
      <a href="<?php echo cleanUrl('project'); ?>" class="ax-btn ax-btn-ghost"><?php echo sprintf(__t('view_projects', 'View %s'), sl_type_label('project', true)); ?> <span aria-hidden="true">→</span></a>
    </div>
    <div class="ax-hero-badge" data-reveal>
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
      </svg>
      <span><?php echo __t('hero_badge', 'Open Source · MIT'); ?></span>
    </div>
  </div>
</section>

<!-- ===== SHOWCASE VISUAL ===== -->
<?php if ($hero_visual): ?>
<!-- <section class="ax-showcase" data-reveal>
  <div class="ax-showcase-frame">
    <img src="<?php echo getBaseUrl() . htmlspecialchars($hero_visual); ?>" alt="" loading="lazy" decoding="async">
  </div>
</section>
<?php endif; ?>
 -->
 
<!-- ===== FEATURED ARTICLES — alternating blocks ===== -->
<?php if ($showArticles && !empty($articles)):
  $subset = array_slice($articles, ($currentPage - 1) * $articlesPerPage, $articlesPerPage);
  $featured = array_slice($subset, 0, 3);
  $rest     = array_slice($subset, 3);
?>
<section class="ax-features">
  <div class="ax-features-inner">
    <header class="ax-section-head" data-reveal>
      <span class="ax-section-label"><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></span>
      <a href="<?php echo cleanUrl('article'); ?>" class="ax-section-link"><?php echo __t('view_all', 'View all'); ?> <span aria-hidden="true">→</span></a>
    </header>

    <?php foreach ($featured as $i => $article):
      $slug = !empty($article['custom_slug']) ? $article['custom_slug'] : $article['slug'];
      $cat  = !empty($article['category']) ? sanitizeSlug($article['category']) : null;
      $url  = cleanUrl('article', $slug, null, $cat);
    ?>
    <article class="ax-feature <?php echo $i % 2 ? 'ax-feature--reverse' : ''; ?>" data-reveal>
      <div class="ax-feature-media">
        <?php if (!empty($article['image'])): ?>
        <a href="<?php echo $url; ?>">
          <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" loading="lazy" decoding="async">
        </a>
        <?php else: ?>
        <a href="<?php echo $url; ?>" class="ax-feature-placeholder" aria-hidden="true">
          <span><?php echo htmlspecialchars(substr($article['title'], 0, 1)); ?></span>
        </a>
        <?php endif; ?>
      </div>
      <div class="ax-feature-body">
        <span class="ax-feature-idx">No. <?php echo str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT); ?></span>
        <?php if (!empty($article['category'])): ?>
        <span class="ax-feature-cat"><?php echo htmlspecialchars($article['category']); ?></span>
        <?php endif; ?>
        <h3 class="ax-feature-title">
          <a href="<?php echo $url; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
        </h3>
        <p class="ax-feature-excerpt"><?php echo get_article_summary($article, 180); ?></p>
        <div class="ax-feature-foot">
          <?php if (!empty($article['date'])): ?>
          <time datetime="<?php echo htmlspecialchars($article['date']); ?>"><?php echo htmlspecialchars(format_date($article['date'])); ?></time>
          <?php endif; ?>
          <a href="<?php echo $url; ?>" class="ax-feature-link"><?php echo __t('read_more'); ?> <span aria-hidden="true">→</span></a>
        </div>
      </div>
    </article>
    <?php endforeach; ?>

    <?php if (!empty($rest)): ?>
    <div class="articles-grid ax-rest-grid">
      <?php foreach ($rest as $a): echo render_article_card($a); endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $currentPage): ?>
        <span class="current-page"><?php echo $i; ?></span>
        <?php else: ?>
        <a href="<?php echo cleanUrl('home'); ?>?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ===== PROJECTS BENTO ===== -->
<?php if ($showProjects && !empty($projects)):
  $perPage  = (int)($settings['projects_per_page'] ?? 5);
  $featured = array_slice($projects, 0, $perPage);
?>
<section class="ax-bento">
  <div class="ax-bento-inner">
    <header class="ax-section-head" data-reveal>
      <span class="ax-section-label"><?php echo sprintf(__t('featured_projects', 'Featured %s'), sl_type_label('project', true)); ?></span>
      <a href="<?php echo cleanUrl('project'); ?>" class="ax-section-link"><?php echo sprintf(__t('view_all_projects', 'View All %s'), sl_type_label('project', true)); ?> <span aria-hidden="true">→</span></a>
    </header>
    <div class="ax-bento-grid">
      <?php foreach ($featured as $idx => $project):
        $slug = !empty($project['custom_slug']) ? $project['custom_slug'] : $project['slug'];
        $cat  = !empty($project['category']) ? sanitizeSlug($project['category']) : null;
        $url  = cleanUrl('project', $slug, null, $cat);
        $size = ($idx === 0) ? 'ax-bento--lg' : (($idx === 1 || $idx === 4) ? 'ax-bento--md' : 'ax-bento--sm');
      ?>
      <a href="<?php echo $url; ?>" class="ax-bento-cell <?php echo $size; ?>">
        <?php if (!empty($project['image'])): ?>
        <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" loading="lazy" decoding="async">
        <?php endif; ?>
        <div class="ax-bento-meta">
          <h4><?php echo htmlspecialchars($project['title']); ?></h4>
          <?php if (!empty($project['description'])): ?>
          <p><?php echo htmlspecialchars($project['description']); ?></p>
          <?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ===== CLOSER BAND ===== -->
<section class="ax-closer">
  <div class="ax-closer-inner" data-reveal>
    <h2 class="ax-closer-title">
      <?php echo __t('closer_title', 'Make it permanent.'); ?>
    </h2>
    <p class="ax-closer-sub">
      <?php echo __t('closer_sub', 'Stop rebuilding. Start compounding.'); ?>
    </p>
    <a href="<?php echo cleanUrl('article'); ?>" class="ax-btn ax-btn-primary ax-btn-lg"><?php echo __t('get_started', 'Get started'); ?> <span aria-hidden="true">→</span></a>
  </div>
</section>
