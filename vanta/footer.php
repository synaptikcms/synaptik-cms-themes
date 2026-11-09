<?php
/**
 * Vanta Theme — footer.php
 *
 * Closes site-main and site-wrap opened in header.php.
 * Injected variables: $settings, $currentYear, $baseUrl
 */
?>
    </main><!-- /.site-main -->

    <!-- ── Footer ─────────────────────────────────────────── -->
    <footer class="site-footer">
        <div class="site-footer-inner">
            <div class="footer-text">
                <?php
                $footerText = $settings['footer_text'] ?? '';
                $footerText = str_replace('{year}', date('Y'), $footerText);
                echo strip_tags($footerText, '<a><em><strong>');
                ?>
            </div>
            <p class="snk-credit">Powered by <a href="https://synaptikcms.com" target="_blank" rel="noopener">Synaptik CMS</a></p>
            <?php if (!empty($settings['footer_show_social']) && !empty($settings['footer_social_links'])): ?>
            <div class="footer-social">
                <?php foreach ($settings['footer_social_links'] as $social): ?>
                    <?php if (!empty($social['platform']) && !empty($social['url'])): ?>
                    <a href="<?php echo htmlspecialchars($social['url']); ?>"
                       class="footer-social-link"
                       target="_blank"
                       rel="noopener"
                       aria-label="<?php echo htmlspecialchars($social['platform']); ?>">
                        <?php echo get_social_icon($social['platform']); ?>
                    </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </footer>

</div><!-- /.site-wrap -->

<?php echo render_search_ui(); ?>
</body>
</html>
