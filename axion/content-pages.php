<?php
/**
 * Axion Theme for Synaptik CMS — content-pages.php
 * Default page view (used when no page template is selected).
 */
?>
<article class="ax-article ax-article--page">
  <header class="ax-article-head" data-reveal>
    <?php echo render_content_title($item); ?>
    <?php if (!empty($item['meta_description'])): ?>
    <p class="ax-article-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
    <?php endif; ?>
  </header>

  <?php if (!empty($item['image']) && (!isset($item['show_featured_image']) || $item['show_featured_image'])): ?>
  <figure class="ax-article-figure" data-reveal>
    <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy" decoding="async">
  </figure>
  <?php endif; ?>

  <?php $cfHtml = render_item_custom_fields($item, 'page'); if ($cfHtml): ?>
  <div class="ax-custom-fields" data-reveal><?php echo $cfHtml; ?></div>
  <?php endif; ?>

  <div class="ax-article-body ax-prose">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>

  <?php echo render_content_gallery($item); ?>

  <?php if (isset($item['show_tags_at_bottom']) && $item['show_tags_at_bottom']): ?>
  <div class="ax-article-tags">
    <h4><?php echo __t('tags_label', 'Tags:'); ?></h4>
    <?php echo render_content_tags($item); ?>
  </div>
  <?php endif; ?>

  <?php echo render_related_items($item); ?>
</article>
