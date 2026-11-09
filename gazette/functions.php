<?php
// Theme i18n — merge theme-specific strings into the active language pack.
// The theme ships its own lang/{locale}.json files so these strings do not
// pollute the CMS core language files. Merged after lang_load() has already
// populated $_LANG_STRINGS, so core keys always take priority.
(function () {
    $locale    = lang_current();
    $themeDir  = __DIR__ . '/lang/';
    $themeLang = $themeDir . $locale . '.json';

    if (!file_exists($themeLang)) {
        $themeLang = $themeDir . 'en.json';
    }

    if (!file_exists($themeLang)) {
        return;
    }

    $strings = json_decode(file_get_contents($themeLang), true);
    if (!is_array($strings)) {
        return;
    }

    unset($strings['_meta']);

    $core = lang_load();
    $GLOBALS['_LANG_STRINGS'] = array_merge($strings, $core);
})();

function gazette_masthead_date(string $locale): string
{
    if (class_exists('IntlDateFormatter')) {
        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::NONE);
        $formatted = $formatter->format(time());
        if ($formatted !== false) return $formatted;
    }
    return date('Y-m-d');
}

// Sidebar widget: the N most recent articles, each shown with a dated stub
// (day number + month) rather than a plain list — the theme's signature
// "latest articles by date" module, reused on every page.
function gazette_render_sidebar_archive(int $limit = 8): string
{
    $articles = sl_load_index('article');
    usort($articles, function ($a, $b) {
        return strtotime($b['date'] ?? '') <=> strtotime($a['date'] ?? '');
    });
    $articles = array_slice($articles, 0, $limit);
    if (empty($articles)) return '';

    ob_start(); ?>
    <aside class="gazette-sidebar">
        <h2 class="gazette-sidebar-title"><?php echo hsc(sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true))); ?></h2>
        <ul class="gazette-archive-list">
            <?php foreach ($articles as $article):
                $slug    = !empty($article['custom_slug']) ? $article['custom_slug'] : $article['slug'];
                $catSlug = !empty($article['category']) ? sanitizeSlug($article['category']) : null;
                $link    = cleanUrl('article', $slug, null, $catSlug);
                $ts      = strtotime($article['date'] ?? '');
            ?>
            <li class="gazette-archive-item">
                <a href="<?php echo $link; ?>" class="gazette-archive-link">
                    <span class="gazette-archive-date">
                        <span class="gazette-archive-day"><?php echo $ts ? hsc(date('d', $ts)) : '—'; ?></span>
                        <span class="gazette-archive-month"><?php echo $ts ? hsc(strtoupper(date('M', $ts))) : ''; ?></span>
                    </span>
                    <span class="gazette-archive-title"><?php echo hsc($article['title']); ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <?php
    return ob_get_clean();
}
