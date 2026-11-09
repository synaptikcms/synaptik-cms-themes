<?php do_theme_action('after_content'); ?>
</main>

<?php do_theme_action('before_footer'); ?>

<footer class="prism-footer">
  <div class="prism-footer-rainbow" aria-hidden="true"></div>
  <div class="prism-footer-inner">

    <div class="prism-footer-brand">
      <a href="<?php echo cleanUrl('home'); ?>" class="prism-footer-logo">
        <?php echo htmlspecialchars($settings['site_title']); ?>
      </a>
      <p><?php echo htmlspecialchars($settings['site_description']); ?></p>
    </div>

    <div class="prism-footer-col">
      <h4><?php echo __t('navigate', 'Navigate'); ?></h4>
      <ul>
        <li><a href="<?php echo cleanUrl('home'); ?>"><?php echo __t('home'); ?></a></li>
        <li><a href="<?php echo cleanUrl('article'); ?>"><?php echo sl_type_label('article', true); ?></a></li>
        <li><a href="<?php echo cleanUrl('project'); ?>"><?php echo sl_type_label('project', true); ?></a></li>
      </ul>
    </div>

    <?php
    // data-layer.php is already loaded by core/functions.php at boot
    $footerArticles = sl_load_index('article');
    if (!empty($footerArticles)) {
      usort($footerArticles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
      $footerArticles = array_slice($footerArticles, 0, 4);
    }
    if (!empty($footerArticles)): ?>
    <div class="prism-footer-col prism-footer-col--wide">
      <h4><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></h4>
      <ul class="prism-footer-articles">
        <?php foreach ($footerArticles as $fa):
          $faSlug = !empty($fa['custom_slug']) ? $fa['custom_slug'] : $fa['slug'];
          $faCat  = !empty($fa['category']) ? sanitizeSlug($fa['category']) : null;
          $faUrl  = cleanUrl('article', $faSlug, null, $faCat);
        ?>
        <li>
          <a href="<?php echo $faUrl; ?>">
            <?php if (!empty($fa['date'])): ?>
            <time><?php echo htmlspecialchars(format_date($fa['date'])); ?></time>
            <?php endif; ?>
            <span><?php echo htmlspecialchars($fa['title']); ?></span>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

  </div>
  <div class="prism-footer-bottom">
    <div class="prism-footer-bottom-inner">
      <?php echo render_footer_content(); ?>
    </div>
  </div>
</footer>

<?php do_theme_action('after_footer'); ?>

<script src="<?php echo getBaseUrl(); ?>theme/prism/js/main.js"></script>
<?php echo render_search_ui(); ?>
</body>
</html>
