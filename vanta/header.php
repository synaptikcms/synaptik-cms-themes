<?php
/**
 * Vanta Theme — header.php
 *
 * Full-width top-navigation layout.
 * Injected variables: $settings, $data, $pageTitle, $metaTitle, $metaDescription,
 *                     $metaKeywords, $ogImage, $type, $slug, $headerScripts
 */
$bodyClass = function_exists('vanta_body_class') ? vanta_body_class() : 'theme-vanta';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $metaTitle; ?></title>
    <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Barlow+Condensed:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700;1,800&family=Barlow:ital,wght@0,300;0,400;0,500;1,300;1,400&display=swap">
    <?php echo render_site_favicon($settings); ?>
    <?php echo render_header_scripts($headerScripts); ?>
    <?php if (function_exists('render_site_favicon')) echo render_site_favicon($settings); ?>
</head>
<body class="<?php echo $bodyClass; ?>">

<div id="vanta-progress" aria-hidden="true"></div>

<div class="site-wrap">

    <!-- ── Top Navigation ─────────────────────────────────── -->
    <nav class="site-nav" aria-label="<?php echo __t('toggle_menu') ?: 'Main navigation'; ?>">

        <a href="<?php echo cleanUrl('home'); ?>" class="nav-brand" aria-label="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>">
            <?php
            $logoHtml = function_exists('render_site_logo') ? render_site_logo($settings, 'nav-logo-img') : '';
            if ($logoHtml) echo $logoHtml;
            ?>
            <span class="nav-brand-name"><?php echo htmlspecialchars($settings['site_title'] ?? 'My Site'); ?></span>
        </a>

        <div class="nav-links" role="list">
            <?php echo renderHierarchicalMenu($settings, $data); ?>
        </div>

        <div class="nav-right">
            <?php if (empty($settings['show_search_icon']) || $settings['show_search_icon']): ?>
            <div class="nav-search-wrap">
                <label for="vanta-nav-search" class="sr-only"><?php echo __t('search_placeholder') ?: 'Search'; ?></label>
                <svg class="nav-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    type="search"
                    id="vanta-nav-search"
                    class="nav-search-input"
                    placeholder="<?php echo htmlspecialchars(__t('search_placeholder') ?: 'Search…'); ?>"
                    autocomplete="off"
                    aria-label="<?php echo htmlspecialchars(__t('search_placeholder') ?: 'Search'); ?>">
                <kbd class="nav-search-kbd">⌘K</kbd>
            </div>
            <?php endif; ?>
            <button
                class="nav-burger"
                id="vanta-burger"
                aria-label="<?php echo __t('toggle_menu') ?: 'Toggle navigation'; ?>"
                aria-expanded="false"
                aria-controls="vanta-drawer">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

    </nav>

    <!-- ── Mobile nav drawer ──────────────────────────────── -->
    <div class="nav-drawer" id="vanta-drawer" aria-label="Mobile navigation">
        <?php echo renderHierarchicalMenu($settings, $data); ?>
    </div>

    <main class="site-main" id="main-content">
