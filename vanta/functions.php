<?php
/**
 * Vanta Theme — functions.php
 *
 * Theme-specific helpers loaded after all CMS core libraries.
 * Do not redefine core CMS functions — use partials to override card rendering.
 */

/**
 * Return space-separated body CSS classes for the current request.
 *
 * @return string
 */
function vanta_body_class(): string
{
    $type = $_GET['type'] ?? '';
    $slug = $_GET['slug'] ?? '';

    $classes = ['theme-vanta'];

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
 * Return a "back to list" anchor for single-item pages.
 *
 * @param  string $type  Content type: article | project | page
 * @return string HTML anchor
 */
function vanta_back_link(string $type): string
{
    $label = sl_type_label($type, true);
    $url = cleanUrl($type);

    return '<a href="' . $url . '" class="single-back">'
        . htmlspecialchars($label)
        . '</a>';
}
