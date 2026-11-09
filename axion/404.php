<?php
/**
 * Axion Theme for Synaptik CMS — 404.php
 */
?>
<section class="ax-404">
  <div class="ax-404-inner">
    <span class="ax-eyebrow">Error · 404</span>
    <h1 class="ax-404-title"><?php echo __t('page_not_found', 'Page not found.'); ?></h1>
    <p><?php echo __t('page_not_found_desc'); ?></p>
    <a href="<?php echo cleanUrl('home'); ?>" class="ax-btn ax-btn-primary"><?php echo __t('back_to_home', 'Back to homepage'); ?> <span aria-hidden="true">→</span></a>
  </div>
</section>
