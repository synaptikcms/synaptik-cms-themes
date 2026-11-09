<?php
/**
 * Axion Theme for Synaptik CMS — content-projects.php
 * Single project: full-bleed media + asymmetric meta sidebar + body.
 */
?>
<article class="ax-project">

  <header class="ax-project-head" data-reveal>
    <?php if (!empty($item['category'])): ?>
    <span class="ax-eyebrow"><?php echo htmlspecialchars($item['category']); ?></span>
    <?php endif; ?>
    <?php echo render_content_title($item); ?>
    <?php if (!empty($item['description'])): ?>
    <p class="ax-project-lede"><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
    <?php endif; ?>
  </header>

  <?php if (!empty($item['image']) && (!isset($item['show_featured_image']) || $item['show_featured_image'])): ?>
  <figure class="ax-project-figure" data-reveal>
    <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy" decoding="async">
  </figure>
  <?php endif; ?>

  <div class="ax-project-grid">
    <aside class="ax-project-aside" data-reveal>
      <dl class="ax-project-spec">
        <?php if (!empty($item['date'])): ?>
        <div><dt><?php echo __t('date', 'Date'); ?></dt><dd><?php echo htmlspecialchars(format_date($item['date'])); ?></dd></div>
        <?php endif; ?>
        <?php if (!empty($item['category'])): ?>
        <div><dt><?php echo __t('breadcrumb_category', 'Category'); ?></dt><dd><?php echo htmlspecialchars($item['category']); ?></dd></div>
        <?php endif; ?>
        <?php if (!empty($item['tags']) && is_array($item['tags'])): ?>
        <div><dt><?php echo __t('tags_label', 'Tags'); ?></dt><dd><?php echo htmlspecialchars(implode(', ', $item['tags'])); ?></dd></div>
        <?php endif; ?>
      </dl>
      <?php $cfHtml = render_item_custom_fields($item, 'project'); if ($cfHtml): ?>
      <div class="ax-custom-fields ax-custom-fields--aside"><?php echo $cfHtml; ?></div>
      <?php endif; ?>
    </aside>
    <div class="ax-project-body ax-prose">
      <?php echo render_content_html($item['content'] ?? '', $item); ?>
    </div>
  </div>

  <?php echo render_content_gallery($item); ?>
  <?php echo render_related_items($item); ?>
</article>
