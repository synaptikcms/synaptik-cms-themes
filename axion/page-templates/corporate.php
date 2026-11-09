<?php
/* Template Name: Corporate */
/**
 * Axion Theme — page-template: Corporate
 *
 * Product / company landing built as a vertical walkthrough:
 *  - Asymmetric hero with eyebrow + huge title + lede + badge
 *  - Pillars strip (numbered)
 *  - Walkthrough sections rendered from H2 chunks of the content (alternating layout)
 *  - Comparison table block (rendered from a [callout type="info"] or markdown table in content)
 *  - Featured projects strip
 *  - Closer band
 *
 * The content body (rich text) is rendered as the source of the "walkthrough" — its
 * <h2> headings act as section anchors. Add a [toc] shortcode at the top if you
 * want an in-page nav.
 *
 * @var array $item
 */
$settings = loadConfig();

// Pull featured projects for the closing strip.
$projects = sl_load_index('project');
if (!empty($projects)) {
  usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
  $projects = array_slice($projects, 0, 3);
}
?>

<section class="ax-cp-hero">
  <div class="ax-cp-hero-inner">
    <span class="ax-eyebrow" data-reveal><?php echo htmlspecialchars($item['category'] ?: __t('product_overview', 'Product Overview')); ?></span>
    <h1 class="ax-cp-title" data-reveal><?php echo htmlspecialchars($item['title']); ?></h1>
    <?php if (!empty($item['meta_description'])): ?>
    <p class="ax-cp-lede" data-reveal><?php echo htmlspecialchars($item['meta_description']); ?></p>
    <?php endif; ?>
    <div class="ax-hero-actions" data-reveal>
      <a href="#walkthrough" class="ax-btn ax-btn-primary"><?php echo __t('learn_more', 'Learn more'); ?></a>
      <a href="<?php echo cleanUrl('project'); ?>" class="ax-btn ax-btn-ghost"><?php echo __t('view_projects', 'View Projects'); ?> <span aria-hidden="true">→</span></a>
    </div>
  </div>
</section>

<?php if (!empty($item['image'])): ?>
<section class="ax-cp-showcase" data-reveal>
  <div class="ax-cp-showcase-frame">
    <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy" decoding="async">
  </div>
</section>
<?php endif; ?>
<!-- ===== MANIFESTO ===== -->
<section class="ax-manifesto">
  <div class="ax-manifesto-inner">
    <div class="ax-manifesto-side" data-reveal>
      <span class="ax-section-label"><?php echo __t('manifesto_label', 'Manifesto'); ?></span>
    </div>
    <div class="ax-manifesto-main" data-reveal>
      <h2 class="ax-manifesto-title">
        <?php echo __t('manifesto_title', 'Authority, policy, and evidence — end to end.'); ?>
      </h2>
      <p class="ax-manifesto-body">
        <?php echo __t('manifesto_body', 'A site should not depend on a database, a build pipeline, or a stack you do not control. Axion is a single coherent layer: content, theme, and presentation, governed by your editorial intent and nothing else.'); ?>
      </p>
    </div>
  </div>
</section>

<!-- ===== CAPABILITIES ===== -->
<section class="ax-capabilities">
  <div class="ax-capabilities-inner">
    <header class="ax-capabilities-head" data-reveal>
      <span class="ax-section-label"><?php echo __t('capabilities_label', 'Principles'); ?></span>
      <h2 class="ax-capabilities-title"><?php echo __t('capabilities_title', 'The fundamentals, made explicit.'); ?></h2>
    </header>
    <ol class="ax-capabilities-grid">
      <li class="ax-capability" data-reveal>
        <span class="ax-capability-num">01</span>
        <h3><?php echo __t('cap_one_title', 'Static-first'); ?></h3>
        <p><?php echo __t('cap_one_body', 'Content lives in flat JSON files. No database to provision, back up, or migrate. The filesystem is the source of truth.'); ?></p>
      </li>
      <li class="ax-capability" data-reveal>
        <span class="ax-capability-num">02</span>
        <h3><?php echo __t('cap_two_title', 'Editorial control'); ?></h3>
        <p><?php echo __t('cap_two_body', 'Every visible string passes through the i18n layer. Every layout decision lives in the theme. Every output is shaped by your code, not a vendor.'); ?></p>
      </li>
      <li class="ax-capability" data-reveal>
        <span class="ax-capability-num">03</span>
        <h3><?php echo __t('cap_three_title', 'Fast by default'); ?></h3>
        <p><?php echo __t('cap_three_body', 'Lightweight indexes, OPcache-friendly lang caches, lazy-loaded images, and zero JavaScript dependencies on the critical path.'); ?></p>
      </li>
    </ol>
  </div>
</section>
<?php $cfHtml = render_item_custom_fields($item, 'page'); if ($cfHtml): ?>
<section class="ax-cp-pillars" data-reveal>
  <div class="ax-cp-pillars-inner">
    <span class="ax-section-label"><?php echo __t('at_a_glance', 'At a glance'); ?></span>
    <div class="ax-custom-fields ax-custom-fields--pillars"><?php echo $cfHtml; ?></div>
  </div>
</section>
<?php endif; ?>

<section id="walkthrough" class="ax-cp-walkthrough">
  <div class="ax-cp-walkthrough-inner">
    <header class="ax-cp-walkthrough-head" data-reveal>
      <span class="ax-section-label"><?php echo __t('walkthrough', 'Walkthrough'); ?></span>
      <h2 class="ax-cp-walkthrough-title"><?php echo __t('how_it_works', 'How it works.'); ?></h2>
    </header>
    <div class="ax-cp-walkthrough-body ax-prose" data-reveal>
      <?php echo render_content_html($item['content'] ?? '', $item); ?>
    </div>
  </div>
</section>

<?php echo render_content_gallery($item); ?>

<?php if (!empty($projects)): ?>
<section class="ax-cp-projects">
  <div class="ax-cp-projects-inner">
    <header class="ax-section-head" data-reveal>
      <span class="ax-section-label"><?php echo __t('featured_projects', 'Featured Projects'); ?></span>
      <a href="<?php echo cleanUrl('project'); ?>" class="ax-section-link"><?php echo __t('view_all_projects', 'View All Projects'); ?> <span aria-hidden="true">→</span></a>
    </header>
    <div class="projects-grid">
      <?php foreach ($projects as $p): echo render_project_card($p); endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="ax-closer">
  <div class="ax-closer-inner" data-reveal>
    <h2 class="ax-closer-title"><?php echo __t('cta_corporate_title', 'Ready to talk?'); ?></h2>
    <p class="ax-closer-sub"><?php echo __t('cta_corporate_sub', 'Get in touch and we will get back within one business day.'); ?></p>
    <a href="<?php echo cleanUrl('home'); ?>" class="ax-btn ax-btn-primary ax-btn-lg"><?php echo __t('request_a_demo', 'Request a demo'); ?> <span aria-hidden="true">→</span></a>
  </div>
</section>

<?php echo render_related_items($item); ?>
