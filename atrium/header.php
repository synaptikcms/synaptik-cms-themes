<?php
/**
 * Atrium Theme for Synaptik CMS — header.php
 *
 * Editorial gallery-grade page shell. Minimal nav, oversized serif identity,
 * dark/light bootstrap before paint to avoid flash, animated SVG monogram.
 */
?><!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $metaTitle; ?></title>
  <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
  <?php echo render_site_favicon($settings); ?>
  <?php echo render_header_scripts($headerScripts); ?>
  <script data-key="atrium-theme" data-fallback="system">
	(function () {
		var s = document.currentScript;
		if (!s) return;
		var key = s.getAttribute('data-key');
		if (!key) return;
		var mode = s.getAttribute('data-mode') || 'attr';
		var only = s.getAttribute('data-only');
		var fallback = s.getAttribute('data-fallback');
		try {
			var v = localStorage.getItem(key);
			var shouldApply = false;
			if (only !== null) {
				shouldApply = (v === only);
			} else if (v) {
				shouldApply = true;
			} else if (fallback === 'system') {
				v = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
				shouldApply = true;
			} else if (fallback) {
				v = fallback;
				shouldApply = true;
			}
			if (!shouldApply) return;
			if (mode === 'class') {
				document.body.classList.add(s.getAttribute('data-class') || v);
			} else {
				document.documentElement.setAttribute(s.getAttribute('data-attr') || 'data-theme', v);
			}
		} catch (e) {}
	})();
	</script>
</head>
<body>
<?php render_adminbar(); ?>

<div class="atrium-cursor" id="atrium-cursor" aria-hidden="true"></div>
<div class="atrium-curtain" id="atrium-curtain" aria-hidden="true"></div>

<header class="atrium-header" id="atrium-header">
  <div class="atrium-header-inner">

    <a href="<?php echo cleanUrl('home'); ?>" class="atrium-brand" aria-label="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>">
      <span class="atrium-mark" aria-hidden="true">
        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" focusable="false">
          <g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path class="atrium-mark-stroke atrium-mark-stroke--1" d="M8 40 L24 8 L40 40"/>
            <path class="atrium-mark-stroke atrium-mark-stroke--2" d="M16 28 L32 28"/>
            <circle class="atrium-mark-dot" cx="24" cy="24" r="1.2" fill="currentColor" stroke="none"/>
          </g>
        </svg>
      </span>
      <?php if (!empty($settings['show_site_title_in_header'])): ?>
      <span class="atrium-brand-text"><?php echo htmlspecialchars($settings['site_title'] ?? ''); ?></span>
      <?php endif; ?>
    </a>

    <nav class="atrium-nav" id="atrium-nav" aria-label="<?php echo htmlspecialchars(__t('toggle_menu')); ?>">
      <?php
      // Build the main navigation and tag it with theme-specific classes
      // so menu items can be styled without overriding core markup.
      $menu_html = renderHierarchicalMenu($settings, $data);
      $menu_html = str_replace('<ul>', '<ul class="atrium-nav-list custom-menu-marker">', $menu_html);
      $menu_html = str_replace('<a href', '<a class="atrium-nav-link" data-atrium-link href', $menu_html);
      echo $menu_html;
      ?>
    </nav>

    <div class="atrium-actions">
      <button type="button" class="atrium-icon-btn atrium-theme-toggle" id="atrium-theme-toggle"
              aria-label="<?php echo htmlspecialchars(__t('atrium_toggle_theme', 'Toggle dark mode')); ?>">
        <svg class="atrium-icon atrium-icon-moon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
        <svg class="atrium-icon atrium-icon-sun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.5 14.5A8.5 8.5 0 0 1 9.5 3.5a8.5 8.5 0 1 0 11 11Z"/></svg>
      </button>
      <a href="#" id="search-toggle" class="atrium-icon-btn" aria-label="<?php echo htmlspecialchars(__t('search_in_content')); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      </a>
      <button type="button" class="atrium-icon-btn atrium-burger" id="atrium-burger"
              aria-label="<?php echo htmlspecialchars(__t('toggle_menu')); ?>"
              aria-expanded="false">
        <span></span><span></span>
      </button>
    </div>

  </div>
</header>

<div class="atrium-drawer-backdrop" id="atrium-drawer-backdrop"></div>

<aside class="atrium-drawer" id="atrium-drawer" aria-hidden="true" inert>
  <nav aria-label="<?php echo htmlspecialchars(__t('toggle_menu')); ?>">
    <?php
    $drawer_html = renderHierarchicalMenu($settings, $data);
    $drawer_html = str_replace('<ul>', '<ul class="atrium-drawer-list">', $drawer_html);
    $drawer_html = str_replace('<a href', '<a class="atrium-drawer-link" data-atrium-link href', $drawer_html);
    echo $drawer_html;
    ?>
  </nav>
</aside>

<main id="atrium-main" class="atrium-main">
<?php do_theme_action('before_content'); ?>
