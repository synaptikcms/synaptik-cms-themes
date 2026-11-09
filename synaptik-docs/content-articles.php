<?php
$renderedContent = render_content_html($item['content'] ?? '', $item);
$toc             = function_exists('docs_extract_toc') ? docs_extract_toc($renderedContent) : [];
$currentSlug     = sl_effective_slug($item);
$navItems        = function_exists('docs_get_prev_next') ? docs_get_prev_next('article', $currentSlug) : ['prev'=>null,'next'=>null];
?>
<div class="docs-page-layout">
	<article class="docs-article">
		<div class="docs-article-header">
			<?php if (!empty($item['category'])):
				$catSlug  = sanitizeSlug($item['category']);
				$catName  = sl_load_categories()[$catSlug]['name'] ?? $item['category'];
			?>
			<a href="<?php echo cleanUrl('category', null, null, $catSlug); ?>" class="docs-article-category"><?php echo htmlspecialchars($catName); ?></a>
			<?php endif; ?>
			<h1 class="docs-page-title"><?php echo htmlspecialchars($item['title']); ?></h1>
			<?php if (!empty($item['date']) && !empty($item['show_date'])): ?>
			<div class="docs-article-meta">
				<time datetime="<?php echo htmlspecialchars($item['date']); ?>"><?php echo htmlspecialchars(format_date($item['date'])); ?></time>
			</div>
			<?php endif; ?>
			<?php if (!empty($item['tags']) && is_array($item['tags'])): ?>
			<div class="docs-article-tags">
				<?php foreach ($item['tags'] as $tag): ?>
				<a href="<?php echo cleanUrl('tag', null, null, sanitizeSlug($tag)); ?>" class="docs-tag"><?php echo htmlspecialchars($tag); ?></a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
		<figure class="docs-featured-image"><img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy"></figure>
		<?php endif; ?>
		<div class="docs-body"><?php echo $renderedContent; ?></div>
		<?php if ($navItems['prev'] || $navItems['next']): ?>
		<nav class="docs-pagination">
			<?php if ($navItems['prev']):
				$ps = sl_effective_slug($navItems['prev']);
				$pc = !empty($navItems['prev']['category']) ? sanitizeSlug($navItems['prev']['category']) : null;
			?><a href="<?php echo cleanUrl($navItems['prev']['_type'], $ps, null, $pc); ?>" class="docs-pagination-prev">
				<span class="pagination-label">← Previous</span>
				<span class="pagination-title"><?php echo htmlspecialchars($navItems['prev']['title']); ?></span>
			</a><?php else: ?><span></span><?php endif; ?>
			<?php if ($navItems['next']):
				$ns = sl_effective_slug($navItems['next']);
				$nc = !empty($navItems['next']['category']) ? sanitizeSlug($navItems['next']['category']) : null;
			?><a href="<?php echo cleanUrl($navItems['next']['_type'], $ns, null, $nc); ?>" class="docs-pagination-next">
				<span class="pagination-label">Next →</span>
				<span class="pagination-title"><?php echo htmlspecialchars($navItems['next']['title']); ?></span>
			</a><?php endif; ?>
		</nav>
		<?php endif; ?>
	</article>
	<?php if (!empty($toc) && function_exists('docs_render_toc')) echo docs_render_toc($toc); ?>
</div>
