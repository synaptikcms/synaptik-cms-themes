<?php do_theme_action('after_content'); ?>
	
	</main>
	<?php do_theme_action('before_footer'); ?>
	<footer>
		<?php echo render_footer_content(); ?>
	</footer>
	<?php do_theme_action('after_footer'); ?>
	<script src="<?php echo getBaseUrl() . getThemeResourcePath('js', 'submenu-toggle.js'); ?>"></script>
	<?php echo render_search_ui(); ?>
</body>
</html>