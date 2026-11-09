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
<header class="site-header">
    <a href="<?php echo cleanUrl('home'); ?>" class="site-brand">
        <?php echo render_site_logo($settings); ?>
        <?php echo hsc($settings['site_title'] ?? 'My Site'); ?>
    </a>
    <?php if (!empty($settings['site_description'])): ?>
    <p class="site-tagline"><?php echo hsc($settings['site_description']); ?></p>
    <?php endif; ?>
    <label for="nav-toggle" class="nav-toggle-label" aria-label="Menu">&#9776;</label>
    <nav class="site-nav" aria-label="Main navigation">
        <?php echo renderHierarchicalMenu($settings, $data); ?>
    </nav>
</header>
<main class="site-main" id="main-content">
