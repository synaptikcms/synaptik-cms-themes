<?php
/* Template Name: Contact */
$renderedContent = render_content_html($item['content'] ?? '', $item);
$toc             = function_exists('docs_extract_toc') ? docs_extract_toc($renderedContent) : [];
?>
<div class="docs-page-layout">
	<article class="docs-article">
		<h1 class="docs-page-title"><?php echo htmlspecialchars($item['title']); ?></h1>
		<?php if (!empty($item['meta_description'])): ?><p class="docs-page-lead"><?php echo htmlspecialchars($item['meta_description']); ?></p><?php endif; ?>
		<div class="docs-body"><?php echo $renderedContent; ?></div>
		<div class="docs-contact-block"><?php echo render_contact_form_html(); ?></div>
	</article>
	<?php if (!empty($toc) && function_exists('docs_render_toc')) echo docs_render_toc($toc); ?>
</div>
