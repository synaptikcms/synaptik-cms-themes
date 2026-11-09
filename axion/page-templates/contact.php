<?php
/* Template Name: Contact */
/**
 * Axion Theme — page-template: Contact
 *
 * Sticky-split layout:
 *  - Left column (sticky on desktop): eyebrow, large title, lede, contact
 *    method cards rendered from custom fields (each row becomes a card).
 *  - Right column: contact form.
 *
 * @var array $item
 */
$settings = loadConfig();

$fields = $item['custom_fields'] ?? [];
?>

<section class="ax-ct">
  <div class="ax-ct-inner">

    <aside class="ax-ct-side" data-reveal>
      <span class="ax-eyebrow"><?php echo htmlspecialchars($item['category'] ?: __t('get_in_touch', 'Get in touch')); ?></span>
      <h1 class="ax-ct-title"><?php echo htmlspecialchars($item['title']); ?></h1>
      <?php if (!empty($item['meta_description'])): ?>
      <p class="ax-ct-lede"><?php echo htmlspecialchars($item['meta_description']); ?></p>
      <?php endif; ?>

      <?php if (!empty(trim(strip_tags($item['content'] ?? '')))): ?>
      <div class="ax-ct-prose ax-prose">
        <?php echo render_content_html($item['content'] ?? '', $item); ?>
      </div>
      <?php endif; ?>

      <?php if (!empty($fields)): ?>
      <ul class="ax-ct-methods">
        <?php foreach ($fields as $key => $value):
          if ($value === '' || $value === null) continue;
          $schemaList = $settings['custom_fields_schema']['page'] ?? [];
          $label = $key;
          foreach ($schemaList as $f) {
            if (($f['key'] ?? '') === $key) { $label = $f['label'] ?? $key; break; }
          }
        ?>
        <li class="ax-ct-method">
          <span class="ax-ct-method-label"><?php echo htmlspecialchars($label); ?></span>
          <span class="ax-ct-method-value">
            <?php if (filter_var($value, FILTER_VALIDATE_EMAIL)): ?>
              <a href="mailto:<?php echo htmlspecialchars($value); ?>"><?php echo htmlspecialchars($value); ?></a>
            <?php elseif (filter_var($value, FILTER_VALIDATE_URL)): ?>
              <a href="<?php echo htmlspecialchars($value); ?>" target="_blank" rel="noopener"><?php echo htmlspecialchars($value); ?></a>
            <?php else: ?>
              <?php echo nl2br(htmlspecialchars($value)); ?>
            <?php endif; ?>
          </span>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </aside>

    <div class="ax-ct-form-wrap" data-reveal>
      <div class="ax-ct-form-card">
        <h2 class="ax-ct-form-title"><?php echo __t('send_message', 'Send a message'); ?></h2>
        <p class="ax-ct-form-sub"><?php echo __t('contact_form_sub', 'Tell us what you have in mind. We typically reply within one business day.'); ?></p>
        <?php echo render_contact_form_html(); ?>
      </div>
    </div>

  </div>
</section>
