<?php
/**
 * Axion Theme for Synaptik CMS — content-articles.php
 * Editorial single article: oversized title, lede meta, full-bleed image, narrow prose column.
 */
?>
<article class="ax-article">
  <header class="ax-article-head" data-reveal>
    <div class="ax-article-meta-top">
      <?php if (!empty($item['category'])): ?>
      <span class="ax-article-cat"><?php echo htmlspecialchars($item['category']); ?></span>
      <?php endif; ?>
      <?php if (!empty($item['date'])): ?>
      <span class="ax-dot" aria-hidden="true">·</span>
      <time datetime="<?php echo htmlspecialchars($item['date']); ?>"><?php echo htmlspecialchars(format_date($item['date'])); ?></time>
      <?php endif; ?>
    </div>
    <?php echo render_content_title($item); ?>
    <?php if (!empty($item['summary'])): ?>
    <p class="ax-article-lede"><?php echo htmlspecialchars($item['summary']); ?></p>
    <?php endif; ?>
  </header>

  <?php if (!empty($item['image']) && (!isset($item['show_featured_image']) || $item['show_featured_image'])): ?>
  <figure class="ax-article-figure" data-reveal>
    <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy" decoding="async">
  </figure>
  <?php endif; ?>

  <?php $cfHtml = render_item_custom_fields($item, 'article'); if ($cfHtml): ?>
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
