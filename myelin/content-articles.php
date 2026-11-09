<?php
/**
 * Myelin Theme for Synaptik CMS — content-articles.php
 * Single article view with centered content column.
 */
?>
<article class="my-single my-single--article">
  <header class="my-single-head" data-reveal>
    <?php echo render_content_category($item); ?>
    <?php echo render_content_title($item); ?>
    <div class="my-single-meta">
      <?php echo render_content_date($item); ?>
    </div>
  </header>

  <?php echo render_featured_image($item); ?>

  <?php $cfHtml = render_item_custom_fields($item, 'article'); if ($cfHtml): ?>
  <div class="my-custom-fields" data-reveal><?php echo $cfHtml; ?></div>
  <?php endif; ?>

  <div class="my-single-body my-prose">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>

  <?php echo render_content_gallery($item); ?>

  <?php if (isset($item['show_tags_at_bottom']) && $item['show_tags_at_bottom']): ?>
  <div class="my-single-tags">
    <h4><?php echo __t('tags_label', 'Tags:'); ?></h4>
    <?php echo render_content_tags($item); ?>
  </div>
  <?php endif; ?>

  <?php echo render_related_items($item); ?>
</article>
