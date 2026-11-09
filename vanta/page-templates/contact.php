<?php
/* Template Name: Contact */
/**
 * Vanta Theme — page-templates/contact.php
 *
 * Contact page template with CMS contact form.
 * Available variable: $item
 */
?>
<div class="vanta-single">

    <?php if (!isset($item['show_title']) || $item['show_title']): ?>
    <h1 class="single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
    <?php endif; ?>

    <?php if (!empty($item['content'])): ?>
    <div class="prose-body" style="margin-bottom:2.5rem;">
        <?php echo render_content_html($item['content'] ?? '', $item); ?>
    </div>
    <?php endif; ?>

    <?php echo render_contact_form_html(loadConfig()); ?>

</div>
