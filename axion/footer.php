<?php
/**
 * Axion Theme for Synaptik CMS — footer.php
 * Bold typographic footer: oversized wordmark left, link columns right.
 */
?>
<?php do_theme_action('after_content'); ?>
</main>
<?php do_theme_action('before_footer'); ?>
<footer class="ax-footer">
  <div class="ax-footer-top">
    <div class="ax-footer-brand">
      <h2 class="ax-footer-wordmark"><?php echo htmlspecialchars($settings['site_title']); ?></h2>
      <p class="ax-footer-tagline"><?php echo htmlspecialchars($settings['site_description']); ?></p>
    </div>
    <div class="ax-footer-cols">
      <?php
      $cats = [];
      if (!empty($data['categories']) && is_array($data['categories'])) {
        foreach ($data['categories'] as $slug => $c) {
          $cats[] = ['slug' => $slug, 'name' => $c['name'] ?? $slug];
          if (count($cats) >= 5) break;
        }
      }
      ?>
      <?php if (!empty($cats)): ?>
      <div class="ax-footer-col">
        <h4><?php echo __t('categories', 'Categories'); ?></h4>
        <ul>
          <?php foreach ($cats as $c): ?>
          <li><a href="<?php echo getBaseUrl() . url_slug('category') . '/' . htmlspecialchars($c['slug']) . '/'; ?>"><?php echo htmlspecialchars($c['name']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <div class="ax-footer-col">
        <h4><?php echo __t('navigate', 'Navigate'); ?></h4>
        <ul>
          <li><a href="<?php echo cleanUrl('home'); ?>"><?php echo __t('home', 'Home'); ?></a></li>
          <li><a href="<?php echo cleanUrl('article'); ?>"><?php echo __t('articles', 'Articles'); ?></a></li>
          <li><a href="<?php echo cleanUrl('project'); ?>"><?php echo __t('projects', 'Projects'); ?></a></li>
        </ul>
      </div>
      <?php
      $recent = sl_load_index('article');
      if (!empty($recent)) {
        usort($recent, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
        $recent = array_slice($recent, 0, 3);
      }
      if (!empty($recent)): ?>
      <div class="ax-footer-col ax-footer-col--wide">
        <h4><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></h4>
        <ul class="ax-footer-recent">
          <?php foreach ($recent as $fa):
            $faSlug = !empty($fa['custom_slug']) ? $fa['custom_slug'] : $fa['slug'];
            $faCat  = !empty($fa['category']) ? sanitizeSlug($fa['category']) : null;
            $faUrl  = cleanUrl('article', $faSlug, null, $faCat);
          ?>
          <li><a href="<?php echo $faUrl; ?>">
            <?php if (!empty($fa['date'])): ?><time><?php echo htmlspecialchars(format_date($fa['date'])); ?></time><?php endif; ?>
            <span><?php echo htmlspecialchars($fa['title']); ?></span>
          </a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="ax-footer-bottom">
    <?php echo render_footer_content(); ?>
  </div>
</footer>
<?php do_theme_action('after_footer'); ?>
<?php echo render_search_ui(); ?>
</body>
</html>