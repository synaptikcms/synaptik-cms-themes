<?php
/* Template Name: Corporate */
/**
 * Myelin Theme — page-template: Corporate
 *
 * Layout for company / product / service pages. Wide hero, value cards,
 * featured projects section, content body, and a call-to-action band.
 *
 * @var array $item
 */
$settings = loadConfig();
?>
<section class="my-page my-page--corporate">

  <header class="my-page-hero" data-reveal>
    <?php if (!empty($item['category'])): ?>
    <div class="my-page-eyebrow"><?php echo htmlspecialchars($item['category']); ?></div>
    <?php endif; ?>
    <h1 class="my-page-title"><?php echo htmlspecialchars($item['title']); ?></h1>
    <?php if (!empty($item['meta_description'])): ?>
    <p class="my-page-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
    <?php endif; ?>
  </header>

  <?php if (!empty($item['image'])): ?>
  <figure class="my-page-figure" data-reveal>
    <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>"
         alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy" decoding="async">
  </figure>
  <?php endif; ?>

  <?php $cfHtml = render_item_custom_fields($item, 'page'); if ($cfHtml): ?>
  <div class="my-page-fields my-custom-fields" data-reveal><?php echo $cfHtml; ?></div>
  <?php endif; ?>

  <div class="my-page-body my-prose">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>

  <?php
  // Optional featured projects block under corporate pages.
  $projects = sl_load_index('project');
  if (!empty($projects)) {
    usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $projects = array_slice($projects, 0, 3);
  }
  if (!empty($projects)): ?>
  <section class="my-page-projects" data-reveal>
    <div class="my-section-head">
      <span class="my-section-label"><?php echo __t('featured_projects', 'Featured Projects'); ?></span>
      <a href="<?php echo cleanUrl('project'); ?>" class="my-section-link"><?php echo __t('view_all_projects', 'View All Projects'); ?> <span aria-hidden="true">→</span></a>
    </div>
    <div class="projects-grid">
      <?php foreach ($projects as $project): echo render_project_card($project); endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php echo render_content_gallery($item); ?>
  <?php echo render_related_items($item); ?>
</section>
