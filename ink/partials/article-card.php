<?php
/**
 * ink Theme — partials/article-card.php
 *
 * Card without image: title, date, tags, excerpt, circled plus read-more.
 *
 * @var array  $article      Article index data
 * @var string $article_link Full article URL
 */
$summary = get_article_summary($article, 200);
$tags    = $article['tags'] ?? [];
$date    = !empty($article['date']) ? format_date($article['date']) : '';
?>
<article class="ink-card">
    <header class="ink-card-header">
        <h2 class="ink-card-title">
            <a href="<?php echo $article_link; ?>"><?php echo htmlspecialchars($article['title']); ?></a>
        </h2>
        <div class="ink-card-meta">
            <?php if ($date): ?>
            <time class="ink-card-date" datetime="<?php echo htmlspecialchars($article['date']); ?>"><?php echo $date; ?></time>
            <?php endif; ?>
            <?php if (!empty($tags)): ?>
            <div class="ink-card-tags">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <?php foreach ($tags as $i => $tag): ?>
                    <?php if ($i > 0): ?> <?php endif; ?>
                    <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>"><?php echo htmlspecialchars($tag); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <?php if ($summary): ?>
    <p class="ink-card-summary"><?php echo $summary; ?></p>
    <?php endif; ?>
    <a href="<?php echo $article_link; ?>" class="ink-card-readmore" aria-label="<?php echo __t('read_more') . ': ' . htmlspecialchars($article['title']); ?>">
        <span class="ink-card-plus" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </span>
        <?php echo __t('read_more') ?: 'Read more'; ?>
    </a>
</article>
