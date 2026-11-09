<?php
/**
 * Prism Theme for Synaptik CMS — header.php
 * Horizontal sticky nav, dark/light toggle, left-side mobile drawer.
 */
?><!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $metaTitle; ?></title>
  <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&display=swap">
  <?php echo render_site_favicon($settings); ?>
  <?php echo render_header_scripts($headerScripts); ?>
  <script data-key="prism-theme" data-fallback="system">
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

<header id="prism-header">
  <div class="prism-nav-inner">

    <?php if ($settings['show_site_title_in_header']): ?>
    <a href="<?php echo cleanUrl('home'); ?>" class="prism-logo">
      <?php echo render_site_logo($settings, 'prism-logo-img'); ?>
      <?php echo render_site_title($settings, $pageTitle); ?>
    </a>
    <?php endif; ?>

    <nav class="prism-nav" id="prism-nav" aria-label="Main navigation">
      <span class="prism-nav-indicator" id="prism-indicator" aria-hidden="true"></span>
      <?php
      $menu_html = renderHierarchicalMenu($settings, $data);
      $menu_html = str_replace('<ul>', '<ul class="prism-nav-list custom-menu-marker">', $menu_html);
      $menu_html = str_replace('<a href', '<a class="prism-nav-link" href', $menu_html);
      echo $menu_html;
      ?>
    </nav>

    <div class="prism-nav-actions">
      <button class="prism-theme-toggle" id="prism-theme-toggle"
              aria-label="<?php echo htmlspecialchars(__t('theme_toggle_dark', 'Dark mode')); ?>">
        <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
      <a href="#" id="search-toggle" class="prism-search-btn" aria-label="Search">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </a>
      <button class="prism-burger" id="prism-burger"
              aria-label="<?php echo htmlspecialchars(__t('toggle_menu')); ?>"
              aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>

  </div>
</header>

<div class="prism-backdrop" id="prism-backdrop"></div>

<aside class="prism-drawer" id="prism-drawer" aria-hidden="true" inert>
  <nav aria-label="Mobile navigation">
    <?php
    $drawer_html = renderHierarchicalMenu($settings, $data);
    $drawer_html = str_replace('<ul>', '<ul class="prism-drawer-list">', $drawer_html);
    $drawer_html = str_replace('<a href', '<a class="prism-drawer-link" href', $drawer_html);
    echo $drawer_html;
    ?>
  </nav>
</aside>

<main id="prism-main">
