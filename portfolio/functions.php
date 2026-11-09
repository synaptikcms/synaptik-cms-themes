<?php
/**
 * Portfolio Theme — functions.php
 * Theme-specific helpers for Synaptik CMS Portfolio theme.
 */

/**
 * Return body CSS classes for the current request context.
 *
 * @return string Space-separated CSS class string
 */
function theme_body_class(): string
{
    $type = $_GET['type'] ?? '';
    $slug = $_GET['slug'] ?? '';

    $classes = ['theme-portfolio'];

    if (empty($type) && empty($slug)) {
        $classes[] = 'is-home';
    } elseif (!empty($type) && empty($slug)) {
        $classes[] = 'is-list';
        $classes[] = 'is-list--' . htmlspecialchars($type);
    } elseif (!empty($slug)) {
        $classes[] = 'is-single';
        $classes[] = 'is-single--' . htmlspecialchars($type);
    }

    return implode(' ', $classes);
}

/**
 * Return a deterministic accent-color class for a card based on its index.
 * Cycles through the theme's accent palette so the grid looks colorful.
 *
 * @param int $index Card position
 * @return string CSS class name
 */
function portfolio_accent_class(int $index): string
{
    $accents = ['accent-coral', 'accent-violet', 'accent-teal', 'accent-amber', 'accent-rose', 'accent-sky'];
    return $accents[$index % count($accents)];
}

/**
 * Return a deterministic size class for bento-grid items.
 * Creates visual rhythm by varying card sizes.
 *
 * @param int $index Card position
 * @return string CSS class name
 */
function portfolio_bento_size(int $index): string
{
    $pattern = ['bento-lg', 'bento-sm', 'bento-sm', 'bento-md', 'bento-md'];
    return $pattern[$index % count($pattern)];
}
