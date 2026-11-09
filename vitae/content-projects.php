<?php $settings = loadConfig(); $base = getBaseUrl(); ?>
<article class="vt-single">
    <div class="vt-single-inner">
        <a href="<?php echo cleanUrl('projects'); ?>" class="vt-back">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            <?php echo sl_type_label('project', true); ?>
        </a>
        <?php if (!empty($item['category'])): ?>
        <div class="vt-single-eyebrow">
            <a href="<?php echo $base . url_slug('category') . '/' . sanitizeSlug($item['category']) . '/'; ?>" class="vt-chip"><?php echo htmlspecialchars($item['category']); ?></a>
        </div>
        <?php endif; ?>
        <?php if (!isset($item['show_title']) || $item['show_title']): ?>
        <h1 class="vt-single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
        <?php endif; ?>
        <?php if ((!empty($item['date']) && !empty($item['show_date'])) || !empty($item['tags'])): ?>
        <div class="vt-single-meta">
            <?php if (!empty($item['date']) && !empty($item['show_date'])): ?>
            <time datetime="<?php echo htmlspecialchars($item['date']); ?>"><?php echo htmlspecialchars(format_date($item['date'])); ?></time>
            <?php endif; ?>
            <?php if (!empty($item['tags']) && is_array($item['tags'])): ?>
            <?php foreach ($item['tags'] as $tag): ?>
            <a href="<?php echo $base . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>" class="vt-chip vt-chip--sm"><?php echo htmlspecialchars($tag); ?></a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
        <figure class="vt-hero-img">
            <img src="<?php echo $base . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy">
        </figure>
        <?php endif; ?>
        <?php $cf = render_item_custom_fields($item, 'project'); if ($cf): ?><div class="vt-custom-fields"><?php echo $cf; ?></div><?php endif; ?>
        <?php if (!empty($item['description'])): ?>
        <div class="vt-project-lead"><?php echo html_entity_decode($item['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></div>
        <?php endif; ?>
        <?php if (!empty($item['content'])): ?>
        <div class="vt-prose"><?php echo render_content_html($item['content'], $item); ?></div>
        <?php endif; ?>
        <?php echo render_related_items($item); ?>
    </div>
</article>
