<div class="home-hero">
    <h1><?php echo hsc($settings['site_title'] ?? ''); ?></h1>
    <?php if (!empty($settings['site_description'])): ?>
    <p><?php echo hsc($settings['site_description']); ?></p>
    <?php endif; ?>
</div>

<?php
$recentArticles = [];
$recentProjects = [];
?>

<?php if (!empty($settings['show_articles_on_homepage']) && !empty($data['article'])):
    $articlesPerPage = (int)($settings['articles_per_page'] ?? 6);
    $recentArticles  = $data['article'];
    usort($recentArticles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $recentArticles  = array_values(array_filter($recentArticles, fn($a) => !isset($a['show_on_homepage']) || $a['show_on_homepage'] === true));
    $recentArticles  = array_slice($recentArticles, 0, $articlesPerPage);
?>
<?php if (!empty($recentArticles)): ?>
<section class="home-section">
    <h2 class="section-label"><?php echo hsc(sl_type_label('article', true)); ?></h2>
    <div class="articles-grid">
        <?php foreach ($recentArticles as $article): ?>
            <?php echo render_article_card($article); ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>

<?php if (!empty($settings['show_projects_on_homepage']) && !empty($data['project'])):
    $projectsPerPage = (int)($settings['projects_per_page'] ?? 6);
    $recentProjects  = $data['project'];
    usort($recentProjects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $recentProjects  = array_values(array_filter($recentProjects, fn($p) => !isset($p['show_on_homepage']) || $p['show_on_homepage'] === true));
    $recentProjects  = array_slice($recentProjects, 0, $projectsPerPage);
?>
<?php if (!empty($recentProjects)): ?>
<section class="home-section">
    <h2 class="section-label"><?php echo hsc(sl_type_label('project', true)); ?></h2>
    <div class="projects-grid">
        <?php foreach ($recentProjects as $project): ?>
            <?php echo render_project_card($project); ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>

<?php if (empty($recentArticles) && empty($recentProjects)): ?>
<p class="empty-state"><?php echo hsc(__t('no_content_yet') ?: 'No content published yet.'); ?></p>
<?php endif; ?>
