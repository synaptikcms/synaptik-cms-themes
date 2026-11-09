<?php
/**
 * Vanta Theme — home.php
 *
 * Homepage layout: hero + article grid with pagination + project grid.
 * Injected variables: $data, $settings
 */
$articlesLimit   = (int)($settings['articles_per_page'] ?? 6);
$projectsLimit   = (int)($settings['projects_per_page'] ?? 6);
$currentPage     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

// Build full filtered & sorted article list for pagination
$allArticles = [];
if (!empty($data['article']) && !empty($settings['show_articles_on_homepage'])) {
    $articles = $data['article'];
    usort($articles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $allArticles = array_values(array_filter($articles, fn($a) => !isset($a['show_on_homepage']) || $a['show_on_homepage'] === true));
}

$totalArticles  = count($allArticles);
$totalPages     = $articlesLimit > 0 ? (int)ceil($totalArticles / $articlesLimit) : 1;
$recentArticles = array_slice($allArticles, ($currentPage - 1) * $articlesLimit, $articlesLimit);

// Projects — no pagination, just a slice
$recentProjects = [];
if (!empty($data['project']) && !empty($settings['show_projects_on_homepage'])) {
    $projects = $data['project'];
    usort($projects, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    $projects = array_filter($projects, fn($p) => !isset($p['show_on_homepage']) || $p['show_on_homepage'] === true);
    $recentProjects = array_slice(array_values($projects), 0, $projectsLimit);
}
?>

        <!-- ── Hero ───────────────────────────────────────── -->
        <section class="home-hero">
            <p class="home-hero-eyebrow"><?php echo htmlspecialchars($settings['site_title'] ?? ''); ?></p>
            <h1>
                <?php
                $desc = $settings['site_description'] ?? '';
                if ($desc) {
                    $words = explode(' ', $desc);
                    if (count($words) > 1) {
                        $last = array_pop($words);
                        echo htmlspecialchars(implode(' ', $words)) . ' <em>' . htmlspecialchars($last) . '</em>';
                    } else {
                        echo htmlspecialchars($desc);
                    }
                } else {
                    echo htmlspecialchars($settings['site_title'] ?? 'Welcome');
                }
                ?>
            </h1>
        </section>

        <?php if (!empty($recentArticles)): ?>
        <!-- ── Articles grid ──────────────────────────────── -->
        <section class="home-section">
            <div class="section-header">
                <h2 class="section-title"><?php echo sl_type_label('article', true); ?></h2>
                <a href="<?php echo cleanUrl('article'); ?>" class="section-link">
                    <?php echo __t('view_all') ?: 'View all'; ?> →
                </a>
            </div>
            <div class="articles-grid">
                <?php foreach ($recentArticles as $article): ?>
                    <?php echo render_article_card($article); ?>
                <?php endforeach; ?>
            </div>
            <?php if ($totalPages > 1): ?>
            <nav class="vanta-pagination" aria-label="<?php echo sl_type_label('article', true); ?>">
                <?php if ($currentPage > 1): ?>
                <a href="<?php echo cleanUrl('home'); ?>?page=<?php echo $currentPage - 1; ?>" class="pag-btn pag-prev" aria-label="<?php echo __t('previous') ?: 'Previous'; ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                </a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i === $currentPage): ?>
                    <span class="pag-btn pag-current" aria-current="page"><?php echo $i; ?></span>
                    <?php else: ?>
                    <a href="<?php echo cleanUrl('home'); ?>?page=<?php echo $i; ?>" class="pag-btn"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                <a href="<?php echo cleanUrl('home'); ?>?page=<?php echo $currentPage + 1; ?>" class="pag-btn pag-next" aria-label="<?php echo __t('next') ?: 'Next'; ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <?php endif; ?>
            </nav>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <?php if (!empty($recentProjects)): ?>
        <!-- ── Projects grid ──────────────────────────────── -->
        <section class="home-section">
            <div class="section-header">
                <h2 class="section-title"><?php echo sl_type_label('project', true); ?></h2>
                <a href="<?php echo cleanUrl('project'); ?>" class="section-link">
                    <?php echo __t('view_all') ?: 'View all'; ?> →
                </a>
            </div>
            <div class="projects-grid">
                <?php foreach ($recentProjects as $project): ?>
                    <?php echo render_project_card($project); ?>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (empty($recentArticles) && empty($recentProjects)): ?>
        <div class="home-section">
            <p class="empty-state"><?php echo __t('no_content_yet') ?: 'No content published yet.'; ?></p>
        </div>
        <?php endif; ?>
