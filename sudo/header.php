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
<div class="ide-shell">
    <aside class="ide-sidebar">
        <a href="<?php echo cleanUrl('home'); ?>" class="ide-brand">
            <?php echo render_site_logo($settings); ?>
            <span class="ide-brand-name"><span class="prompt-sign">$</span> <?php echo hsc($settings['site_title'] ?? 'My Site'); ?><span class="cursor-blink">_</span></span>
        </a>
        <nav class="ide-nav" aria-label="Main navigation">
            <?php echo renderHierarchicalMenu($settings, $data); ?>
        </nav>
        <button type="button" id="search-toggle" class="ide-search-trigger" aria-label="<?php echo hsc(__t('search_placeholder')); ?>">
            <svg aria-hidden="true" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg> grep -r
        </button>
    </aside>
    <div class="ide-content">
        <label for="nav-toggle" class="ide-mobile-bar" aria-label="Menu">
            <span class="ide-mobile-burger" aria-hidden="true">&#9776;</span>
            <span class="ide-brand-name"><span class="prompt-sign">$</span> <?php echo hsc($settings['site_title'] ?? 'My Site'); ?><span class="cursor-blink">_</span></span>
        </label>
        <?php
        $__tab = 'home.md';
        if (!empty($type) && !empty($slug)) {
            $__tabBase = !empty($pageTitle) ? sanitizeSlug($pageTitle) : $slug;
            $__tab = ($__tabBase !== '' ? $__tabBase : $slug) . '.md';
        } elseif (!empty($type)) {
            $__tab = (in_array($type, ['article', 'page', 'project'], true) ? sl_type_label($type, true) : $type) . '/index.md';
        }
        ?>
        <div class="ide-tabbar">
            <span class="ide-tab"><span class="ide-tab-dot" aria-hidden="true"></span><?php echo hsc($__tab); ?></span>
        </div>
        <main class="site-main" id="main-content">
