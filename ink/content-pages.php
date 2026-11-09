<article class="ink-single">
    <?php if (!isset($item['show_title']) || $item['show_title']): ?>
    <h1 class="ink-single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
    <?php endif; ?>

    <?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
    <figure class="ink-featured-image">
        <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
    </figure>
    <?php endif; ?>

    <?php $cf = render_item_custom_fields($item, 'page'); if ($cf): ?>
    <div class="ink-custom-fields"><?php echo $cf; ?></div>
    <?php endif; ?>

    <div class="ink-prose">
        <?php echo render_content_html($item['content'] ?? '', $item); ?>
    </div>
</article>
