<?php do_theme_action('after_content'); ?>
  </main>

  <?php do_theme_action('before_footer'); ?>
  <footer>
    <div class="footer-top">
      <div class="container">
        <div class="footer-grid">

          <div class="footer-brand">
            <a href="<?php echo cleanUrl('home'); ?>" class="footer-logo">
              <?php echo htmlspecialchars($settings['site_title']); ?>
            </a>
            <p class="footer-desc"><?php echo htmlspecialchars($settings['site_description']); ?></p>
          </div>

          <?php
          $footerCats = [];
          if (!empty($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as $slug => $cat) {
              $footerCats[] = ['slug' => $slug, 'name' => $cat['name'] ?? $slug];
              if (count($footerCats) >= 8) break;
            }
          }
          if (!empty($footerCats)): ?>
          <div class="footer-column">
            <h4 class="footer-col-title"><?php echo __t('categories', 'Categories'); ?></h4>
            <ul class="footer-links">
              <?php foreach ($footerCats as $cat): ?>
              <li>
                <a href="<?php echo getBaseUrl() . url_slug('category') . '/' . htmlspecialchars($cat['slug']) . '/'; ?>">
                  <?php echo htmlspecialchars($cat['name']); ?>
                </a>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <?php else: ?>
          <div class="footer-column">
            <h4 class="footer-col-title"><?php echo __t('navigate', 'Navigate'); ?></h4>
            <ul class="footer-links">
              <li><a href="<?php echo cleanUrl('home'); ?>"><?php echo __t('home', 'Home'); ?></a></li>
              <li><a href="<?php echo cleanUrl('article'); ?>"><?php echo __t('articles', 'Articles'); ?></a></li>
              <li><a href="<?php echo cleanUrl('project'); ?>"><?php echo __t('projects', 'Projects'); ?></a></li>
            </ul>
          </div>
          <?php endif; ?>

          <?php
          // data-layer.php is already loaded by core/functions.php at boot
          $footerArticles = sl_load_index('article');
          if (!empty($footerArticles)) {
            usort($footerArticles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
            $footerArticles = array_slice($footerArticles, 0, 4);
          }
          if (!empty($footerArticles)): ?>
          <div class="footer-column footer-column--articles">
            <h4 class="footer-col-title"><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></h4>
            <ul class="footer-recent">
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
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <?php echo render_footer_content(); ?>
      </div>
    </div>
  </footer>
  <?php do_theme_action('after_footer'); ?>

  <script defer src="<?php echo getBaseUrl() . getThemeResourcePath('js', 'interactions.js'); ?>"></script>
  <?php echo render_search_ui(); ?>
</body>
</html>
