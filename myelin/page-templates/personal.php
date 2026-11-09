<?php
/* Template Name: Personal */
/**
 * Myelin Theme — page-template: Personal
 *
 * Layout for about / personal landing pages. Portrait-and-text split hero,
 * narrow content column, optional latest articles strip.
 *
 * @var array $item
 */
$settings = loadConfig();
?>
<section class="my-page my-page--personal">

  <header class="my-personal-hero">
    <?php if (!empty($item['image'])): ?>
    <div class="my-personal-portrait" data-reveal>
      <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>"
           alt="<?php echo htmlspecialchars($item['title']); ?>" loading="eager" decoding="async">
    </div>
    <?php endif; ?>
    <div class="my-personal-intro" data-reveal>
      <?php if (!empty($item['category'])): ?>
      <div class="my-page-eyebrow"><?php echo htmlspecialchars($item['category']); ?></div>
      <?php endif; ?>
      <h1 class="my-page-title my-page-title--serif"><?php echo htmlspecialchars($item['title']); ?></h1>
      <?php if (!empty($item['meta_description'])): ?>
      <p class="my-page-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
      <?php endif; ?>
    </div>
  </header>

  <?php $cfHtml = render_item_custom_fields($item, 'page'); if ($cfHtml): ?>
  <div class="my-page-fields my-custom-fields" data-reveal><?php echo $cfHtml; ?></div>
  <?php endif; ?>

  <div class="my-page-body my-prose my-prose--narrow">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>

  <?php echo render_content_gallery($item); ?>

  <?php
  $articles = sl_load_index('article');
  if (!empty($articles)) {
    usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $articles = array_slice($articles, 0, 3);
  }
  if (!empty($articles)): ?>
  <section class="my-page-articles" data-reveal>
    <div class="my-section-head">
      <span class="my-section-label"><?php echo __t('latest_articles', 'Latest Articles'); ?></span>
      <a href="<?php echo cleanUrl('article'); ?>" class="my-section-link"><?php echo __t('view_all', 'View all'); ?> <span aria-hidden="true">→</span></a>
    </div>
    <div class="articles-grid">
      <?php foreach ($articles as $article): echo render_article_card($article); endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php echo render_related_items($item); ?>
</section>
