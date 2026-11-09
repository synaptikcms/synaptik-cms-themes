<?php
/* Template Name: Portfolio */
/**
 * Myelin Theme — page-template: Portfolio
 *
 * Portfolio landing page: large hero, full projects grid with pagination,
 * optional content body below.
 *
 * @var array $item
 */
$settings = loadConfig();

$projects = sl_load_index('project');
if (!empty($projects)) {
  usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
}

$perPage = (int)($settings['projects_per_page'] ?? 9);
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$total = count($projects);
$totalPages = max(1, (int)ceil($total / $perPage));
$subset = array_slice($projects, ($currentPage - 1) * $perPage, $perPage);
?>
<section class="my-page my-page--portfolio">

  <header class="my-page-hero my-page-hero--portfolio" data-reveal>
    <?php if (!empty($item['category'])): ?>
    <div class="my-page-eyebrow"><?php echo htmlspecialchars($item['category']); ?></div>
    <?php else: ?>
    <div class="my-page-eyebrow"><?php echo __t('portfolio_hero_eyebrow', 'Creative Portfolio'); ?></div>
    <?php endif; ?>
    <h1 class="my-page-title my-page-title--serif"><?php echo htmlspecialchars($item['title']); ?></h1>
    <?php if (!empty($item['meta_description'])): ?>
    <p class="my-page-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
    <?php endif; ?>
  </header>

  <div class="my-page-grid" data-reveal>
    <?php if (empty($subset)): ?>
    <p class="my-list-empty"><?php echo sprintf(__t('no_type_found'), 'project'); ?></p>
    <?php else: ?>
    <div class="projects-grid projects-grid--portfolio">
      <?php foreach ($subset as $project): echo render_project_card($project); endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

  <?php if ($totalPages > 1): ?>
  <div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <?php if ($i == $currentPage): ?>
      <span class="current-page"><?php echo $i; ?></span>
      <?php else: ?>
      <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>
  </div>
  <?php endif; ?>

  <?php if (!empty(trim(strip_tags($item['content'] ?? '')))): ?>
  <div class="my-page-body my-prose my-prose--narrow">
    <?php echo render_content_html($item['content'] ?? '', $item); ?>
  </div>
  <?php endif; ?>

  <?php echo render_content_gallery($item); ?>
</section>
