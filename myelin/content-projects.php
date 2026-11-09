<?php
/**
 * Myelin Theme for Synaptik CMS — content-projects.php
 * Single project view with optional description block.
 */
?>
<article class="my-single my-single--project">
  <header class="my-single-head" data-reveal>
    <?php echo render_content_category($item); ?>
    <?php echo render_content_title($item); ?>
    <div class="my-single-meta">
      <?php echo render_content_date($item); ?>
    </div>
  </header>

  <?php echo render_featured_image($item); ?>

  <?php if (!empty($item['description'])): ?>
  <p class="my-single-lede" data-reveal><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
  <?php endif; ?>

  <?php $cfHtml = render_item_custom_fields($item, 'project'); if ($cfHtml): ?>
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
