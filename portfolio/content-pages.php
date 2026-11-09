<?php
/**
 * Portfolio Theme — content-pages.php
 * Static page template.
 */
?>
<article class="single-page">
    <div class="single-hero">
        <?php if (!empty($item['image'])): ?>
        <div class="single-cover" data-parallax>
            <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>"
                 alt="<?php echo htmlspecialchars($item['title']); ?>">
            <div class="single-cover-overlay"></div>
        </div>
        <?php endif; ?>
        <div class="single-hero-text">
            <?php echo render_content_title($item); ?>
        </div>
    </div>
    <div class="single-layout">
        <div class="single-content prose" data-animate-in>
            <?php echo render_content_html($item['content'] ?? '', $item); ?>
        </div>
    </div>
</article>
