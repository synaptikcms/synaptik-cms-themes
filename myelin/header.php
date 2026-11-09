<?php
/**
 * Myelin Theme for Synaptik CMS — header.php
 * Sticky top navigation with hover dropdowns, inline SVG logo, and adminbar support.
 */
?><!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $metaTitle; ?></title>
  <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Inter:wght@400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap">
  <?php echo render_site_favicon($settings); ?>
  <?php echo render_header_scripts($headerScripts); ?>
</head>
<body class="theme-myelin">
<?php render_adminbar(); ?>

<header class="my-header" id="my-header">
  <div class="my-header-inner">
    <a href="<?php echo cleanUrl('home'); ?>" class="my-brand" aria-label="<?php echo htmlspecialchars($settings['site_title']); ?>">
      <?php $logo = render_site_logo($settings); ?>
      <?php if ($logo): ?>
        <span class="my-brand-logo"><?php echo $logo; ?></span>
      <?php else: ?>
        <span class="my-brand-mark" aria-hidden="true">
          <svg width="22" height="22" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="16" cy="16" r="3" fill="currentColor"/>
            <circle cx="5" cy="8" r="2" fill="currentColor"/>
            <circle cx="5" cy="24" r="2" fill="currentColor"/>
            <circle cx="27" cy="8" r="2" fill="currentColor"/>
            <circle cx="27" cy="24" r="2" fill="currentColor"/>
            <path d="M7 8 L13.5 14.5 M7 24 L13.5 17.5 M25 8 L18.5 14.5 M25 24 L18.5 17.5"
                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </span>
      <?php endif; ?>
      <?php if (!empty($settings['show_site_title_in_header'])): ?>
        <span class="my-brand-title"><?php echo htmlspecialchars($settings['site_title']); ?></span>
      <?php endif; ?>
    </a>

    <nav class="my-nav" id="my-nav" aria-label="Main navigation">
      <?php echo renderHierarchicalMenu($settings, $data); ?>
    </nav>

    <div class="my-header-actions">
      <?php if (($settings['show_search_icon'] ?? true) !== false): ?>
      <ul class="my-header-search">
        <li class="search-icon">
          <a href="#" id="search-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </a>
        </li>
      </ul>
      <?php endif; ?>
      <button class="my-nav-toggle" id="my-nav-toggle" aria-controls="my-nav" aria-expanded="false" aria-label="<?php echo __t('toggle_menu'); ?>">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<main id="main-content" class="my-main">
<?php do_theme_action('before_content'); ?>
