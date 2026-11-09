<?php
/**
 * Myelin Theme for Synaptik CMS — partials/article-card.php
 *
 * @var array  $article
 * @var string $article_link
 */
?>
<article class="article-card my-card">
  <?php if (!empty($article['image'])): ?>
  <a href="<?php echo $article_link; ?>" class="my-card-media">
    <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>"
         alt="<?php echo htmlspecialchars($article['title']); ?>"
         loading="lazy" decoding="async">
  </a>
  <?php endif; ?>
  <div class="my-card-body">
    <?php if (!empty($article['category'])): ?>
    <a class="my-card-cat" href="<?php echo getBaseUrl() . url_slug('category') . '/' . sanitizeSlug($article['category']) . '/'; ?>">
      <?php echo htmlspecialchars($article['category']); ?>
    </a>
    <?php endif; ?>
    <h3 class="my-card-title">
      <a href="<?php echo $article_link; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
    </h3>
    <p class="my-card-excerpt"><?php echo get_article_summary($article); ?></p>
    <div class="my-card-foot">
      <?php if (!empty($article['date'])): ?>
      <time datetime="<?php echo htmlspecialchars($article['date']); ?>"><?php echo htmlspecialchars(format_date($article['date'])); ?></time>
      <?php endif; ?>
      <a href="<?php echo $article_link; ?>" class="my-card-link"><?php echo __t('read_more'); ?> <span aria-hidden="true">→</span></a>
    </div>
  </div>
</article>
