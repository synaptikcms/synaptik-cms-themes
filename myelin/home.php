<?php
/**
 * Myelin Theme for Synaptik CMS — home.php
 * Minimalist hero with eyebrow, large headline, two CTAs, then articles and projects grids.
 */
?>
<section class="my-hero">
  <div class="my-hero-inner">
    <div class="my-hero-eyebrow" data-reveal><?php echo __t('welcome', 'Welcome'); ?></div>
    <h1 class="my-hero-title" data-reveal><?php echo htmlspecialchars($settings['site_title']); ?></h1>
    <p class="my-hero-sub" data-reveal><?php echo htmlspecialchars($settings['site_description']); ?></p>
    <div class="my-hero-cta" data-reveal>
      <a href="<?php echo cleanUrl('article'); ?>" class="my-btn my-btn-primary"><?php echo sprintf(__t('explore_articles', 'Explore %s'), sl_type_label('article', true)); ?></a>
      <a href="<?php echo cleanUrl('project'); ?>" class="my-btn my-btn-ghost"><?php echo sprintf(__t('view_projects', 'View %s'), sl_type_label('project', true)); ?> <span aria-hidden="true">→</span></a>
    </div>
  </div>
  <div class="my-hero-deco" aria-hidden="true"></div>
</section>

<?php
if (!empty($settings['show_articles_on_homepage']) && !empty($data['article'])):
  $currentPage     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
  $articlesPerPage = (int)($settings['articles_per_page'] ?? 6);
  $articles        = $data['article'];
  usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
  $articles      = array_values(array_filter($articles, fn($a) => !isset($a['show_on_homepage']) || $a['show_on_homepage'] === true));
  $totalArticles = count($articles);
  $totalPages    = (int)ceil($totalArticles / $articlesPerPage);
  $subset        = array_slice($articles, ($currentPage - 1) * $articlesPerPage, $articlesPerPage);
?>
<section class="my-section">
  <div class="my-section-inner">
    <div class="my-section-head" data-reveal>
      <span class="my-section-label"><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></span>
      <a href="<?php echo cleanUrl('article'); ?>" class="my-section-link"><?php echo __t('view_all', 'View all'); ?> <span aria-hidden="true">→</span></a>
    </div>
    <div class="articles-grid" data-reveal>
      <?php foreach ($subset as $article): echo render_article_card($article); endforeach; ?>
    </div>
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $currentPage): ?>
        <span class="current-page"><?php echo $i; ?></span>
        <?php else: ?>
        <a href="<?php echo cleanUrl('home'); ?>?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
        <?php endif; ?>
      <?php endfor; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php
if (!empty($settings['show_projects_on_homepage']) && !empty($data['project'])):
  $perPage  = (int)($settings['projects_per_page'] ?? 3);
  $projects = $data['project'];
  usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
  $projects = array_values(array_filter($projects, fn($p) => !isset($p['show_on_homepage']) || $p['show_on_homepage'] === true));
  $featured = array_slice($projects, 0, $perPage);
?>
<section class="my-section my-section--alt">
  <div class="my-section-inner">
    <div class="my-section-head" data-reveal>
      <span class="my-section-label"><?php echo sprintf(__t('featured_projects', 'Featured %s'), sl_type_label('project', true)); ?></span>
      <a href="<?php echo cleanUrl('project'); ?>" class="my-section-link"><?php echo sprintf(__t('view_all_projects', 'View All %s'), sl_type_label('project', true)); ?> <span aria-hidden="true">→</span></a>
    </div>
    <div class="projects-grid" data-reveal>
      <?php foreach ($featured as $project): echo render_project_card($project); endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
