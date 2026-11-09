<div class="docs-page-layout">
<article class="docs-article">
	<h1 class="docs-page-title">
		<?php
		if ($list_type === 'category') echo 'Category: ' . htmlspecialchars(urldecode($filter_value ?? ''));
		elseif ($list_type === 'tag')  echo '#' . htmlspecialchars(urldecode($filter_value ?? ''));
		else echo htmlspecialchars(sl_type_label($list_type, true));
		?>
	</h1>
	<div class="docs-body">
		<?php if (!empty($articles)): ?>
		<div class="docs-article-list">
			<?php foreach ($articles as $a):
				$catSlug = !empty($a['category']) ? sanitizeSlug($a['category']) : null;
			$url = cleanUrl('article', sl_effective_slug($a), null, $catSlug);
			?>
			<a href="<?php echo $url; ?>" class="docs-article-list-item">
				<?php if (!empty($a['image'])): ?>
				<div class="docs-article-list-thumb"><img src="<?php echo getBaseUrl() . htmlspecialchars($a['image']); ?>" alt="" loading="lazy"></div>
				<?php endif; ?>
				<div class="docs-article-list-body">
					<div class="docs-article-list-title"><?php echo htmlspecialchars($a['title']); ?></div>
					<?php if (!empty($a['summary'])): ?><div class="docs-article-list-excerpt"><?php echo htmlspecialchars($a['summary']); ?></div><?php endif; ?>
					<?php if (!empty($a['date'])): ?><div class="docs-article-list-meta"><?php echo htmlspecialchars(format_date($a['date'])); ?></div><?php endif; ?>
				</div>
				<div class="docs-article-list-arrow">→</div>
			</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<?php if (!empty($projects)): ?>
		<div class="docs-project-grid">
			<?php foreach ($projects as $p):
				$catSlug = !empty($p['category']) ? sanitizeSlug($p['category']) : null;
			$url = cleanUrl('project', sl_effective_slug($p), null, $catSlug);
			?>
			<a href="<?php echo $url; ?>" class="docs-project-card">
				<?php if (!empty($p['image'])): ?>
				<div class="docs-project-card-img"><img src="<?php echo getBaseUrl() . htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" loading="lazy"></div>
				<?php else: ?>
				<div class="docs-project-card-placeholder"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
				<?php endif; ?>
				<div class="docs-project-card-body">
					<div class="docs-project-card-title"><?php echo htmlspecialchars($p['title']); ?></div>
					<?php if (!empty($p['description'])): ?><div class="docs-project-card-desc"><?php echo htmlspecialchars($p['description']); ?></div><?php endif; ?>
				</div>
			</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<?php if (empty($articles) && empty($projects)): ?><p class="docs-empty">No content found.</p><?php endif; ?>
	</div>
</article>
</div>
