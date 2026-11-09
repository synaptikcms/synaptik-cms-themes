<?php
/**
 * Portfolio Theme — partials/article-card.php
 *
 * @var array  $article
 * @var string $article_link
 */
static $cardIndex = 0;
$accentCls = function_exists('portfolio_accent_class') ? portfolio_accent_class($cardIndex) : '';
$cardIndex++;
?>
<article class="scroll-card <?php echo $accentCls; ?>" data-reveal>
    <?php if (!empty($article['image'])): ?>
    <div class="scroll-card-img">
        <a href="<?php echo $article_link; ?>" tabindex="-1" aria-hidden="true">
            <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>"
                 alt="<?php echo htmlspecialchars($article['title']); ?>"
                 loading="lazy">
        </a>
    </div>
    <?php endif; ?>
    <div class="scroll-card-body">
        <?php if (!empty($article['tags']) && is_array($article['tags'])): ?>
        <div class="scroll-card-tags">
            <?php $__tagStore = sl_load_tags(); foreach (array_slice($article['tags'], 0, 2) as $tag):
                $__tagSlug = sanitizeSlug($tag);
                if ($__tagSlug === '') continue;
                $__tagName = $__tagStore[$__tagSlug]['name'] ?? $tag;
            ?>
            <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . $__tagSlug . '/'; ?>"
               class="tag-pill"><?php echo htmlspecialchars($__tagName); ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <h3><a href="<?php echo $article_link; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h3>
        <?php if (!empty($article['date']) && !empty($article['show_date'])): ?>
        <time class="card-date"><?php echo format_date($article['date']); ?></time>
        <?php endif; ?>
        <p><?php echo get_article_summary($article, 120); ?></p>
        <a href="<?php echo $article_link; ?>" class="read-more-link"><?php echo __t('read_more'); ?> &rarr;</a>
    </div>
</article>
