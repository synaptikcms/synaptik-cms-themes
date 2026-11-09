<?php
/**
 * Axion Theme — partials/article-card.php
 *
 * @var array  $article
 * @var string $article_link
 */
?>
<article class="article-card ax-card">
  <?php if (!empty($article['image'])): ?>
  <a href="<?php echo $article_link; ?>" class="ax-card-media">
    <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" loading="lazy" decoding="async">
  </a>
  <?php endif; ?>
  <div class="ax-card-body">
    <div class="ax-card-meta">
      <?php if (!empty($article['category'])): ?>
      <a class="ax-card-cat" href="<?php echo getBaseUrl() . url_slug('category') . '/' . sanitizeSlug($article['category']) . '/'; ?>">
        <?php echo htmlspecialchars($article['category']); ?>
      </a>
      <?php endif; ?>
      <?php if (!empty($article['date'])): ?>
      <time datetime="<?php echo htmlspecialchars($article['date']); ?>"><?php echo htmlspecialchars(format_date($article['date'])); ?></time>
      <?php endif; ?>
    </div>
    <h3 class="ax-card-title">
      <a href="<?php echo $article_link; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
    </h3>
    <p class="ax-card-excerpt"><?php echo get_article_summary($article); ?></p>
    <a href="<?php echo $article_link; ?>" class="ax-card-link"><?php echo __t('read_more'); ?> <span aria-hidden="true">→</span></a>
  </div>
</article>
