        </main><!-- /.vt-main -->
        <footer class="vt-footer">
            <div class="vt-footer-inner">
                <span class="vt-footer-text">
                    <?php
                    $ft = str_replace('{year}', date('Y'), $settings['footer_text'] ?? '');
                    echo strip_tags($ft, '<a><em><strong>');
                    ?>
                </span>
                <span class="snk-credit">Powered by <a href="https://synaptikcms.com" target="_blank" rel="noopener">Synaptik CMS</a></span>
                <?php if (!empty($settings['footer_show_social']) && !empty($settings['footer_social_links'])): ?>
                <div class="vt-social">
                    <?php foreach ($settings['footer_social_links'] as $s): ?>
                        <?php if (!empty($s['platform']) && !empty($s['url'])): ?>
                        <a href="<?php echo htmlspecialchars($s['url']); ?>" class="vt-social-link" target="_blank" rel="noopener" aria-label="<?php echo htmlspecialchars($s['platform']); ?>">
                            <?php echo get_social_icon($s['platform']); ?>
                        </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </footer>
    </div><!-- /.vt-col -->
</div><!-- /.vt-wrap -->

<?php echo render_search_ui(); ?>
</body>
</html>
