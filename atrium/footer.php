<?php
/**
 * Atrium Theme for Synaptik CMS — footer.php
 *
 * Editorial closing: colophon, latest content marquee, core footer content
 * (footer_text + social links via render_footer_content), search overlay.
 */
?>
<?php do_theme_action('after_content'); ?>
</main>

<?php do_theme_action('before_footer'); ?>

<footer class="atrium-footer">
  <div class="atrium-footer-inner">

    <div class="atrium-colophon">
      <a href="<?php echo cleanUrl('home'); ?>" class="atrium-colophon-brand">
        <span class="atrium-mark atrium-mark--sm" aria-hidden="true">
          <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" focusable="false">
            <g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M8 40 L24 8 L40 40"/>
              <path d="M16 28 L32 28"/>
            </g>
          </svg>
        </span>
        <span><?php echo htmlspecialchars($settings['site_title'] ?? ''); ?></span>
      </a>
      <?php if (!empty($settings['site_description'])): ?>
      <p class="atrium-colophon-desc"><?php echo htmlspecialchars($settings['site_description']); ?></p>
      <?php endif; ?>
    </div>

    <nav class="atrium-footer-nav" aria-label="<?php echo htmlspecialchars(__t('navigate')); ?>">
      <h4 class="atrium-footer-h"><?php echo __t('navigate', 'Navigate'); ?></h4>
      <ul>
        <li><a href="<?php echo cleanUrl('home'); ?>"><?php echo __t('home'); ?></a></li>
        <li><a href="<?php echo cleanUrl('article'); ?>"><?php echo sl_type_label('article', true); ?></a></li>
        <li><a href="<?php echo cleanUrl('project'); ?>"><?php echo sl_type_label('project', true); ?></a></li>
      </ul>
    </nav>

    <?php
    // Latest articles strip — load directly from the index since $data on
    // single-item pages only holds the current item, not the full catalogue.
    $df_latest = sl_load_index('article');
    if (!empty($df_latest)) {
        usort($df_latest, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
        $df_latest = array_slice($df_latest, 0, 4);
    }
    if (!empty($df_latest)): ?>
    <div class="atrium-footer-latest">
      <h4 class="atrium-footer-h"><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></h4>
      <ul>
        <?php foreach ($df_latest as $df_a):
            $df_slug = !empty($df_a['custom_slug']) ? $df_a['custom_slug'] : $df_a['slug'];
            $df_cat  = !empty($df_a['category']) ? sanitizeSlug($df_a['category']) : null;
            $df_url  = cleanUrl('article', $df_slug, null, $df_cat);
        ?>
        <li>
          <a href="<?php echo $df_url; ?>" data-atrium-link>
            <?php if (!empty($df_a['date'])): ?>
            <time datetime="<?php echo htmlspecialchars($df_a['date']); ?>"><?php echo htmlspecialchars(format_date($df_a['date'])); ?></time>
            <?php endif; ?>
            <span><?php echo htmlspecialchars($df_a['title']); ?></span>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

  </div>

  <?php
  // Tag marquee: pulled from index, deduplicated.
  // Pure CSS animation — pauses on hover. Hidden if no tags exist.
  $df_tag_pool = [];
  foreach (sl_load_index('article') as $df_a) {
      if (!empty($df_a['tags']) && is_array($df_a['tags'])) {
          foreach ($df_a['tags'] as $df_t) { $df_tag_pool[$df_t] = true; }
      }
  }
  $df_tag_pool = array_keys($df_tag_pool);
  if (!empty($df_tag_pool)): ?>
  <div class="atrium-marquee" aria-hidden="true">
    <div class="atrium-marquee-track">
      <?php for ($i = 0; $i < 2; $i++): ?>
      <div class="atrium-marquee-group">
        <?php foreach ($df_tag_pool as $df_t): ?>
        <span class="atrium-marquee-item"><?php echo htmlspecialchars($df_t); ?></span>
        <span class="atrium-marquee-sep" aria-hidden="true">✦</span>
        <?php endforeach; ?>
      </div>
      <?php endfor; ?>
    </div>
  </div>
  <?php endif; ?>

  <div class="atrium-footer-bottom">
    <div class="atrium-footer-bottom-inner">
      <?php echo render_footer_content(); ?>
    </div>
  </div>
</footer>

<?php do_theme_action('after_footer'); ?>

<script src="<?php echo getBaseUrl() . 'theme/' . htmlspecialchars($settings['active_theme'] ?? 'atrium') . '/js/script.js'; ?>"></script>
<?php echo render_search_ui(); ?>
</body>
</html>
