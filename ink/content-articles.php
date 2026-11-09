<?php
$settings = loadConfig();
$tags     = $item['tags'] ?? [];
$date     = (!empty($item['date']) && !empty($item['show_date'])) ? format_date($item['date']) : '';
?>
<article class="ink-single">
    <?php /* <a href="<?php echo cleanUrl('articles'); ?>" class="ink-back">&#8592; Articles</a> */ ?>

    <h1 class="ink-single-title"><?php echo htmlspecialchars($item['title']); ?></h1>

    <?php if ($date || !empty($tags)): ?>
    <div class="ink-single-meta">
        <?php if ($date): ?>
        <time datetime="<?php echo htmlspecialchars($item['date']); ?>"><?php echo $date; ?></time>
        <?php endif; ?>
        <?php if (!empty($tags)): ?>
        <div class="ink-single-tags">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            <?php foreach ($tags as $i => $tag): ?>
                <?php if ($i > 0): ?>, <?php endif; ?>
                <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>"><?php echo htmlspecialchars($tag); ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
    <figure class="ink-featured-image">
        <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
    </figure>
    <?php endif; ?>

    <?php $cf = render_item_custom_fields($item, 'article'); if ($cf): ?>
    <div class="ink-custom-fields"><?php echo $cf; ?></div>
    <?php endif; ?>

    <div class="ink-prose">
        <?php echo render_content_html($item['content'] ?? '', $item); ?>
    </div>

    <?php echo render_related_items($item); ?>
</article>
