<?php
/**
 * Portfolio Theme — content-list.php
 * List, category, and tag pages — bento + scroll layouts.
 *
 * @var string $list_type   'article' | 'project' | 'page' | 'category' | 'tag'
 * @var array  $articles
 * @var array  $projects
 * @var string $filter_value
 * @var array  $data
 * @var array  $settings
 */

$pageTitle = '';
$pageIcon  = '';

switch ($list_type) {
    case 'category':
        $pageTitle = htmlspecialchars(urldecode($filter_value));
        $pageIcon  = '◈';
        break;
    case 'tag':
        $pageTitle = '#' . htmlspecialchars(urldecode($filter_value));
        $pageIcon  = '◇';
        break;
    case 'project':
        $pageTitle = sl_type_label('project', true);
        $pageIcon  = '◆';
        break;
    default:
        $pageTitle = sl_type_label('article', true);
        $pageIcon  = '◉';
}
?>

<div class="list-page">

    <header class="list-header">
        <span class="list-icon" aria-hidden="true"><?php echo $pageIcon; ?></span>
        <h1 class="list-title"><?php echo $pageTitle; ?></h1>
    </header>

    <?php if (!empty($projects) && ($list_type === 'project' || $list_type === 'category' || $list_type === 'tag')): ?>
    <section class="list-section">
        <?php if ($list_type !== 'project'): ?>
        <h2 class="list-section-title"><?php echo sl_type_label('project', true); ?></h2>
        <?php endif; ?>
        <div class="bento-grid" id="bento-grid">
            <?php foreach ($projects as $i => $project):
                $cat       = !empty($project['category']) ? sanitizeSlug($project['category']) : null;
                $link      = cleanUrl('project', sl_effective_slug($project), null, $cat);
                $accentCls = function_exists('portfolio_accent_class') ? portfolio_accent_class($i) : '';
                $bentoCls  = function_exists('portfolio_bento_size')   ? portfolio_bento_size($i)   : 'bento-md';
            ?>
            <article class="bento-card <?php echo $bentoCls . ' ' . $accentCls; ?>" data-reveal>
                <?php if (!empty($project['image'])): ?>
                <div class="bento-img">
                    <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>"
                         alt="<?php echo htmlspecialchars($project['title']); ?>"
                         loading="lazy">
                </div>
                <?php endif; ?>
                <div class="bento-body">
                    <div class="bento-meta">
                        <?php if (!empty($project['category'])): ?>
                        <span class="bento-cat"><?php echo htmlspecialchars($project['category']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($project['date']) && !empty($project['show_date'])): ?>
                        <span class="bento-date"><?php echo format_date($project['date']); ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="bento-title"><a href="<?php echo $link; ?>"><?php echo htmlspecialchars($project['title']); ?></a></h3>
                    <?php if (!empty($project['description'])): ?>
                    <p class="bento-desc"><?php echo htmlspecialchars(mb_strimwidth(strip_tags($project['description']), 0, 100, '…')); ?></p>
                    <?php endif; ?>
                    <a href="<?php echo $link; ?>" class="bento-link" aria-label="<?php echo htmlspecialchars($project['title']); ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php elseif ($list_type === 'project' && empty($projects)): ?>
    <p class="list-empty"><?php echo sprintf(__t('no_type_found'), sl_type_label('project', true)); ?></p>
    <?php endif; ?>

    <?php if (!empty($articles) && $list_type !== 'project'): ?>
    <section class="list-section">
        <?php if ($list_type === 'category' || $list_type === 'tag'): ?>
        <h2 class="list-section-title"><?php echo sl_type_label('article', true); ?></h2>
        <?php endif; ?>
        <div class="article-scroll-row">
            <?php foreach ($articles as $i => $article):
                $cat  = !empty($article['category']) ? sanitizeSlug($article['category']) : null;
                $link = cleanUrl('article', sl_effective_slug($article), null, $cat);
            ?>
            <article class="scroll-card" data-reveal>
                <?php if (!empty($article['image'])): ?>
                <div class="scroll-card-img">
                    <img src="<?php echo getBaseUrl() . htmlspecialchars($article['image']); ?>"
                         alt="<?php echo htmlspecialchars($article['title']); ?>"
                         loading="lazy">
                </div>
                <?php endif; ?>
                <div class="scroll-card-body">
                    <?php if (!empty($article['tags']) && is_array($article['tags'])): ?>
                    <div class="scroll-card-tags">
                        <?php foreach (array_slice($article['tags'], 0, 2) as $tag): ?>
                        <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . sanitizeSlug($tag) . '/'; ?>" class="tag-pill"><?php echo htmlspecialchars($tag); ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <h3><a href="<?php echo $link; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h3>
                    <p><?php echo get_article_summary($article, 120); ?></p>
                    <a href="<?php echo $link; ?>" class="read-more-link"><?php echo __t('read_more'); ?> &rarr;</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php elseif ($list_type === 'article' && empty($articles)): ?>
    <p class="list-empty"><?php echo sprintf(__t('no_type_found'), sl_type_label('article', true)); ?></p>
    <?php endif; ?>

</div>
