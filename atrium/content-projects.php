<?php
/**
 * Atrium Theme for Synaptik CMS — content-projects.php
 *
 * Single project view: exhibition-style full-bleed media, project description
 * as prelude, prose body, custom fields, related items.
 */
$df_slug     = !empty($item['custom_slug']) ? $item['custom_slug'] : ($item['slug'] ?? '');
$df_cat      = !empty($item['category']) ? sanitizeSlug($item['category']) : '';
$df_settings = loadConfig();
?>
<article class="atrium-article atrium-article--project">

  <?php if (!empty($df_settings['show_breadcrumbs'])): ?>
  <nav class="atrium-breadcrumbs" aria-label="Breadcrumb">
    <?php echo getBreadcrumbs('project', $df_slug, $item['title'] ?? '', $df_cat); ?>
  </nav>
  <?php endif; ?>

  <header class="atrium-article-head">
    <?php if (!empty($item['category'])): ?>
    <div class="atrium-article-cat"><?php echo render_content_category($item); ?></div>
    <?php endif; ?>

    <?php echo render_content_title($item); ?>

    <div class="atrium-article-meta">
      <?php echo render_content_date($item); ?>
    </div>
  </header>

  <?php if (!empty($item['image']) && (!isset($item['show_featured_image']) || $item['show_featured_image'])): ?>
  <div class="atrium-project-cover">
    <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>"
         alt="<?php echo htmlspecialchars($item['title']); ?>"
         loading="eager" decoding="async">
  </div>
  <?php endif; ?>

  <?php if (!empty($item['description'])): ?>
  <p class="atrium-project-desc"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
  <?php endif; ?>

  <?php $df_cf = render_item_custom_fields($item, 'project'); if ($df_cf): ?>
  <aside class="atrium-cf"><?php echo $df_cf; ?></aside>
  <?php endif; ?>

  <div class="atrium-prose">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>

  <?php echo render_content_gallery($item); ?>

  <?php if (!empty($item['show_tags_at_bottom']) && !empty($item['tags'])): ?>
  <footer class="atrium-article-foot">
    <span class="atrium-tags-label"><?php echo __t('tags_label'); ?></span>
    <?php echo render_content_tags($item); ?>
  </footer>
  <?php endif; ?>

  <?php echo render_related_items($item); ?>
</article>
