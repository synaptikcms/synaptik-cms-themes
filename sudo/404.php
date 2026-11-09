<div class="not-found">
    <p class="prompt-line"><span class="prompt-sign">$</span> ls -la</p>
    <p class="not-found-code">404: No such file or directory</p>
    <p><?php echo hsc(__t('page_not_found_desc') ?: 'The page you are looking for does not exist or has been moved.'); ?></p>
    <a href="<?php echo cleanUrl('home'); ?>" class="btn-sudo">$ cd ~ &nbsp;<?php echo hsc(__t('back_to_home') ?: 'Back to home'); ?></a>
</div>
