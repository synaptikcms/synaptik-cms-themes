<?php
/**
 * Prism Theme for Synaptik CMS — partials/article-card.php
 * Horizontal flat card with cycling color accent strip.
 * Variables: $article, $article_link
 */
$article_link = $article_link ?? '#';
?>
<article class="article-card">
  <a href="<?php echo $article_link; ?>" class="article-card-media" tabindex="-1" aria-hidden="true">
    <?php if (!empty($article['image'])): ?>
    <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>"
         alt="<?php echo htmlspecialchars($article['title']); ?>"
         loading="lazy">
    <?php else: ?>
    <div class="article-card-placeholder" aria-hidden="true"></div>
    <?php endif; ?>
  </a>
  <div class="article-card-body">
    <div class="article-card-meta">
      <?php if (!empty($article['category'])): ?>
      <a href="<?php echo getBaseUrl() . url_slug('category') . '/' . sanitizeSlug($article['category']) . '/'; ?>" class="category-badge">
        <?php echo htmlspecialchars($article['category']); ?>
      </a>
      <?php endif; ?>
      <?php if (!empty($article['date']) && !empty($article['show_date'])): ?>
      <time class="article-date"><?php
        $s = loadConfig();
        echo htmlspecialchars(date($s['date_format'] ?? 'Y-m-d', strtotime($article['date'])));
      ?></time>
      <?php endif; ?>
    </div>
    <h3><a href="<?php echo $article_link; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h3>
    <?php $summary = get_article_summary($article); if ($summary): ?>
    <p class="article-summary"><?php echo $summary; ?></p>
    <?php endif; ?>
    <div class="article-card-footer">
      <?php if (!empty($article['tags']) && is_array($article['tags'])): ?>
      <div class="article-tags">
        <?php $__tagStore = sl_load_tags(); foreach (array_slice($article['tags'], 0, 3) as $tag):
            $__tagSlug = sanitizeSlug($tag);
            if ($__tagSlug === '') continue;
            $__tagName = $__tagStore[$__tagSlug]['name'] ?? $tag;
        ?>
        <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . $__tagSlug . '/'; ?>" class="tag-link">
          <?php echo htmlspecialchars($__tagName); ?>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <a href="<?php echo $article_link; ?>" class="read-more"><?php echo __t('read_more'); ?> →</a>
    </div>
  </div>
</article>
