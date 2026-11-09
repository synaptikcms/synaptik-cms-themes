<?php
/**
 * Myelin Theme for Synaptik CMS — 404.php
 */
?>
<section class="my-404">
  <div class="my-404-inner">
    <div class="my-404-code">404</div>
    <h1><?php echo __t('page_not_found', 'Page not found.'); ?></h1>
    <p><?php echo __t('page_not_found_desc', 'The page you are looking for does not exist or has been moved.'); ?></p>
    <a href="<?php echo cleanUrl('home'); ?>" class="my-btn my-btn-primary"><?php echo __t('back_to_home', 'Back to homepage'); ?></a>
  </div>
</section>
