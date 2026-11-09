<?php
/**
 * Vanta Theme — content-projects.php
 *
 * Single project view.
 * Injected variable: $item
 */
$settings = loadConfig();
?>
        <article class="vanta-single">

            <?php echo function_exists('vanta_back_link') ? vanta_back_link('project') : '<a href="' . cleanUrl('project') . '" class="single-back">' . sl_type_label('project', true) . '</a>'; ?>

            <?php if (!empty($item['category'])): ?>
            <div>
                <a href="<?php echo cleanUrl('category', null, null, sanitizeSlug($item['category'])); ?>"
                   class="single-category">
                    <?php echo htmlspecialchars($item['category']); ?>
                </a>
            </div>
            <?php endif; ?>

            <?php if (!isset($item['show_title']) || $item['show_title']): ?>
            <h1 class="single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
            <?php endif; ?>

            <?php
            $hasDate = !empty($item['date']) && !empty($item['show_date']);
            $hasTags = !empty($item['tags']) && is_array($item['tags']) && isset($item['show_tags_at_bottom']) && $item['show_tags_at_bottom'];
            if ($hasDate || $hasTags):
            ?>
            <div class="single-meta">
                <?php if ($hasDate): ?>
                <time datetime="<?php echo htmlspecialchars($item['date']); ?>">
                    <?php echo htmlspecialchars(format_date($item['date'])); ?>
                </time>
                <?php endif; ?>
                <?php if ($hasTags): ?>
                <div class="single-tags">
                    <?php foreach ($item['tags'] as $tag): ?>
                    <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>">
                        <?php echo htmlspecialchars($tag); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
            <figure class="single-featured">
                <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>"
                     alt="<?php echo htmlspecialchars($item['title']); ?>">
            </figure>
            <?php endif; ?>

            <?php $vantaCF = render_item_custom_fields($item, 'project'); ?>
            <?php if ($vantaCF): ?>
            <div class="vanta-content-wrap">
                <div class="vanta-main-col">
            <?php endif; ?>

            <?php if (!empty($item['description'])): ?>
            <div class="prose-body" style="margin-bottom:1.5rem;">
                <?php echo html_entity_decode($item['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($item['content'])): ?>
            <div class="prose-body">
                <?php echo render_content_html($item['content'], $item); ?>
            </div>
            <?php endif; ?>

            <?php if ($vantaCF): ?>
                </div>
                <aside class="vanta-cf-sidebar"><?php echo $vantaCF; ?></aside>
            </div>
            <?php endif; ?>

            <?php echo render_related_items($item); ?>

        </article>
