<?php
/**
 * Prism Theme for Synaptik CMS — home.php
 * Homepage: bold typography hero, article strips, project mosaic.
 */
?>
<section class="prism-hero">
  <div class="prism-hero-inner">
    <span class="prism-hero-label"><?php echo __t('welcome'); ?></span>
    <h1><?php echo htmlspecialchars($settings['site_title']); ?></h1>
    <p><?php echo htmlspecialchars($settings['site_description']); ?></p>
    <div class="prism-hero-buttons">
      <a href="<?php echo cleanUrl('article'); ?>" class="button"><?php echo sprintf(__t('explore_articles', 'Explore %s'), sl_type_label('article', true)); ?></a>
      <a href="<?php echo cleanUrl('project'); ?>" class="button button-secondary"><?php echo sprintf(__t('view_projects', 'View %s'), sl_type_label('project', true)); ?></a>
    </div>
    <div class="prism-spectrum" aria-hidden="true">
      <span></span><span></span><span></span><span></span><span></span>
    </div>
  </div>
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
<section class="prism-home-section prism-reveal">
  <div class="content-container">
    <div class="prism-section-header">
      <span class="prism-section-label"><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></span>
      <a href="<?php echo cleanUrl('article'); ?>" class="prism-section-link"><?php echo __t('view_all'); ?> →</a>
    </div>
    <div class="articles-grid">
      <?php foreach ($subset as $article): echo render_article_card($article); endforeach; ?>
    </div>
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <?php if ($i === $currentPage): ?>
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
  $perPage  = (int)($settings['projects_per_page'] ?? 6);
  $projects = $data['project'];
  usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
  $projects = array_values(array_filter($projects, fn($p) => !isset($p['show_on_homepage']) || $p['show_on_homepage'] === true));
  $featured = array_slice($projects, 0, $perPage);
?>
<section class="prism-home-section prism-reveal">
  <div class="content-container">
    <div class="prism-section-header">
      <span class="prism-section-label"><?php echo sprintf(__t('featured_projects', 'Featured %s'), sl_type_label('project', true)); ?></span>
      <a href="<?php echo cleanUrl('project'); ?>" class="prism-section-link"><?php echo sprintf(__t('view_all_projects', 'View All %s'), sl_type_label('project', true)); ?> →</a>
    </div>
    <div class="projects-grid">
      <?php foreach ($featured as $project): echo render_project_card($project); endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
