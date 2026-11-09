<?php
/**
 * Prism Theme for Synaptik CMS — content-articles.php
 * Single article view.
 */
?>
<div class="prism-content">
  <div class="prism-content-header">
    <div class="prism-content-meta">
      <?php echo render_content_category($item); ?>
      <?php echo render_content_date($item); ?>
    </div>
    <?php echo render_content_title($item); ?>
  </div>

  <?php $cfHtml = render_item_custom_fields($item, 'article'); if ($cfHtml): ?>
  <div class="prism-custom-fields"><?php echo $cfHtml; ?></div>
  <?php endif; ?>

  <?php echo render_featured_image($item); ?>

  <div class="prism-content-body">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>

  <?php echo render_content_gallery($item); ?>

  <?php if (isset($item['show_tags_at_bottom']) && $item['show_tags_at_bottom']): ?>
  <div class="prism-tags-bottom">
    <span class="prism-tags-label"><?php echo __t('tags_label'); ?></span>
    <?php echo render_content_tags($item); ?>
  </div>
  <?php endif; ?>

  <?php echo render_related_items($item); ?>
</div>
