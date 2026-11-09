<?php
/* Template Name: Landing */
$renderedContent = render_content_html($item['content'] ?? '', $item);
?>
<div class="docs-landing">
	<?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
	<div class="docs-landing-hero"><img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>"></div>
	<?php endif; ?>
	<?php if (!isset($item['show_title']) || $item['show_title']): ?>
	<h1 class="docs-landing-title"><?php echo htmlspecialchars($item['title']); ?></h1>
	<?php endif; ?>
	<div class="docs-body docs-landing-body"><?php echo $renderedContent; ?></div>
</div>
