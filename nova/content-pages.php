<?php
/**
 * Nova Theme for Synaptik CMS — content-pages.php
 * Single page view.
 */
?>
<div class="page-details">
  <div class="page-meta">
    <?php echo render_content_title($item); ?>
    <?php echo render_content_date($item); ?>
  </div>

  <?php $cfHtml = render_item_custom_fields($item, 'page'); if ($cfHtml): ?>
  <div class="nova-custom-fields"><?php echo $cfHtml; ?></div>
  <?php endif; ?>

  <?php echo render_featured_image($item); ?>

  <div class="page-content">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>

  <?php echo render_content_gallery($item); ?>

  <?php if (isset($item['show_tags_at_bottom']) && $item['show_tags_at_bottom']): ?>
  <div class="page-footer-tags">
    <h4><?php echo __t('tags_label', 'Tags:'); ?></h4>
    <?php echo render_content_tags($item); ?>
  </div>
  <?php endif; ?>

  <?php echo render_related_items($item); ?>
</div>
