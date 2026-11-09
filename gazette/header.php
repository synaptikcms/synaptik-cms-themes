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
<header class="gazette-masthead">
    <div class="gazette-masthead-top">
        <span class="gazette-kicker"><?php echo hsc(gazette_masthead_date($settings['active_language'] ?? 'en')); ?></span>
        <label for="nav-toggle" class="nav-toggle-label" aria-label="<?php echo hsc(__t('toggle_menu', 'Toggle navigation')); ?>">&#9776;</label>
    </div>
    <a href="<?php echo cleanUrl('home'); ?>" class="gazette-title">
        <?php echo render_site_logo($settings); ?>
        <?php echo hsc($settings['site_title'] ?? 'My Site'); ?>
    </a>
    <?php if (!empty($settings['site_description'])): ?>
    <p class="gazette-tagline"><?php echo hsc($settings['site_description']); ?></p>
    <?php endif; ?>
    <nav class="gazette-nav" aria-label="<?php echo hsc(__t('main_navigation', 'Main navigation')); ?>">
        <?php echo renderHierarchicalMenu($settings, $data); ?>
        <?php $searchIcon = render_search_icon(); ?>
        <?php if ($searchIcon !== ''): ?>
        <ul class="gazette-nav-utility"><?php echo $searchIcon; ?></ul>
        <?php endif; ?>
    </nav>
</header>
<main class="site-main" id="main-content">
