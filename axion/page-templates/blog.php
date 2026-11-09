<?php
/* Template Name: Blog */
/**
 * Axion Theme — page-template: Blog
 *
 * Magazine-style index:
 *  - Editorial header with date and issue label.
 *  - Hero: latest article rendered full-width with large title and excerpt.
 *  - Secondary: two next articles side by side.
 *  - Archive: standard grid for the rest, paginated.
 *
 * @var array $item
 */
$settings = loadConfig();

$articles = sl_load_index('article');
if (!empty($articles)) {
  usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
}
$total = count($articles);

$perPage = (int)($settings['articles_per_page'] ?? 9);
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$totalPages = max(1, (int)ceil(max(0, $total - 3) / $perPage));

$lead       = $currentPage === 1 ? array_slice($articles, 0, 1) : [];
$secondary  = $currentPage === 1 ? array_slice($articles, 1, 2) : [];
$start      = $currentPage === 1 ? 3 : 3 + ($currentPage - 2) * $perPage;
$rest       = array_slice($articles, $start, $perPage);

$lead_a = $lead[0] ?? null;

function _nr_url($a) {
  $slug = !empty($a['custom_slug']) ? $a['custom_slug'] : $a['slug'];
  $cat  = !empty($a['category']) ? sanitizeSlug($a['category']) : null;
  return cleanUrl('article', $slug, null, $cat);
}
?>

<section class="ax-bl">
  <header class="ax-bl-head" data-reveal>
    <div class="ax-bl-head-row">
      <span class="ax-bl-issue"><?php echo __t('the_journal', 'The Journal'); ?></span>
      <span class="ax-bl-dash" aria-hidden="true">—</span>
      <span class="ax-bl-date"><?php echo htmlspecialchars(date('F Y')); ?></span>
    </div>
    <h1 class="ax-bl-title"><?php echo htmlspecialchars($item['title']); ?></h1>
    <?php if (!empty($item['meta_description'])): ?>
    <p class="ax-bl-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
    <?php endif; ?>
  </header>

  <?php if ($lead_a): $url = _nr_url($lead_a); ?>
  <article class="ax-bl-lead" data-reveal>
    <a href="<?php echo $url; ?>" class="ax-bl-lead-media">
      <?php if (!empty($lead_a['image'])): ?>
      <img src="<?php echo getBaseUrl() . htmlspecialchars($lead_a['image']); ?>" alt="<?php echo htmlspecialchars($lead_a['title']); ?>" loading="lazy" decoding="async">
      <?php endif; ?>
    </a>
    <div class="ax-bl-lead-body">
      <div class="ax-card-meta">
        <?php if (!empty($lead_a['category'])): ?>
        <span class="ax-card-cat"><?php echo htmlspecialchars($lead_a['category']); ?></span>
        <?php endif; ?>
        <?php if (!empty($lead_a['date'])): ?>
        <time><?php echo htmlspecialchars(format_date($lead_a['date'])); ?></time>
        <?php endif; ?>
      </div>
      <h2 class="ax-bl-lead-title"><a href="<?php echo $url; ?>"><?php echo htmlspecialchars($lead_a['title']); ?></a></h2>
      <p class="ax-bl-lead-excerpt"><?php echo get_article_summary($lead_a, 220); ?></p>
      <a href="<?php echo $url; ?>" class="ax-card-link"><?php echo __t('read_more'); ?> <span aria-hidden="true">→</span></a>
    </div>
  </article>
  <?php endif; ?>

  <?php if (!empty($secondary)): ?>
  <div class="ax-bl-sec" data-reveal>
    <?php foreach ($secondary as $a): echo render_article_card($a); endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if (!empty(trim(strip_tags($item['content'] ?? '')))): ?>
  <div class="ax-bl-prose ax-prose ax-prose--narrow" data-reveal>
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>
  <?php endif; ?>

  <?php if (!empty($rest)): ?>
  <section class="ax-bl-archive">
    <header class="ax-section-head" data-reveal>
      <span class="ax-section-label"><?php echo __t('archive', 'Archive'); ?></span>
    </header>
    <div class="articles-grid">
      <?php foreach ($rest as $a): echo render_article_card($a); endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($totalPages > 1):
    // Build an absolute URL anchored to this page's own slug. A relative
    // "?page=N" href resolves against the URL's parent directory when the
    // current URL has no trailing slash (e.g. /the-journal), which sent
    // every pagination click back to the homepage instead of staying here.
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
</section>
