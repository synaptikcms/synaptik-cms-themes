	<section class="project-details">
		<?php echo render_content_title($item); ?>
		<?php echo render_content_date($item); ?>
		<?php echo render_featured_image($item); ?>
		<?php if (isset($item['description'])): ?>
		<div class="project-description">
			<?php echo nl2br(htmlspecialchars($item['description'])); ?>
		</div>
		<?php endif; ?>

		<?php $cf_html = render_item_custom_fields($item, 'project'); ?>
		<?php if ($cf_html): ?>
		<div class="project-layout">
			<aside class="project-sidebar"><?php echo $cf_html; ?></aside>
			<div class="project-content">
				<?php echo render_content_html($item['content'], $item); ?>
			</div>
		</div>
		<?php else: ?>
		<div class="project-content">
			<?php echo render_content_html($item['content'], $item); ?>
		</div>
		<?php endif; ?>
		
		<?php echo render_related_items($item); ?>
		
		<?php if (isset($item['show_tags_at_bottom']) && $item['show_tags_at_bottom']): ?>
		<div class="article-footer-tags">
			<h4>Tags:</h4>
			<?php echo render_content_tags($item); ?>
		</div>
		<?php endif; ?>
	</section>