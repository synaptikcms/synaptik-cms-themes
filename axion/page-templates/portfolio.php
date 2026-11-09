<?php
/* Template Name: Portfolio */
/**
 * Axion Theme — page-template: Portfolio
 *
 * Bento-style portfolio:
 *  - Vertical hero with massive serif-less title and side label.
 *  - Asymmetric bento grid for projects: first is large landscape (2-col),
 *    next two are square, then alternating rhythm.
 *  - Filter strip by category if categories exist among projects.
 *
 * @var array $item
 */
$settings = loadConfig();

$projects = sl_load_index('project');
if (!empty($projects)) {
  usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
}

$perPage = (int)($settings['projects_per_page'] ?? 9);
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$total = count($projects);
$totalPages = max(1, (int)ceil($total / $perPage));
$subset = array_slice($projects, ($currentPage - 1) * $perPage, $perPage);

$cats = [];
foreach ($projects as $p) {
  if (!empty($p['category']) && !in_array($p['category'], $cats, true)) $cats[] = $p['category'];
}
?>

<section class="ax-pf">
  <header class="ax-pf-head" data-reveal>
    <div class="ax-pf-head-row">
      <span class="ax-eyebrow"><?php echo htmlspecialchars($item['category'] ?: __t('portfolio_hero_eyebrow', 'Creative Portfolio')); ?></span>
      <span class="ax-pf-count"><?php echo sprintf('%d %s', $total, sl_type_label('project', true)); ?></span>
    </div>
    <h1 class="ax-pf-title"><?php echo htmlspecialchars($item['title']); ?></h1>
    <?php if (!empty($item['meta_description'])): ?>
    <p class="ax-pf-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
    <?php endif; ?>
  </header>

  <?php if (!empty($cats) && count($cats) > 1): ?>
  <nav class="ax-pf-filters" data-reveal>
    <a href="<?php echo cleanUrl('project'); ?>" class="ax-pf-filter is-active"><?php echo __t('all', 'All'); ?></a>
    <?php foreach ($cats as $c): ?>
    <a href="<?php echo getBaseUrl() . url_slug('category') . '/' . sanitizeSlug($c) . '/'; ?>" class="ax-pf-filter"><?php echo htmlspecialchars($c); ?></a>
    <?php endforeach; ?>
  </nav>
  <?php endif; ?>

  <?php if (empty($subset)): ?>
  <p class="ax-list-empty"><?php echo sprintf(__t('no_type_found'), 'project'); ?></p>
  <?php else: ?>
  <div class="ax-pf-bento">
    <?php foreach ($subset as $idx => $project):
      $slug = !empty($project['custom_slug']) ? $project['custom_slug'] : $project['slug'];
      $cat  = !empty($project['category']) ? sanitizeSlug($project['category']) : null;
      $url  = cleanUrl('project', $slug, null, $cat);
      // Bento sizing pattern: lg, sm, sm, md, sm, sm, md, sm…
      $mod = $idx % 7;
      $size = 'ax-pf-cell--sm';
      if ($mod === 0) $size = 'ax-pf-cell--lg';
      elseif ($mod === 3 || $mod === 6) $size = 'ax-pf-cell--md';
    ?>
    <a href="<?php echo $url; ?>" class="ax-pf-cell <?php echo $size; ?>">
      <?php if (!empty($project['image'])): ?>
      <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" loading="lazy" decoding="async">
      <?php endif; ?>
      <div class="ax-pf-cell-meta">
        <?php if (!empty($project['category'])): ?>
        <span class="ax-pf-cell-cat"><?php echo htmlspecialchars($project['category']); ?></span>
        <?php endif; ?>
        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
        <?php if (!empty($project['description'])): ?>
        <p><?php echo htmlspecialchars($project['description']); ?></p>
        <?php endif; ?>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ($totalPages > 1):
    // Build an absolute URL anchored to this page's own slug. A relative
    // "?page=N" href resolves against the URL's parent directory when the
    // current URL has no trailing slash (e.g. /portfolio-template-2), which
    // sent every pagination click back to the homepage instead of staying
    // on this page.
    $pageSlug = !empty($item['custom_slug']) ? $item['custom_slug'] : $item['slug'];
    $pageCat  = !empty($item['category']) ? sanitizeSlug($item['category']) : null;
    $pageUrl  = cleanUrl('page', $pageSlug, null, $pageCat);
  ?>
  <div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <?php if ($i == $currentPage): ?>
      <span class="current-page"><?php echo $i; ?></span>
      <?php else: ?>
      <a href="<?php echo $pageUrl; ?>?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>
  <?php endif; ?>

  <?php if (!empty(trim(strip_tags($item['content'] ?? '')))): ?>
  <div class="ax-prose ax-prose--narrow ax-pf-prose" data-reveal>
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>
  <?php endif; ?>
</section>
