<?php
/**
 * Natura Theme for Synaptik CMS — footer.php
 */
do_theme_action('after_content');
?>
  </main>

  <?php do_theme_action('before_footer'); ?>
  <footer class="site-footer">
    <div class="footer-body">

      <div class="footer-col footer-col--brand">
        <div class="footer-brand-content">
          <a href="<?php echo cleanUrl('home'); ?>" class="footer-brand-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M12 2C6 2 2 7 2 12c0 5 4 9 10 10C18 21 22 17 22 12c0-5-4-10-10-10z"/>
              <path d="M12 2v20"/>
              <path d="M12 8C9 10 7 13 8 17"/>
              <path d="M12 8c3 2 5 5 4 9"/>
            </svg>
            <?php echo htmlspecialchars($settings['site_title']); ?>
          </a>
          <?php if (!empty($settings['site_description'])): ?>
          <p class="footer-tagline"><?php echo htmlspecialchars($settings['site_description']); ?></p>
          <?php endif; ?>
          <?php if (!empty($settings['footer_show_social']) && !empty($settings['footer_social_links'])): ?>
          <div class="footer-social">
            <?php foreach ($settings['footer_social_links'] as $social):
              if (empty($social['url'])) continue; ?>
            <a href="<?php echo htmlspecialchars($social['url']); ?>" class="social-icon" target="_blank" rel="noopener" aria-label="<?php echo htmlspecialchars(ucfirst($social['platform'] ?? '')); ?>">
              <?php echo get_social_icon($social['platform'] ?? ''); ?>
            </a>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>

        <div class="footer-plants" aria-hidden="true">

          <svg class="fp fp-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 200" fill="none">
            <path d="M60 198 Q59 172 58 148 Q57 126 57 108" stroke="#2a3d2c" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M57 148 Q40 140 28 124 Q22 116 20 106 Q32 114 44 122 Q52 130 57 148Z" fill="#1e3a26" opacity=".92"/>
            <path d="M57 148 Q44 130 28 120" stroke="#162e1c" stroke-width="1" stroke-linecap="round" opacity=".4"/>
            <path d="M57 148 Q70 134 80 118 Q88 106 88 94 Q78 104 68 116 Q62 128 57 148Z" fill="#213e28" opacity=".88"/>
            <path d="M57 148 Q68 128 82 112" stroke="#162e1c" stroke-width="1" stroke-linecap="round" opacity=".4"/>
            <path d="M28 120 Q18 118 12 108 Q20 108 28 120Z" fill="#1a3420" opacity=".7"/>
            <path d="M80 110 Q90 102 96 92 Q88 98 80 110Z" fill="#1c3622" opacity=".65"/>
            <path d="M57 120 Q38 110 26 92 Q20 82 20 72 Q30 82 42 94 Q50 104 57 120Z" fill="#1a3824" opacity=".9"/>
            <path d="M57 120 Q40 94 24 76" stroke="#162e1c" stroke-width="1" stroke-linecap="round" opacity=".35"/>
            <path d="M57 120 Q72 106 82 88 Q88 76 86 64 Q78 76 68 90 Q62 106 57 120Z" fill="#1e3c26" opacity=".86"/>
            <path d="M57 120 Q70 96 82 76" stroke="#162e1c" stroke-width="1" stroke-linecap="round" opacity=".35"/>
            <path d="M24 90 Q14 86 10 74 Q18 76 24 90Z" fill="#182e1e" opacity=".6"/>
            <path d="M84 72 Q94 62 98 50 Q90 58 84 72Z" fill="#1a3020" opacity=".58"/>
            <path d="M57 96 Q42 82 32 62 Q28 50 30 38 Q40 52 48 68 Q53 82 57 96Z" fill="#1c3c26" opacity=".88"/>
            <path d="M57 96 Q68 78 76 58 Q80 44 76 32 Q68 46 62 64 Q58 80 57 96Z" fill="#1e3e28" opacity=".84"/>
            <path d="M57 96 Q44 70 32 50" stroke="#162e1c" stroke-width=".9" stroke-linecap="round" opacity=".3"/>
            <path d="M57 96 Q66 70 74 50" stroke="#162e1c" stroke-width=".9" stroke-linecap="round" opacity=".3"/>
          </svg>

          <svg class="fp fp-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 180" fill="none">
            <path d="M50 178 Q49 158 48 138" stroke="#263828" stroke-width="2" stroke-linecap="round"/>
            <path d="M48 138 Q30 122 18 104 Q16 94 20 86 Q28 98 36 112 Q43 124 48 138Z" fill="#1c3a24" opacity=".92"/>
            <path d="M48 138 Q62 120 70 100 Q74 88 70 78 Q64 90 58 106 Q52 122 48 138Z" fill="#203e28" opacity=".88"/>
            <path d="M48 138 Q32 108 20 88" stroke="#162e1c" stroke-width=".9" opacity=".35"/>
            <path d="M48 138 Q62 112 68 88" stroke="#162e1c" stroke-width=".9" opacity=".35"/>
            <path d="M48 110 Q30 94 20 74 Q18 62 24 54 Q30 68 38 84 Q44 98 48 110Z" fill="#1a3822" opacity=".88"/>
            <path d="M48 110 Q64 92 72 70 Q76 56 70 46 Q64 60 56 78 Q50 96 48 110Z" fill="#1e3c26" opacity=".84"/>
            <path d="M48 110 Q32 80 22 58" stroke="#162e1c" stroke-width=".9" opacity=".3"/>
            <path d="M48 110 Q62 82 68 56" stroke="#162e1c" stroke-width=".9" opacity=".3"/>
            <path d="M48 82 Q34 64 26 44 Q24 32 30 24 Q36 40 42 58 Q46 70 48 82Z" fill="#182e20" opacity=".84"/>
            <path d="M48 82 Q62 62 68 40 Q70 26 64 18 Q58 34 52 54 Q49 68 48 82Z" fill="#1c3224" opacity=".80"/>
            <path d="M48 82 Q34 54 28 32" stroke="#162e1c" stroke-width=".8" opacity=".28"/>
            <path d="M48 82 Q60 56 64 30" stroke="#162e1c" stroke-width=".8" opacity=".28"/>
            <path d="M48 56 Q38 40 34 22 Q32 12 38 6 Q42 20 44 38 Q47 48 48 56Z" fill="#162c1e" opacity=".78"/>
            <path d="M48 56 Q58 38 62 18 Q62 8 56 2 Q52 16 50 36 Q48 48 48 56Z" fill="#1a3020" opacity=".74"/>
          </svg>

          <svg class="fp fp-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 160" fill="none">
            <path d="M70 158 Q70 142 70 128 Q70 116 70 104" stroke="#2c4030" stroke-width="2.2" stroke-linecap="round"/>
            <path d="M70 128 Q54 136 40 132 Q30 126 28 116 Q42 120 56 124 Q64 126 70 128Z" fill="#1e3c26" opacity=".92"/>
            <path d="M70 128 Q86 136 100 132 Q110 126 112 116 Q98 120 84 124 Q76 126 70 128Z" fill="#213e28" opacity=".88"/>
            <path d="M40 128 Q28 130 22 122 Q30 120 40 128Z" fill="#1a3422" opacity=".65"/>
            <path d="M100 128 Q112 130 118 122 Q110 120 100 128Z" fill="#1c3624" opacity=".62"/>
            <path d="M70 116 Q52 122 38 116 Q28 108 28 98 Q42 104 56 110 Q64 114 70 116Z" fill="#1c3a24" opacity=".9"/>
            <path d="M70 116 Q88 122 102 116 Q112 108 112 98 Q98 104 84 110 Q76 114 70 116Z" fill="#1f3e27" opacity=".86"/>
            <path d="M70 104 Q50 108 36 100 Q26 90 28 80 Q42 88 56 96 Q64 100 70 104Z" fill="#1a3822" opacity=".88"/>
            <path d="M70 104 Q90 108 104 100 Q114 90 112 80 Q98 88 84 96 Q76 100 70 104Z" fill="#1d3c25" opacity=".84"/>
            <path d="M70 92 Q52 94 40 84 Q32 72 36 62 Q48 72 60 82 Q66 88 70 92Z" fill="#182e1e" opacity=".86"/>
            <path d="M70 92 Q88 94 100 84 Q108 72 104 62 Q92 72 80 82 Q74 88 70 92Z" fill="#1c3222" opacity=".82"/>
            <path d="M70 80 Q54 80 44 68 Q38 56 44 46 Q54 58 62 70 Q67 76 70 80Z" fill="#162c1c" opacity=".82"/>
            <path d="M70 80 Q86 80 96 68 Q102 56 96 46 Q86 58 78 70 Q73 76 70 80Z" fill="#1a3020" opacity=".78"/>
            <path d="M70 68 Q56 66 48 52 Q44 40 52 32 Q60 46 64 60 Q68 64 70 68Z" fill="#142a1a" opacity=".76"/>
            <path d="M70 68 Q84 66 92 52 Q96 40 88 32 Q80 46 76 60 Q72 64 70 68Z" fill="#182e1e" opacity=".72"/>
          </svg>

        </div>
      </div>

      <div class="footer-col">
        <div class="footer-col-title"><?php echo __t('categories', 'Categories'); ?></div>
        <ul class="footer-links-list">
          <?php
          $footerCats = [];
          if (!empty($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as $slug => $cat) {
              $footerCats[] = ['slug' => $slug, 'name' => $cat['name'] ?? $slug];
              if (count($footerCats) >= 8) break;
            }
          }
          if (!empty($footerCats)):
            foreach ($footerCats as $cat): ?>
          <li><a href="<?php echo getBaseUrl() . url_slug('category') . '/' . htmlspecialchars($cat['slug']) . '/'; ?>"><?php echo htmlspecialchars($cat['name']); ?></a></li>
          <?php endforeach;
          else: ?>
          <li><a href="<?php echo cleanUrl('article'); ?>"><?php echo __t('articles', 'Articles'); ?></a></li>
          <li><a href="<?php echo cleanUrl('project'); ?>"><?php echo __t('projects', 'Projects'); ?></a></li>
          <?php endif; ?>
        </ul>
      </div>

      <div class="footer-col">
        <div class="footer-col-title"><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></div>
        <ul class="footer-links-list footer-recent">
          <?php
          // data-layer.php is already loaded by core/functions.php at boot
          $footerArticles = sl_load_index('article');
          if (!empty($footerArticles)) {
            usort($footerArticles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
            $footerArticles = array_slice($footerArticles, 0, 5);
          }
          foreach ($footerArticles as $fa):
            $faSlug = !empty($fa['custom_slug']) ? $fa['custom_slug'] : $fa['slug'];
            $faCat  = !empty($fa['category']) ? sanitizeSlug($fa['category']) : null;
          ?>
          <li>
            <a href="<?php echo cleanUrl('article', $faSlug, null, $faCat); ?>">
              <?php if (!empty($fa['date'])): ?>
              <time><?php echo htmlspecialchars(format_date($fa['date'])); ?></time>
              <?php endif; ?>
              <span><?php echo htmlspecialchars($fa['title']); ?></span>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

    </div>

    <div class="footer-bottom">
      <div class="footer-bottom-inner">
        <p class="footer-text">
          <?php
          $footerText = $settings['footer_text'] ?? '&copy; {year}';
          echo str_replace('{year}', date('Y'), $footerText);
          if (!empty($settings['footer_show_login'])):
            echo ' &nbsp;&middot;&nbsp; <a href="' . getBaseUrl() . 'admin/auth.php" class="footer-login" target="_blank">Admin</a>';
          endif;
          ?>
        </p>
        <p class="snk-credit">Powered by <a href="https://synaptikcms.com" target="_blank" rel="noopener">Synaptik CMS</a></p>
        <div class="footer-leaf-badge">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 2C6 2 2 7 2 12c0 5 4 9 10 10C18 21 22 17 22 12c0-5-4-10-10-10z"/>
            <path d="M12 2v20"/>
          </svg>
          Natura
        </div>
      </div>
    </div>
  </footer>

  <script src="<?php echo getBaseUrl() . getThemeResourcePath('js', 'animations.js'); ?>" defer></script>
  <?php do_theme_action('footer_scripts'); ?>
  <?php echo render_search_ui(); ?>
</body>
</html>
