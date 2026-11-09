<?php
/**
 * Portfolio Theme — page-templates/contact.php
 * Template Name: Contact
 */
?>
<div class="contact-page">
    <div class="single-hero">
        <div class="single-hero-text">
            <?php echo render_content_title($item); ?>
        </div>
    </div>
    <?php if (!empty($item['content'])): ?>
    <div class="single-layout">
        <div class="single-content prose">
            <?php echo render_content_html($item['content'], $item); ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="contact-form-wrap">
        <?php echo render_contact_form_html($settings ?? loadConfig()); ?>
    </div>
</div>
