<?php
$articlesLimit = (int)($settings['articles_per_page'] ?? 9);

$recentArticles = [];
if (!empty($data['article']) && !empty($settings['show_articles_on_homepage'])) {
    $articles = $data['article'];
    usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $articles = array_filter($articles, fn($a) => !isset($a['show_on_homepage']) || $a['show_on_homepage'] === true);
    $recentArticles = array_slice(array_values($articles), 0, $articlesLimit);
}
?>
<div class="ink-home">

    <?php if (!empty($settings['site_description']) || !empty($settings['site_title'])): ?>
    <section class="ink-hero">
        <h1 class="ink-hero-title"><?php echo nl2br(htmlspecialchars($settings['site_title'] ?? '')); ?></h1>
        <?php if (!empty($settings['site_description'])): ?>
        <p class="ink-hero-desc"><?php echo htmlspecialchars($settings['site_description']); ?></p>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if (!empty($recentArticles)): ?>
    <section class="ink-articles-section" id="list">
      <div class="ink-section-header">
            <a href="<?php echo cleanUrl('articles'); ?>" class="ink-all-link"><?php echo __t('view_all') ?: 'All Articles'; ?></a>
        </div>
        <div class="ink-masonry">
            <?php foreach ($recentArticles as $article): ?>
                <?php echo render_article_card($article); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (empty($recentArticles)): ?>
    <p class="ink-empty"><?php echo __t('page_not_found_desc') ?: 'No content yet.'; ?></p>
    <?php endif; ?>

</div>
