<?php
/* Template Name: Contact */
/**
 * Myelin Theme — page-template: Contact
 *
 * Two-column contact layout: intro / details on the left, contact form on the right.
 *
 * @var array $item
 */
$settings = loadConfig();
?>
<section class="my-page my-page--contact">
  <div class="my-contact-grid">

    <div class="my-contact-intro" data-reveal>
      <?php if (!empty($item['category'])): ?>
      <div class="my-page-eyebrow"><?php echo htmlspecialchars($item['category']); ?></div>
      <?php endif; ?>
      <h1 class="my-page-title"><?php echo htmlspecialchars($item['title']); ?></h1>
      <?php if (!empty($item['meta_description'])): ?>
      <p class="my-page-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
      <?php endif; ?>
      <?php if (!empty(trim(strip_tags($item['content'] ?? '')))): ?>
      <div class="my-prose">
        <?php echo render_content_html($item['content'] ?? '', $item); ?>
      </div>
      <?php endif; ?>
    </div>

    <div class="my-contact-form-wrap" data-reveal>
      <?php echo render_contact_form_html(); ?>
    </div>

  </div>
</section>
