<?php
/**
 * Vanta Theme — partials/article-card.php
 *
 * Grid card for article listings (homepage and list pages).
 *
 * Available variables:
 * @var array  $article      Article index data (title, slug, date, tags, image, summary, category)
 * @var string $article_link Fully-qualified URL to the article
 */
?>
<a href="<?php echo $article_link; ?>" class="article-card">

    <?php if (!empty($article['image'])): ?>
    <div class="card-image">
        <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>"
             alt="<?php echo htmlspecialchars($article['title']); ?>"
             loading="lazy">
    </div>
    <?php endif; ?>

    <div class="card-meta">
        <?php if (!empty($article['category'])): ?>
        <span class="card-category"><?php echo htmlspecialchars($article['category']); ?></span>
        <?php endif; ?>
        <?php if (!empty($article['date']) && !empty($article['show_date'])): ?>
        <span class="card-date"><?php echo htmlspecialchars(format_date($article['date'])); ?></span>
        <?php endif; ?>
    </div>

    <h3 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h3>

    <?php
    $summary = get_article_summary($article, 120);
    if ($summary):
    ?>
    <p class="card-excerpt"><?php echo $summary; ?></p>
    <?php endif; ?>

    <span class="card-link">
        <?php echo __t('read_more') ?: 'Read more'; ?>
        <svg class="card-link-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             aria-hidden="true">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
        </svg>
    </span>

</a>
