<!DOCTYPE html>
<html lang="<?php echo hsc($settings['active_language'] ?? 'en'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $metaTitle; ?></title>
    <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
    <?php echo render_header_scripts($headerScripts); ?>
    <?php echo render_site_favicon($settings); ?>
</head>
<body>
<?php render_adminbar(); ?>
<input type="checkbox" id="nav-toggle" class="nav-toggle-input">
<header class="dispatch-header">
    <a href="<?php echo cleanUrl('home'); ?>" class="dispatch-brand">
        <?php echo render_site_logo($settings); ?>
        <?php echo hsc($settings['site_title'] ?? 'My Site'); ?>
    </a>
    <label for="nav-toggle" class="nav-toggle-label" aria-label="Menu">&#9776;</label>
    <nav class="dispatch-nav" aria-label="Main navigation">
        <?php echo renderHierarchicalMenu($settings, $data); ?>
        <button type="button" id="search-toggle" class="search-toggle" aria-label="<?php echo hsc(__t('search_placeholder')); ?>">
            <svg aria-hidden="true" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </button>
    </nav>
</header>
<main class="site-main" id="main-content">
