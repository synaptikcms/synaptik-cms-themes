<?php
/**
 * Portfolio Theme — 404.php
 */
?>
<div class="error-404">
    <div class="error-number" aria-hidden="true">404</div>
    <h1><?php echo __t('page_not_found'); ?></h1>
    <p><?php echo __t('page_not_found_desc'); ?></p>
    <a href="<?php echo cleanUrl('home'); ?>" class="btn btn-primary">&larr; <?php echo __t('back_to_home'); ?></a>
</div>
