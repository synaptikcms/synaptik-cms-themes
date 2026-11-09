<?php
$renderedContent = render_content_html($item['content'] ?? '', $item);
$toc             = function_exists('docs_extract_toc') ? docs_extract_toc($renderedContent) : [];
$currentSlug     = sl_effective_slug($item);
$navItems        = function_exists('docs_get_prev_next') ? docs_get_prev_next('page', $currentSlug) : ['prev'=>null,'next'=>null];
?>
<div class="docs-page-layout">
	<article class="docs-article">
		<?php if (!isset($item['show_title']) || $item['show_title']): ?>
		<h1 class="docs-page-title"><?php echo htmlspecialchars($item['title']); ?></h1>
		<?php endif; ?>
		<?php if (!empty($item['meta_description'])): ?>
		<p class="docs-page-lead"><?php echo htmlspecialchars($item['meta_description']); ?></p>
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
