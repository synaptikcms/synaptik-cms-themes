<?php
/**
 * Portfolio Theme — content-articles.php
 * Single article template.
 */
?>
<article class="single-article" data-type="article">

    <div class="single-hero">
        <?php if (!empty($item['image'])): ?>
        <div class="single-cover" data-parallax>
            <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>"
                 alt="<?php echo htmlspecialchars($item['title']); ?>">
            <div class="single-cover-overlay"></div>
        </div>
        <?php endif; ?>
        <div class="single-hero-text">
            <?php if (!empty($item['category'])): ?>
            <a href="<?php echo cleanUrl('category', null, null, sanitizeSlug($item['category'])); ?>"
               class="single-category"><?php echo htmlspecialchars($item['category']); ?></a>
            <?php endif; ?>
            <?php echo render_content_title($item); ?>
            <div class="single-byline">
                <?php echo render_content_date($item); ?>
                <?php if (!empty($item['tags']) && is_array($item['tags'])): ?>
                <div class="single-tags">
                    <?php foreach ($item['tags'] as $tag): ?>
                    <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>"
                       class="tag-pill"><?php echo htmlspecialchars($tag); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="single-layout">
        <div class="single-content prose" data-animate-in>
            <?php echo render_content_html($item['content'] ?? '', $item); ?>
        </div>

        <?php $cfHtml = render_item_custom_fields($item, 'article'); ?>
        <?php if ($cfHtml): ?>
        <aside class="single-sidebar" data-animate-in>
            <?php echo $cfHtml; ?>
        </aside>
        <?php endif; ?>
    </div>

    <?php echo render_related_items($item); ?>

</article>
