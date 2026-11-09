<?php
$renderedContent = render_content_html($item['content'] ?? '', $item);
$toc             = function_exists('docs_extract_toc') ? docs_extract_toc($renderedContent) : [];
?>
<div class="docs-page-layout">
	<article class="docs-article">
		<h1 class="docs-page-title"><?php echo htmlspecialchars($item['title']); ?></h1>
		<?php if (!empty($item['description'])): ?><p class="docs-page-lead"><?php echo htmlspecialchars($item['description']); ?></p><?php endif; ?>
		<?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
		<figure class="docs-featured-image"><img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" loading="lazy"></figure>
		<?php endif; ?>
		<div class="docs-body"><?php echo $renderedContent; ?></div>
	</article>
	<?php if (!empty($toc) && function_exists('docs_render_toc')) echo docs_render_toc($toc); ?>
</div>
