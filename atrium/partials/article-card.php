<?php
/**
 * Atrium Theme for Synaptik CMS — partials/article-card.php
 *
 * Editorial card: tall image, oversized serif title, eyebrow meta.
 * Variables: $article, $article_link
 */
$article_link = $article_link ?? '#';
?>
<article class="atrium-card">
  <a href="<?php echo $article_link; ?>" class="atrium-card-link" data-atrium-link>
    <div class="atrium-card-media">
      <?php if (!empty($article['image'])): ?>
      <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>"
           alt="<?php echo htmlspecialchars($article['title']); ?>"
           loading="lazy" decoding="async">
      <?php else: ?>
      <div class="atrium-card-placeholder" aria-hidden="true"></div>
      <?php endif; ?>
    </div>
    <div class="atrium-card-body">
      <div class="atrium-card-meta">
        <?php if (!empty($article['category'])): ?>
        <span class="atrium-card-cat"><?php echo htmlspecialchars($article['category']); ?></span>
        <?php endif; ?>
        <?php if (!empty($article['date'])): ?>
        <time class="atrium-card-date" datetime="<?php echo htmlspecialchars($article['date']); ?>"><?php echo htmlspecialchars(format_date($article['date'])); ?></time>
        <?php endif; ?>
      </div>
      <h3 class="atrium-card-title"><?php echo htmlspecialchars($article['title']); ?></h3>
      <?php $df_sum = get_article_summary($article, 140); if ($df_sum): ?>
      <p class="atrium-card-summary"><?php echo $df_sum; ?></p>
      <?php endif; ?>
      <span class="atrium-card-cta">
        <?php echo __t('read_more'); ?>
        <svg width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7h8M7 3l4 4-4 4"/></svg>
      </span>
    </div>
  </a>
</article>
