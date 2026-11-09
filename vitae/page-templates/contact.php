<?php /* Template Name: CV — Contact */ ?>
<article class="vt-single vt-tpl-contact">
    <div class="vt-single-inner">

        <?php if (!isset($item['show_title']) || $item['show_title']): ?>
        <h1 class="vt-single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
        <?php endif; ?>

        <?php if (!empty($item['content'])): ?>
        <div class="vt-prose vt-contact-intro">
            <?php echo render_content_html($item['content'], $item); ?>
        </div>
        <?php endif; ?>

        <?php echo render_contact_form_html(); ?>

    </div>
</article>
