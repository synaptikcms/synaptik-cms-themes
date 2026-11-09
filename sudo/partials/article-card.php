<?php
/** @var array $article */
/** @var string $article_link */
$__summary = get_article_summary($article, 90);
?>
<a href="<?php echo $article_link; ?>" class="file-row">
    <span class="file-icon" aria-hidden="true">&#128196;</span>
    <span class="file-main">
        <span class="file-name"><?php echo hsc($article['title']); ?></span>
        <?php if ($__summary !== ''): ?>
        <span class="file-summary"><?php echo $__summary; ?></span>
        <?php endif; ?>
    </span>
    <?php if (!empty($article['tags']) && is_array($article['tags'])): ?>
    <span class="file-tags">
        <?php foreach ($article['tags'] as $__tag): ?>
        <span class="file-tag">#<?php echo hsc($__tag); ?></span>
        <?php endforeach; ?>
    </span>
    <?php endif; ?>
    <?php if (!empty($article['date']) && !empty($article['show_date'])): ?>
    <span class="file-date"><?php echo hsc(format_date($article['date'])); ?></span>
    <?php endif; ?>
</a>
