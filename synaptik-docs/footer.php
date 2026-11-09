	</main>
	<footer class="docs-footer">
		<div class="docs-footer-inner">
			<div class="docs-footer-brand">
				<a href="<?php echo cleanUrl('home'); ?>" class="footer-logo">
					<span class="footer-logo-mark">S</span>
					<span><?php echo htmlspecialchars($settings['site_title'] ?? 'Synaptik CMS'); ?></span>
				</a>
				<?php if (!empty($settings['site_description'])): ?>
				<p class="footer-tagline"><?php echo htmlspecialchars($settings['site_description']); ?></p>
				<?php endif; ?>
				<?php if (!empty($settings['footer_show_social']) && !empty($settings['footer_social_links'])): ?>
				<?php endif; ?>
			</div>
			<nav class="docs-footer-nav">
				<?php
				$fpages    = array_filter(sl_load_index('page'),    fn($p) => !empty($p['show_in_menu']));
				$farticles = array_filter(sl_load_index('article'), fn($a) => !empty($a['show_in_menu']));
				usort($fpages,    fn($a,$b) => ($a['menu_order']??99)<=>($b['menu_order']??99));
				usort($farticles, fn($a,$b) => strcmp($b['date']??'',$a['date']??''));
				$farticles = array_slice(array_values($farticles), 0, 6);
				?>
				<?php if (!empty($fpages)): ?>
				<div class="footer-col">
					<div class="footer-col-title">Getting Started</div>
					<ul>
						<?php foreach ($fpages as $p):
						$catSlug = !empty($p['category']) ? sanitizeSlug($p['category']) : null;
						$url = cleanUrl('page', sl_effective_slug($p), null, $catSlug);
						?>
						<li><a href="<?php echo $url; ?>"><?php echo htmlspecialchars($p['title']); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
				<?php if (!empty($farticles)): ?>
				<div class="footer-col">
					<div class="footer-col-title">Documentation</div>
					<ul>
						<?php foreach ($farticles as $a):
						$catSlug = !empty($a['category']) ? sanitizeSlug($a['category']) : null;
						$url = cleanUrl('article', sl_effective_slug($a), null, $catSlug);
						?>
						<li><a href="<?php echo $url; ?>"><?php echo htmlspecialchars($a['title']); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
				<div class="footer-col">
					<div class="footer-col-title">Project</div>
					<ul>
						<li><a href="https://github.com/synaptikcms/synaptik-cms" target="_blank" rel="noopener">GitHub</a></li>
						<li><a href="https://github.com/synaptikcms/synaptik-cms/releases" target="_blank" rel="noopener">Releases</a></li>
						<li><a href="https://github.com/synaptikcms/synaptik-cms/issues" target="_blank" rel="noopener">Issues</a></li>
						<li><a href="https://synaptikcms.com/docs/changelog/">Changelog</a></li>
						<li><a href="https://synaptikcms.com/docs/licence/">Licence</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="docs-footer-bottom">
			<?php echo render_footer_content(); ?>
		</div>
	</footer>
</div><!-- /.docs-main -->
<?php echo render_search_ui(); ?>
<?php /* highlight.js is loaded by the core's render_hljs_scripts() when the page has a code block — see core/render/tf-page.php */ ?>
</body>
</html>