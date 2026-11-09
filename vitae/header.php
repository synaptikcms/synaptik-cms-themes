<?php
$isHome    = is_home();
$bodyClass = 'theme-vitae' . ($isHome ? ' is-home' : '');
// Site title + description for sidebar sub-label
$siteTitle = $settings['site_title'] ?? '';
$siteSub   = $settings['site_description'] ?? '';
// Clamp sub for the sidebar — increase this value to show more text
if (mb_strlen($siteSub) > 80) $siteSub = mb_substr($siteSub, 0, 78) . '…';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $metaTitle; ?></title>
    <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
    <?php echo render_header_scripts($headerScripts); ?>
    <?php echo render_site_favicon($settings); ?>
    <!-- Apply saved theme before paint to avoid flash -->
    <script data-key="vt-theme" data-fallback="system">
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
    <?php
    // JSON-LD Person schema — home page only, driven by schema_type in vitae_options.
    // Helps Google understand the site as a personal portfolio and may trigger
    // rich results / Knowledge Panel for the person's name.
    if (is_home() && vitae_option('schema_type', 'Person') === 'Person'):
        $schemaName  = htmlspecialchars($settings['site_title'] ?? '', ENT_QUOTES);
        $schemaDesc  = htmlspecialchars($settings['site_description'] ?? '', ENT_QUOTES);
        $schemaUrl   = rtrim(getBaseUrl(), '/');
        $sameAs      = [];
        if (!empty($settings['footer_show_social']) && !empty($settings['footer_social_links'])) {
            foreach ($settings['footer_social_links'] as $sl) {
                if (!empty($sl['url'])) $sameAs[] = $sl['url'];
            }
        }
        $schema = [
            '@context' => 'https://schema.org',
            '@type'    => 'Person',
            'name'     => $settings['site_title'] ?? '',
            'url'      => $schemaUrl,
        ];
        if (!empty($schemaDesc))  $schema['description'] = $settings['site_description'];
        if (!empty($sameAs))      $schema['sameAs']      = $sameAs;
        echo '  <script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    endif;
    ?>
</head>
<body class="<?php echo $bodyClass; ?>">
<?php render_adminbar(); ?>

<div class="vt-wrap">

    <!-- Fixed side navigation -->
    <nav class="vt-sidenav" id="vt-sidenav" aria-label="<?php echo __t('toggle_menu'); ?>">

        <!-- Logo / identity -->
        <div class="vt-nav-top">
            <a href="<?php echo cleanUrl('home'); ?>" class="vt-logo" aria-label="<?php echo htmlspecialchars($siteTitle); ?>">
                <?php
                $logo = render_site_logo($settings, 'vt-logo-img');
                if ($logo) {
                    echo $logo;
                } else {
                    $initials = '';
                    foreach (array_slice(explode(' ', $siteTitle ?: 'S'), 0, 2) as $w) {
                        $initials .= mb_strtoupper(mb_substr($w, 0, 1));
                    }
                    echo '<span class="vt-logo-mark">' . htmlspecialchars($initials) . '</span>';
                }
                ?>
                <span class="vt-logo-text">
                    <span class="vt-logo-title"><?php echo htmlspecialchars($siteTitle); ?></span>
                    <?php if ($siteSub): ?>
                    <span class="vt-logo-sub"><?php echo htmlspecialchars($siteSub); ?></span>
                    <?php endif; ?>
                </span>
            </a>
        </div>

        <!-- Navigation links -->
        <div class="vt-nav-menu">
            <?php echo renderHierarchicalMenu($settings, $data); ?>
        </div>

        <!-- Footer: search + theme toggle + social -->
        <div class="vt-nav-foot">
            <!-- Search -->
            <ul style="list-style:none;padding:0;margin:0"><?php echo render_search_icon(); ?></ul>

            <!-- Social icons -->
            <?php if (!empty($settings['footer_show_social']) && !empty($settings['footer_social_links'])): ?>
            <div class="vt-social">
                <?php foreach ($settings['footer_social_links'] as $s): ?>
                    <?php if (!empty($s['platform']) && !empty($s['url'])): ?>
                    <a href="<?php echo htmlspecialchars($s['url']); ?>" class="vt-social-link" target="_blank" rel="noopener" aria-label="<?php echo htmlspecialchars($s['platform']); ?>">
                        <?php echo get_social_icon($s['platform']); ?>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Dark / light toggle -->
            <button class="vt-theme-toggle" id="vt-theme-toggle" aria-label="Toggle dark/light mode">
                <!-- Moon: shown in dark mode (click to switch to light) -->
                <svg class="icon-moon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
                <!-- Sun: shown in light mode (click to switch to dark) -->
                <svg class="icon-sun" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="5"/>
                    <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
            </button>
        </div>

    </nav>

    <!-- Mobile burger -->
    <button class="vt-burger" id="vt-burger" aria-label="<?php echo __t('toggle_menu'); ?>" aria-expanded="false" aria-controls="vt-sidenav">
        <span></span><span></span><span></span>
    </button>

    <!-- Content column: main + footer stacked vertically -->
    <div class="vt-col">
        <main class="vt-main" id="vt-main">
