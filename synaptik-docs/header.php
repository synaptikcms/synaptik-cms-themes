<?php
$bodyClass = function_exists('theme_body_class') ? theme_body_class() : 'theme-synaptik-docs';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preload" as="font" type="font/woff2" crossorigin href="<?php echo getBaseUrl(); ?>theme/synaptik-docs/css/fonts/Inter-Variable.woff2">
	<script src="<?php echo getBaseUrl(); ?>theme/synaptik-docs/js/theme-pref.js<?php echo _asset_version(__DIR__ . '/js/theme-pref.js'); ?>" data-key="synaptikdocs_theme" data-fallback="system"></script>
	<base href="<?php echo getBaseUrl(); ?>">
	<title><?php echo $metaTitle; ?></title>
	<?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
	<?php echo render_header_scripts($headerScripts); ?>
	<?php echo render_site_favicon($settings); ?>
</head>
<body class="<?php echo $bodyClass; ?>"><script src="<?php echo getBaseUrl(); ?>theme/synaptik-docs/js/theme-pref.js<?php echo _asset_version(__DIR__ . '/js/theme-pref.js'); ?>" data-key="synaptikdocs_sidebar_collapsed" data-only="1" data-mode="class" data-class="sidebar-collapsed"></script>
<?php render_adminbar(); ?>
<div class="sidebar-overlay" id="sidebar-overlay" aria-hidden="true"></div>
<button class="docs-burger" id="docs-burger" aria-label="Toggle navigation" aria-expanded="false" aria-controls="docs-sidebar">
	<span></span><span></span><span></span>
</button>
<?php if (function_exists('docs_render_sidebar')) echo docs_render_sidebar($settings); ?>
<div class="docs-main" id="docs-main">
	<header class="docs-topbar">
		<a href="<?php echo cleanUrl('home'); ?>" class="topbar-logo">
			<span class="topbar-logo-mark"><?php echo render_site_logo($settings) ?></span>
			<span class="topbar-logo-name"><?php echo htmlspecialchars($settings['site_title'] ?? 'Synaptik CMS'); ?></span>
		</a>
		<nav class="topbar-nav" aria-label="Main navigation">
			<?php echo renderHierarchicalMenu($settings, $data); ?>
		</nav>
		<div class="topbar-right">
			<button class="docs-sidebar-toggle" id="docs-sidebar-toggle" aria-label="Toggle sidebar">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="9" y1="3" x2="9" y2="21"/></svg>
			</button>
			<div class="docs-search-wrap">
				<svg class="docs-search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none"
				     stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
				     aria-hidden="true">
					<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
				</svg>
				<input
					type="search"
					id="docs-nav-search"
					class="docs-search-input"
					placeholder="<?php echo htmlspecialchars(__t('search_placeholder') ?: 'Search…'); ?>"
					autocomplete="off"
					role="combobox"
					aria-label="<?php echo htmlspecialchars(__t('search_placeholder') ?: 'Search'); ?>"
					aria-expanded="false"
					aria-haspopup="listbox">
				<kbd class="docs-search-kbd">⌘K</kbd>
				<button class="docs-search-clear" id="docs-search-clear" aria-label="Clear search" hidden>
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
			</div>
			<button class="docs-search-mobile" id="search-toggle" aria-label="Search">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			</button>
			<button class="docs-theme-toggle" id="docs-theme-toggle" aria-label="Toggle light/dark mode">
				<svg class="icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
				<svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
			</button>
			<a href="https://github.com/synaptikcms/synaptik-cms" class="topbar-github" aria-label="GitHub" target="_blank" rel="noopener">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
			</a>
		</div>
	</header>
	<main class="docs-content" id="main-content">