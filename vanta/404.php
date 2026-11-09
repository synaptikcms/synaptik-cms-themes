<?php
/**
 * Vanta Theme — 404.php
 *
 * 404 error page with glitch effect on the number.
 */
?>
<div class="vanta-404">
    <p class="vanta-404-code" data-text="404" aria-hidden="true">404</p>
    <h1><?php echo __t('page_not_found') ?: 'Page not found.'; ?></h1>
    <p><?php echo __t('page_not_found_desc') ?: 'The page you are looking for does not exist or has been moved.'; ?></p>
    <a href="<?php echo cleanUrl('home'); ?>" class="btn-back">
        ← <?php echo __t('back_to_home') ?: 'Back to home'; ?>
    </a>
</div>
