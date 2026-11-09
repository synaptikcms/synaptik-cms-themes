<li class="vt-article-row vt-reveal">
    <a href="<?php echo $article_link; ?>" class="vt-article-row-inner">
        <div class="vt-article-row-meta">
            <?php if (!empty($article['date'])): ?>
            <time datetime="<?php echo htmlspecialchars($article['date']); ?>"><?php echo htmlspecialchars(format_date($article['date'])); ?></time>
            <?php endif; ?>
            <?php if (!empty($article['category'])): ?>
            <span class="vt-chip vt-chip--sm"><?php echo htmlspecialchars($article['category']); ?></span>
            <?php endif; ?>
        </div>
        <h3 class="vt-article-row-title"><?php echo htmlspecialchars($article['title']); ?></h3>
        <?php $sum = get_article_summary($article, 110); if ($sum): ?>
        <p class="vt-article-row-sum"><?php echo $sum; ?></p>
        <?php endif; ?>
        <span class="vt-article-row-arrow">
            <?php echo __t('vitae_read_more'); ?>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
    </a>
    <?php if (!empty($article['image'])): ?>
    <div class="vt-article-row-thumb" aria-hidden="true">
        <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>" alt="" loading="lazy">
    </div>
    <?php endif; ?>
</li>
