<?php
$allPages    = sl_load_index('page');
$allArticles = sl_load_index('article');
usort($allPages, fn($a,$b) => ($a['menu_order']??99)<=>($b['menu_order']??99));
$menuPages      = array_values(array_filter($allPages, fn($p) => !empty($p['show_in_menu'])));
$recentArticles = docs_get_recently_updated((int)($settings['articles_per_page'] ?? 6));
?>
<div class="docs-home">
	<div class="docs-hero">
		<?php $statusBadge = docs_render_status_badge(); ?>
		<?php if ($statusBadge !== ''): ?>
		<?php echo $statusBadge; ?>
		<?php else: ?>
		<div class="docs-hero-badge">Documentation</div>
		<?php endif; ?>
		<h1 class="docs-hero-title"><?php echo htmlspecialchars($settings['site_title'] ?? 'Documentation'); ?></h1>
		<?php if (!empty($settings['site_description'])): ?>
		<p class="docs-hero-lead"><?php echo htmlspecialchars($settings['site_description']); ?></p>
		<?php endif; ?>
		<div class="docs-hero-badges">
			<img src="https://img.shields.io/badge/PHP-8.3%2B-777bb4?style=flat&logo=php&logoColor=white" height="32" alt="PHP version badge">
			<img src="https://img.shields.io/github/v/release/synaptikcms/synaptik-cms?style=flat&color=f97316&label=latest" height="32" alt="Latest version badge">
			<img src="https://img.shields.io/badge/license-MIT-22c55e?style=flat" height="32" alt="License badge">
			<img src="https://img.shields.io/badge/footprint-2MB-14b8a6?style=flat" height="32" alt="Footprint installation size badge">
			<img src="https://img.shields.io/badge/no-database-e11d48?style=flat" height="32" alt="No database badge">
			<img src="https://img.shields.io/badge/zero-dependencies-0ea5e9?style=flat" height="32" alt="No dependencies badge">
			<img src="https://img.shields.io/github/stars/synaptikcms/synaptik-cms?style=flat&color=f59e0b&label=stars" height="32" alt="Number of GitHub stars badge">
			<img src="https://img.shields.io/github/downloads/synaptikcms/synaptik-cms/total?style=flat&color=8b5cf6&label=downloads" height="32" alt="Total downloads badge">
			<img src="https://img.shields.io/github/downloads-pre/synaptikcms/synaptik-cms/latest/total?style=flat&color=6366f1&label=downloads%40latest" height="32" alt="Latest version downloads badge">
		</div>
		<br>
		<?php if (!empty($menuPages)):
			$first = $menuPages[0];
			$firstCat = !empty($first['category']) ? sanitizeSlug($first['category']) : null;
			$firstUrl = cleanUrl('page', sl_effective_slug($first), null, $firstCat);
		?>
		<div class="docs-hero-actions">
			<a href="/getting-started/" class="docs-btn-primary">Getting started →</a>
			<a href="https://synaptikcms.com/download?f=synaptik-cms" class="docs-btn-primary" style="background: #7ba7dc; gap: 5px;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Download Latest </a>
			<a href="https://github.com/synaptikcms/synaptik-cms" class="docs-btn-ghost" target="_blank" rel="noopener">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
				GitHub
			</a>
		</div>
		<?php endif; ?>
	</div>
	<?php if (!empty($menuPages)): ?>
	<section class="docs-home-section">
		<h2 class="docs-home-section-title">Documentation</h2>
		<div class="docs-home-grid">
			<?php foreach ($menuPages as $page):
				$catSlug = !empty($page['category']) ? sanitizeSlug($page['category']) : null;
				$url = cleanUrl('page', sl_effective_slug($page), null, $catSlug);
			?>
			<a href="<?php echo $url; ?>" class="docs-home-card">
				<div class="docs-home-card-icon">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
				</div>
				<div class="docs-home-card-body">
					<div class="docs-home-card-title"><?php echo htmlspecialchars($page['title']); ?></div>
					<?php if (!empty($page['summary'])): ?>
					<div class="docs-home-card-desc"><?php echo htmlspecialchars($page['summary']); ?></div>
					<?php endif; ?>
				</div>
				<div class="docs-home-card-arrow">→</div>
			</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>
	<?php if (!empty($recentArticles)): ?>
	<section class="docs-home-section">
		<h2 class="docs-home-section-title">Recent Doc Updates</h2>
		<div class="docs-home-articles">
			<?php $catStore = sl_load_categories(); ?>
			<?php foreach ($recentArticles as $article):
				$catSlug = !empty($article['category']) ? sanitizeSlug($article['category']) : null;
				$url = cleanUrl('article', sl_effective_slug($article), null, $catSlug);
				$catName = $catSlug ? ($catStore[$catSlug]['name'] ?? $article['category']) : null;
			?>
			<a href="<?php echo $url; ?>" class="docs-home-article-row">
				<div class="docs-home-article-info">
					<span class="docs-home-article-title"><?php echo htmlspecialchars($article['title']); ?></span>
					<?php if (!empty($catName)): ?>
					<span class="docs-home-article-cat"><?php echo htmlspecialchars($catName); ?></span>
					<?php endif; ?>
				</div>
				<?php
				$displayDate = !empty($article['last_modified']) ? $article['last_modified'] : ($article['date'] ?? '');
				if ($displayDate): ?>
				<span class="docs-home-article-date"><?php echo htmlspecialchars(format_date($displayDate)); ?></span>
				<?php endif; ?>
			</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php endif; ?>
</div>