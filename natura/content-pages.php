<?php
/**
 * Natura Theme for Synaptik CMS — content-pages.php
 * Single page view.
 */
$isFullWidth  = !empty($item['full_width']);
$sectionClass = 'page-details' . ($isFullWidth ? ' is-fullwidth' : '');
?>
<section class="<?php echo $sectionClass; ?>">

  <?php echo render_content_category($item); ?>
  <?php echo render_content_title($item); ?>

  <div class="article-meta-row">
    <?php echo render_content_date($item); ?>
    <?php if (!empty($item['tags'])): ?>
    <?php echo render_content_tags($item); ?>
    <?php endif; ?>
  </div>

  <?php $cfHtml = render_item_custom_fields($item, 'page'); if ($cfHtml): ?>
  <div class="natura-custom-fields"><?php echo $cfHtml; ?></div>
  <?php endif; ?>

  <?php echo render_featured_image($item); ?>

  <div class="page-content">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>

  <?php echo render_content_gallery($item); ?>

  <?php if (!empty($item['show_tags_at_bottom']) && $item['show_tags_at_bottom']): ?>
  <div class="article-footer-tags">
    <h4><?php echo __t('tags_label', 'Tags'); ?></h4>
    <?php echo render_content_tags($item); ?>
  </div>
  <?php endif; ?>

  <?php echo render_related_items($item); ?>

</section>
