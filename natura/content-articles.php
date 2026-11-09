<?php
/**
 * Natura Theme for Synaptik CMS — content-articles.php
 * Single article view.
 */
?>
<article class="content-details">

  <?php echo render_content_category($item); ?>
  <?php echo render_content_title($item); ?>

  <div class="article-meta-row">
    <?php echo render_content_date($item); ?>
    <?php if (!empty($item['tags'])): ?>
    <?php echo render_content_tags($item); ?>
    <?php endif; ?>
  </div>

  <?php $cfHtml = render_item_custom_fields($item, 'article'); if ($cfHtml): ?>
  <div class="natura-custom-fields"><?php echo $cfHtml; ?></div>
  <?php endif; ?>

  <?php echo render_featured_image($item); ?>

  <div class="content-main article-body">
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

</article>
