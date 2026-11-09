<div class="not-found">
    <p class="gazette-kicker"><?php echo hsc(__t('gazette_stop_press') ?: 'Stop Press'); ?></p>
    <p class="not-found-code">404</p>
    <h1><?php echo hsc(__t('page_not_found') ?: 'Page not found'); ?></h1>
    <p><?php echo hsc(__t('page_not_found_desc') ?: 'The page you are looking for does not exist or has been moved.'); ?></p>
    <a href="<?php echo cleanUrl('home'); ?>" class="btn-gazette">&larr; <?php echo hsc(__t('back_to_home') ?: 'Back to home'); ?></a>
</div>
