<?php
/**
 * Axion Theme for Synaptik CMS — header.php
 * Floating pill navigation: brand + menu grouped in a centered capsule,
 * CTA in a separate pill aligned to the right.
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
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">
  <?php echo render_site_favicon($settings); ?>
  <?php echo render_header_scripts($headerScripts); ?>
</head>
<body class="theme-Axion">
<?php render_adminbar(); ?>
<div class="ax-header" id="ax-header" role="banner">
  <div class="ax-header-row">
    <div class="ax-pill ax-pill--main" id="ax-pill">
      <a href="<?php echo cleanUrl('home'); ?>" class="ax-brand" aria-label="<?php echo htmlspecialchars($settings['site_title']); ?>">
        <?php $logo = render_site_logo($settings); ?>
        <?php if ($logo): ?>
          <span class="ax-brand-logo"><?php echo $logo; ?></span>
        <?php else: ?>
          <span class="ax-brand-mark" aria-hidden="true">
            <svg width="34" height="34" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g stroke="currentColor" stroke-width="0.6" fill="none" opacity="0.85">
                <ellipse cx="32" cy="32" rx="22" ry="9" transform="rotate(0 32 32)"/>
                <ellipse cx="32" cy="32" rx="22" ry="9" transform="rotate(60 32 32)"/>
                <ellipse cx="32" cy="32" rx="22" ry="9" transform="rotate(120 32 32)"/>
                <ellipse cx="32" cy="32" rx="18" ry="7" transform="rotate(30 32 32)" opacity="0.5"/>
                <ellipse cx="32" cy="32" rx="18" ry="7" transform="rotate(90 32 32)" opacity="0.5"/>
                <ellipse cx="32" cy="32" rx="18" ry="7" transform="rotate(150 32 32)" opacity="0.5"/>
              </g>
            </svg>
          </span>
        <?php endif; ?>
        <?php if (!empty($settings['show_site_title_in_header'])): ?>
          <span class="ax-brand-title"><?php echo htmlspecialchars($settings['site_title']); ?></span>
        <?php endif; ?>
      </a>
      <nav class="ax-nav" id="ax-nav" aria-label="Main navigation">
        <?php echo renderHierarchicalMenu($settings, $data); ?>
      </nav>
      <button class="ax-burger" id="ax-burger" aria-controls="ax-nav" aria-expanded="false" aria-label="<?php echo __t('toggle_menu'); ?>">
        <span></span><span></span>
      </button>
    </div>
    <div class="ax-pill ax-pill--cta">
      <?php echo render_search_icon(); ?>
      <a href="<?php echo cleanUrl('home'); ?>contact" class="ax-cta-link"><?php echo __t('get_in_touch', 'Get in touch'); ?></a>
    </div>
  </div>
</div>
<main id="main-content" class="ax-main">
<?php do_theme_action('before_content'); ?>