<?php
/**
 * Portfolio Theme — content-projects.php
 * Single project template. Sidebar only rendered when custom fields exist.
 */

$customFieldsHtml = render_item_custom_fields($item, 'project');
$hasSidebar       = (bool)$customFieldsHtml;
$hasTags          = !empty($item['tags']) && is_array($item['tags']);
$hasDate          = !empty($item['date']);
?>
<article class="single-project" data-type="project">

    <div class="project-hero">
        <?php if (!empty($item['image'])): ?>
        <div class="project-cover" data-parallax>
            <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>"
                 alt="<?php echo htmlspecialchars($item['title']); ?>">
            <div class="project-cover-overlay"></div>
        </div>
        <?php endif; ?>
        <div class="project-hero-text">
            <?php if (!empty($item['category'])): ?>
            <a href="<?php echo cleanUrl('category', null, null, sanitizeSlug($item['category'])); ?>"
               class="single-category"><?php echo htmlspecialchars($item['category']); ?></a>
            <?php endif; ?>
            <?php echo render_content_title($item); ?>
            <?php if (!empty($item['description'])): ?>
            <p class="project-tagline"><?php echo htmlspecialchars($item['description']); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="project-layout" <?php echo $hasSidebar ? '' : 'style="grid-template-columns: 1fr;"'; ?>>

        <div class="project-content prose<?php echo $hasSidebar ? '' : ' prose--full'; ?>" data-animate-in>
            <?php echo render_content_html($item['content'] ?? '', $item); ?>
        </div>

        <?php if ($hasSidebar): ?>
        <aside class="project-sidebar" data-animate-in>

            <div class="sidebar-block sidebar-block--fields">
                <?php echo $customFieldsHtml; ?>
            </div>

            <?php if ($hasDate || $hasTags): ?>
            <div class="sidebar-block sidebar-block--meta">
                <?php echo render_content_date($item); ?>
                <?php if ($hasTags): ?>
                <div class="sidebar-meta-tags">
                    <span class="sidebar-label"><?php echo __t('tags_label'); ?></span>
                    <div class="single-tags">
                        <?php foreach ($item['tags'] as $tag): ?>
                        <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>"
                           class="tag-pill"><?php echo htmlspecialchars($tag); ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </aside>
        <?php endif; ?>

    </div>

    <?php echo render_related_items($item); ?>

</article>
