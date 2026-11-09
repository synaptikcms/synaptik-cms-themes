<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $metaTitle; ?></title>
    <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap">
    <?php echo render_header_scripts($headerScripts); ?>
    <?php echo render_site_favicon($settings); ?>
    <script data-key="ink_theme" data-fallback="system">
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
<body class="theme-ink">
<?php render_adminbar(); ?>

<div class="ink-modal-nav" id="ink-modal-nav" aria-hidden="true" role="dialog" inert>
    <div class="ink-modal-inner">
        <div class="ink-modal-search">
            <input type="text" id="ink-modal-search-input" placeholder="<?php echo __t('search_placeholder') ?: 'Search…'; ?>" autocomplete="off">
            <button class="ink-search-clear" id="ink-search-clear" aria-label="Clear" hidden>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="ink-search-results" id="ink-search-results"></div>
        </div>
        <nav class="ink-modal-menu" aria-label="Navigation">
            <?php echo renderHierarchicalMenu($settings, $data); ?>
        </nav>
    </div>
</div>
<div class="ink-overlay" id="ink-overlay" aria-hidden="true"></div>

<header class="ink-header">
    <div class="ink-header-inner">
        <a href="<?php echo cleanUrl('home'); ?>" class="ink-logo" aria-label="<?php echo htmlspecialchars($settings['site_title'] ?? 'Home'); ?>">
            <?php
            $logo = render_site_logo($settings, 'ink-logo-img');
            if ($logo) {
                echo $logo;
            } else {
                echo '<span class="ink-logo-text">' . htmlspecialchars($settings['site_title'] ?? 'Blog') . '</span>';
            }
            ?>
        </a>
        <div class="ink-header-right">
            <nav class="ink-nav" aria-label="Main navigation">
                <?php echo renderHierarchicalMenu($settings, $data); ?>
            </nav>
          
            <button class="ink-theme-toggle" id="ink-theme-toggle" aria-label="Toggle light/dark mode">
                <svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                <svg class="icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
            </button>
            <button class="ink-burger" id="ink-burger" aria-label="<?php echo __t('toggle_menu') ?: 'Toggle navigation'; ?>" aria-expanded="false" aria-controls="ink-modal-nav">
                <span class="ink-burger-line"></span>
                <span class="ink-burger-line"></span>
                <span class="ink-burger-line"></span>
            </button>
        </div>
    </div>
</header>

<main class="ink-main" id="main-content">
