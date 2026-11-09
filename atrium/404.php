<?php
/**
 * Atrium Theme for Synaptik CMS — 404.php
 */
?>
<section class="atrium-404">
  <p class="atrium-eyebrow"><span class="atrium-eyebrow-line" aria-hidden="true"></span>404</p>
  <h1 class="atrium-404-title"><?php echo __t('page_not_found'); ?></h1>
  <p class="atrium-404-desc"><?php echo __t('page_not_found_desc'); ?></p>
  <a href="<?php echo cleanUrl('home'); ?>" class="atrium-btn atrium-btn--ghost" data-atrium-link>
    ← <?php echo __t('back_to_home'); ?>
  </a>
</section>
