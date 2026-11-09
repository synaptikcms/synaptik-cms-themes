<?php
/**
 * Atrium Theme for Synaptik CMS — content-pages.php
 *
 * Single page view: editorial prose layout, custom fields, related items.
 */
$df_slug     = !empty($item['custom_slug']) ? $item['custom_slug'] : ($item['slug'] ?? '');
$df_settings = loadConfig();
?>
<article class="atrium-article atrium-article--page">

  <?php if (!empty($df_settings['show_breadcrumbs'])): ?>
  <nav class="atrium-breadcrumbs" aria-label="Breadcrumb">
    <?php echo getBreadcrumbs('page', $df_slug, $item['title'] ?? ''); ?>
  </nav>
  <?php endif; ?>

  <header class="atrium-article-head">
    <?php echo render_content_title($item); ?>

    <div class="atrium-article-meta">
      <?php echo render_content_date($item); ?>
    </div>
  </header>

  <?php echo render_featured_image($item); ?>

  <?php $df_cf = render_item_custom_fields($item, 'page'); if ($df_cf): ?>
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
