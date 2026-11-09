<?php
// Renders a list of articles as the theme's signature timeline rail — a thin
// vertical line with a dot per entry, date label, title, and an optional
// excerpt. Shared by the homepage, list/tag/category archives, and the
// Changelog page template so the "latest by date" treatment stays consistent
// everywhere it appears.
function dispatch_render_timeline(array $articles, bool $showExcerpt = true): string
{
    if (empty($articles)) return '';

    ob_start(); ?>
    <ul class="dispatch-list">
        <?php foreach ($articles as $article):
            $slug    = !empty($article['custom_slug']) ? $article['custom_slug'] : $article['slug'];
            $catSlug = !empty($article['category']) ? sanitizeSlug($article['category']) : null;
            $link    = cleanUrl('article', $slug, null, $catSlug);
            $ts      = strtotime($article['date'] ?? '');
        ?>
        <li class="dispatch-item">
            <?php if ($ts): ?>
            <span class="dispatch-date"><?php echo hsc(strtoupper(date('M j, Y', $ts))); ?></span>
            <?php endif; ?>
            <h3 class="dispatch-item-title"><a href="<?php echo $link; ?>"><?php echo hsc($article['title']); ?></a></h3>
            <?php if ($showExcerpt):
                $summary = get_article_summary($article, 120);
                if ($summary !== ''): ?>
            <p class="dispatch-excerpt"><?php echo $summary; ?></p>
            <?php endif; endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php
    return ob_get_clean();
}
