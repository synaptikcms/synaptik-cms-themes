<?php
$bodyClass = function_exists('theme_body_class') ? theme_body_class() : 'theme-portfolio';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $metaTitle; ?></title>
    <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <?php echo render_site_favicon($settings); ?>
    <?php echo render_header_scripts($headerScripts); ?>
</head>
<body class="<?php echo $bodyClass; ?>">

<div class="site-wrapper">

    <header class="site-header" id="site-header">
        <div class="header-inner">
            <div class="header-brand">
                <?php if (!empty($settings['site_logo'])): ?>
                <a href="<?php echo cleanUrl('home'); ?>" class="brand-logo">
                    <?php echo render_site_logo($settings); ?>
                </a>
                <?php endif; ?>
                <?php if (!empty($settings['show_site_title_in_header']) && $settings['show_site_title_in_header']): ?>
                <a href="<?php echo cleanUrl('home'); ?>" class="brand-name">
                    <?php echo htmlspecialchars($settings['site_title']); ?>
                </a>
                <?php endif; ?>
            </div>

            <nav class="site-nav" id="site-nav" aria-label="Main navigation">
                <?php echo renderHierarchicalMenu($settings, $data); ?>
            </nav>

            <div class="header-actions">
                <?php echo render_search_icon(); ?>
                <button class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-label="<?php echo __t('toggle_menu'); ?>">
                    <span class="nav-toggle-bar"></span>
                    <span class="nav-toggle-bar"></span>
                    <span class="nav-toggle-bar"></span>
                </button>
            </div>
        </div>
    </header>

    <main class="site-main" id="site-main">
