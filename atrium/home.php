<?php
/**
 * Atrium Theme for Synaptik CMS — home.php
 *
 * Gallery-style homepage: typographic statement hero, one oversized featured
 * article, projects salon, numbered editorial index.
 */

// Pull and sort articles/projects from the index. Filter by show_on_homepage.
$df_home_articles = [];
if (!empty($data['article']) && is_array($data['article'])) {
    $df_home_articles = $data['article'];
    usort($df_home_articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $df_home_articles = array_values(array_filter(
        $df_home_articles,
        fn($a) => !isset($a['show_on_homepage']) || $a['show_on_homepage'] === true
    ));
}

$df_home_projects = [];
if (!empty($data['project']) && is_array($data['project'])) {
    $df_home_projects = $data['project'];
    usort($df_home_projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $df_home_projects = array_values(array_filter(
        $df_home_projects,
        fn($p) => !isset($p['show_on_homepage']) || $p['show_on_homepage'] === true
    ));
}

// Rotating words list — kept short for visual rhythm, all i18n.
$df_rotating_words = [
    __t('atrium_word_quiet',  'Quiet'),
    __t('atrium_word_made',   'Crafted'),
    __t('atrium_word_pause',  'Slow'),
    __t('atrium_word_open',   'Open'),
];
?>

<section class="atrium-hero">
  <div class="atrium-hero-inner">
    <p class="atrium-eyebrow"><span class="atrium-eyebrow-line" aria-hidden="true"></span><?php echo __t('atrium_eyebrow_room', 'Room 01 — Permanent collection'); ?></p>
    <h1 class="atrium-hero-title">
      <span class="atrium-hero-static"><?php echo __t('atrium_hero_static', 'A space for'); ?></span>
      <span class="atrium-hero-rotator" id="atrium-rotator" aria-live="polite">
        <?php foreach ($df_rotating_words as $df_i => $df_w): ?>
        <span class="atrium-hero-word<?php echo $df_i === 0 ? ' is-active' : ''; ?>"><?php echo htmlspecialchars($df_w); ?></span>
        <?php endforeach; ?>
      </span>
      <span class="atrium-hero-static atrium-hero-static--italic"><?php echo __t('atrium_hero_static_2', 'thinking.'); ?></span>
    </h1>
    <?php if (!empty($settings['site_description'])): ?>
    <p class="atrium-hero-lede"><?php echo htmlspecialchars($settings['site_description']); ?></p>
    <?php endif; ?>
    <div class="atrium-hero-meta">
      <span class="atrium-hero-meta-item"><?php echo htmlspecialchars(date('Y')); ?></span>
      <span class="atrium-hero-meta-item"><?php echo strtoupper(htmlspecialchars($settings['site_language'] ?? 'EN')); ?></span>
      <span class="atrium-hero-meta-item"><?php echo __t('atrium_meta_ongoing', 'Ongoing'); ?></span>
    </div>
  </div>
  <a class="atrium-scroll-hint" href="#atrium-feature" aria-label="<?php echo htmlspecialchars(__t('atrium_scroll_label', 'Scroll to enter')); ?>">
    <span class="atrium-scroll-line" aria-hidden="true"></span>
    <span class="atrium-scroll-label"><?php echo __t('atrium_scroll_label', 'Scroll to enter'); ?></span>
  </a>
</section>

<?php
// Featured: first article on homepage as the centerpiece.
if (!empty($df_home_articles)):
    $df_feat = $df_home_articles[0];
    $df_feat_slug = !empty($df_feat['custom_slug']) ? $df_feat['custom_slug'] : $df_feat['slug'];
    $df_feat_cat  = !empty($df_feat['category']) ? sanitizeSlug($df_feat['category']) : null;
    $df_feat_url  = cleanUrl('article', $df_feat_slug, null, $df_feat_cat);
?>
<section id="atrium-feature" class="atrium-feature atrium-reveal">
  <a href="<?php echo $df_feat_url; ?>" class="atrium-feature-link" data-atrium-link>
    <div class="atrium-feature-media">
      <?php if (!empty($df_feat['image'])): ?>
      <img src="<?php echo getBaseUrl() . htmlspecialchars($df_feat['image']); ?>"
           alt="<?php echo htmlspecialchars($df_feat['title']); ?>"
           loading="eager" decoding="async">
      <?php else: ?>
      <div class="atrium-feature-placeholder" aria-hidden="true"></div>
      <?php endif; ?>
    </div>
    <div class="atrium-feature-body">
      <span class="atrium-feature-label"><?php echo __t('featured', 'Featured'); ?> · <?php echo sl_type_label('article', true); ?></span>
      <h2 class="atrium-feature-title"><?php echo htmlspecialchars($df_feat['title']); ?></h2>
      <?php $df_sum = get_article_summary($df_feat, 220); if ($df_sum): ?>
      <p class="atrium-feature-summary"><?php echo $df_sum; ?></p>
      <?php endif; ?>
      <span class="atrium-feature-cta">
        <?php echo __t('read_more'); ?>
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7h8M7 3l4 4-4 4"/></svg>
      </span>
    </div>
  </a>
</section>
<?php endif; ?>

<?php
// Projects salon: gallery-style asymmetric row.
if (!empty($settings['show_projects_on_homepage']) && !empty($df_home_projects)):
    $df_per_page = (int)($settings['projects_per_page'] ?? 6);
    $df_proj = array_slice($df_home_projects, 0, $df_per_page);
?>
<section class="atrium-salon atrium-reveal">
  <header class="atrium-section-head">
    <span class="atrium-section-num">II.</span>
    <h2 class="atrium-section-title"><?php echo sprintf(__t('featured_projects', 'Featured %s'), sl_type_label('project', true)); ?></h2>
    <a href="<?php echo cleanUrl('project'); ?>" class="atrium-section-link" data-atrium-link>
      <?php echo sprintf(__t('view_all_projects', 'View All %s'), sl_type_label('project', true)); ?>
      <svg width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7h8M7 3l4 4-4 4"/></svg>
    </a>
  </header>
  <div class="atrium-salon-grid atrium-stagger">
    <?php foreach ($df_proj as $df_p): echo render_project_card($df_p); endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php
// Editorial index: numbered list of remaining articles. Excludes the feature.
if (!empty($settings['show_articles_on_homepage']) && count($df_home_articles) > 1):
    $df_index_items = array_slice($df_home_articles, 1, (int)($settings['articles_per_page'] ?? 6));
?>
<section class="atrium-index atrium-reveal">
  <header class="atrium-section-head">
    <span class="atrium-section-num">III.</span>
    <h2 class="atrium-section-title"><?php echo __t('atrium_index_title', 'In the reading room'); ?></h2>
    <a href="<?php echo cleanUrl('article'); ?>" class="atrium-section-link" data-atrium-link>
      <?php echo __t('view_all'); ?>
      <svg width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7h8M7 3l4 4-4 4"/></svg>
    </a>
  </header>
  <ol class="atrium-index-list atrium-stagger" start="1">
    <?php foreach ($df_index_items as $df_n => $df_a):
        $df_slug = !empty($df_a['custom_slug']) ? $df_a['custom_slug'] : $df_a['slug'];
        $df_cat  = !empty($df_a['category']) ? sanitizeSlug($df_a['category']) : null;
        $df_url  = cleanUrl('article', $df_slug, null, $df_cat);
    ?>
    <li class="atrium-index-row">
      <a href="<?php echo $df_url; ?>" class="atrium-index-link" data-atrium-link>
        <span class="atrium-index-num"><?php echo str_pad((string)($df_n + 1), 2, '0', STR_PAD_LEFT); ?></span>
        <span class="atrium-index-title"><?php echo htmlspecialchars($df_a['title']); ?></span>
        <span class="atrium-index-meta">
          <?php if (!empty($df_a['category'])): ?>
          <span class="atrium-index-cat"><?php echo htmlspecialchars($df_a['category']); ?></span>
          <?php endif; ?>
          <?php if (!empty($df_a['date'])): ?>
          <time class="atrium-index-date" datetime="<?php echo htmlspecialchars($df_a['date']); ?>"><?php echo htmlspecialchars(format_date($df_a['date'])); ?></time>
          <?php endif; ?>
        </span>
        <span class="atrium-index-arrow" aria-hidden="true">→</span>
      </a>
    </li>
    <?php endforeach; ?>
  </ol>
</section>
<?php endif; ?>
