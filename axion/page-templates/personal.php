<?php
/* Template Name: Personal */
/**
 * Axion Theme — page-template: Personal
 *
 * Editorial portrait page:
 *  - Sticky vertical name label (rotated) on the left.
 *  - Large portrait that takes ~55% of the viewport width.
 *  - Long-form bio in a narrow column with drop-cap on the first paragraph.
 *  - "Now" status card pulled from custom fields.
 *  - Latest articles strip at the bottom.
 *
 * @var array $item
 */
$settings = loadConfig();

$articles = sl_load_index('article');
if (!empty($articles)) {
  usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
  $articles = array_slice($articles, 0, 4);
}
?>

<section class="ax-ps">
  <span class="ax-ps-vertical" aria-hidden="true"><?php echo htmlspecialchars(strtoupper($item['title'])); ?></span>

  <div class="ax-ps-hero">
    <?php if (!empty($item['image'])): ?>
    <div class="ax-ps-portrait" data-reveal>
      <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="eager" decoding="async">
    </div>
    <?php endif; ?>
    <div class="ax-ps-intro" data-reveal>
      <span class="ax-eyebrow"><?php echo htmlspecialchars($item['category'] ?: __t('about', 'About')); ?></span>
      <h1 class="ax-ps-title"><?php echo htmlspecialchars($item['title']); ?></h1>
      <?php if (!empty($item['meta_description'])): ?>
      <p class="ax-ps-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="ax-ps-body">
    <article class="ax-ps-text ax-prose ax-prose--dropcap" data-reveal>
      <?php echo render_content_html($item['content'] ?? '', $item); ?>
    </article>
    <?php $cfHtml = render_item_custom_fields($item, 'page'); if ($cfHtml): ?>
    <aside class="ax-ps-now" data-reveal>
      <span class="ax-section-label"><?php echo __t('currently', 'Currently'); ?></span>
      <div class="ax-custom-fields ax-custom-fields--card"><?php echo $cfHtml; ?></div>
    </aside>
    <?php endif; ?>
  </div>

  <?php echo render_content_gallery($item); ?>
</section>

<?php if (!empty($articles)): ?>
<section class="ax-ps-articles">
  <div class="ax-ps-articles-inner">
    <header class="ax-section-head" data-reveal>
      <span class="ax-section-label"><?php echo __t('writing', 'Writing'); ?></span>
      <a href="<?php echo cleanUrl('article'); ?>" class="ax-section-link"><?php echo __t('view_all', 'View all'); ?> <span aria-hidden="true">→</span></a>
    </header>
    <ol class="ax-ps-list" data-reveal>
      <?php foreach ($articles as $i => $a):
        $slug = !empty($a['custom_slug']) ? $a['custom_slug'] : $a['slug'];
        $cat  = !empty($a['category']) ? sanitizeSlug($a['category']) : null;
        $url  = cleanUrl('article', $slug, null, $cat);
      ?>
      <li>
        <a href="<?php echo $url; ?>">
          <span class="ax-ps-list-num"><?php echo str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT); ?></span>
          <span class="ax-ps-list-title"><?php echo htmlspecialchars($a['title']); ?></span>
          <?php if (!empty($a['date'])): ?>
          <time><?php echo htmlspecialchars(format_date($a['date'])); ?></time>
          <?php endif; ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
<?php endif; ?>

<?php echo render_related_items($item); ?>
