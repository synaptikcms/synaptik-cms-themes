<?php
/**
 * Ink Theme — functions.php
 * Post-processes shortcode HTML to inject SVG icons matching the theme's card style.
 */

$isCli   = PHP_SAPI === 'cli';
$isAdmin = strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/') !== false;
$isAdmin = $isAdmin || strpos($_SERVER['REQUEST_URI'] ?? '', '/portail/') !== false;

if (!$isCli && !$isAdmin) {
    ob_start(function (string $html): string {

        // ── [recent_articles] — inject tag icon + circled plus on read-more ──
        if (strpos($html, 'sc-articles-grid') !== false) {
            $tagIcon = '<svg class="ink-sc-tag-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>';
            $plusIcon = '<span class="ink-card-plus" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>';

            // Inject tag icon before first tag link inside .article-tags
            $html = preg_replace(
                '/(<div class="article-tags">)/',
                '$1' . $tagIcon,
                $html
            );

            // Inject circled plus before read-more text
            $html = preg_replace(
                '/(<a href="[^"]*" class="read-more">)/',
                '$1' . $plusIcon,
                $html
            );
        }

        // ── [recent_projects] — inject tag icon + circled plus on view-project ──
        if (strpos($html, 'sc-projects-grid') !== false) {
            $tagIcon = '<svg class="ink-sc-tag-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>';
            $plusIcon = '<span class="ink-card-plus" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>';

            $html = preg_replace(
                '/(<div class="article-tags">)/',
                '$1' . $tagIcon,
                $html
            );

            $html = preg_replace(
                '/(<a href="[^"]*" class="view-project">)/',
                '$1' . $plusIcon,
                $html
            );
        }

        return $html;
    });
}
