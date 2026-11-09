<?php
/* Template Name: Blog */
/**
 * Myelin Theme — page-template: Blog
 *
 * Landing page for a blog: optional intro block, full grid of all published articles
 * with pagination. Intended to be used on a static page like /blog/.
 *
 * @var array $item
 */
$settings = loadConfig();

$articles = sl_load_index('article');
if (!empty($articles)) {
  usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
}

$perPage = (int)($settings['articles_per_page'] ?? 9);
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$total = count($articles);
$totalPages = max(1, (int)ceil($total / $perPage));
$subset = array_slice($articles, ($currentPage - 1) * $perPage, $perPage);
?>
<section class="my-page my-page--blog">

  <header class="my-page-hero my-page-hero--center" data-reveal>
    <?php if (!empty($item['category'])): ?>
    <div class="my-page-eyebrow"><?php echo htmlspecialchars($item['category']); ?></div>
    <?php endif; ?>
    <h1 class="my-page-title"><?php echo htmlspecialchars($item['title']); ?></h1>
    <?php if (!empty($item['meta_description'])): ?>
    <p class="my-page-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
    <?php endif; ?>
  </header>

  <?php if (!empty(trim(strip_tags($item['content'] ?? '')))): ?>
  <div class="my-page-body my-prose my-prose--narrow">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>
  <?php endif; ?>

  <div class="my-page-grid" data-reveal>
    <?php if (empty($subset)): ?>
    <p class="my-list-empty"><?php echo sprintf(__t('no_type_found'), 'article'); ?></p>
    <?php else: ?>
    <div class="articles-grid">
      <?php foreach ($subset as $article): echo render_article_card($article); endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

  <?php if ($totalPages > 1): ?>
  <div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <?php if ($i == $currentPage): ?>
      <span class="current-page"><?php echo $i; ?></span>
      <?php else: ?>
      <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>
  <?php endif; ?>
</section>
