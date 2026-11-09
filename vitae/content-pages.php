<?php $settings = loadConfig(); $base = getBaseUrl(); ?>
<article class="vt-single">
    <div class="vt-single-inner">
        <?php if (!isset($item['show_title']) || $item['show_title']): ?>
        <h1 class="vt-single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
        <?php endif; ?>
        <?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
        <figure class="vt-hero-img">
            <img src="<?php echo $base . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy">
        </figure>
        <?php endif; ?>
        <?php $cf = render_item_custom_fields($item, 'page'); if ($cf): ?><div class="vt-custom-fields"><?php echo $cf; ?></div><?php endif; ?>
        <div class="vt-prose"><?php echo render_content_html($item['content'] ?? '', $item); ?></div>
        <?php echo render_related_items($item); ?>
    </div>
</article>
