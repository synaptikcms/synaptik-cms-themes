<?php
/**
 * Myelin Theme for Synaptik CMS — footer.php
 * Multi-column footer with brand block, navigation columns, recent articles.
 */
?>
<?php do_theme_action('after_content'); ?>
</main>

<?php do_theme_action('before_footer'); ?>
<footer class="my-footer">
  <div class="my-footer-inner">

    <div class="my-footer-brand">
      <a href="<?php echo cleanUrl('home'); ?>" class="my-footer-logo">
        <span class="my-brand-mark" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="16" cy="16" r="3" fill="currentColor"/>
            <circle cx="5" cy="8" r="2" fill="currentColor"/>
            <circle cx="5" cy="24" r="2" fill="currentColor"/>
            <circle cx="27" cy="8" r="2" fill="currentColor"/>
            <circle cx="27" cy="24" r="2" fill="currentColor"/>
            <path d="M7 8 L13.5 14.5 M7 24 L13.5 17.5 M25 8 L18.5 14.5 M25 24 L18.5 17.5"
                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </span>
        <span><?php echo htmlspecialchars($settings['site_title']); ?></span>
      </a>
      <p class="my-footer-desc"><?php echo htmlspecialchars($settings['site_description']); ?></p>
    </div>

    <?php
    $footerCats = [];
    if (!empty($data['categories']) && is_array($data['categories'])) {
      foreach ($data['categories'] as $slug => $cat) {
        $footerCats[] = ['slug' => $slug, 'name' => $cat['name'] ?? $slug];
        if (count($footerCats) >= 6) break;
      }
    }
    ?>

    <?php if (!empty($footerCats)): ?>
    <div class="my-footer-col">
      <h4 class="my-footer-col-title"><?php echo __t('categories', 'Categories'); ?></h4>
      <ul>
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
    <div class="my-footer-col">
      <h4 class="my-footer-col-title"><?php echo __t('navigate', 'Navigate'); ?></h4>
      <ul>
        <li><a href="<?php echo cleanUrl('home'); ?>"><?php echo __t('home', 'Home'); ?></a></li>
        <li><a href="<?php echo cleanUrl('article'); ?>"><?php echo __t('articles', 'Articles'); ?></a></li>
        <li><a href="<?php echo cleanUrl('project'); ?>"><?php echo __t('projects', 'Projects'); ?></a></li>
      </ul>
    </div>
    <?php endif; ?>

    <?php
    $footerArticles = sl_load_index('article');
    if (!empty($footerArticles)) {
      usort($footerArticles, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
      $footerArticles = array_slice($footerArticles, 0, 4);
    }
    ?>
    <?php if (!empty($footerArticles)): ?>
    <div class="my-footer-col my-footer-col--articles">
      <h4 class="my-footer-col-title"><?php echo sprintf(__t('latest_articles', 'Latest %s'), sl_type_label('article', true)); ?></h4>
      <ul class="my-footer-recent">
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

  <div class="my-footer-bottom">
    <?php echo render_footer_content(); ?>
  </div>
</footer>
<?php do_theme_action('after_footer'); ?>

<?php echo render_search_ui(); ?>

</body>
</html>
