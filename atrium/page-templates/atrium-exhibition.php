<?php
/* Template Name: Exhibition Program */

/**
 * Atrium Theme — page-templates/atrium-exhibition.php
 *
 * Exhibition / event program landing template. Structured around a marquee
 * title band, an editorial header with facts grid, a full-bleed cover image,
 * an opening statement, a timed program (timeline), a people / speakers list,
 * and a practical information closing block.
 *
 * All section content can be edited by replacing the placeholder strings with
 * calls to get_custom_field($item, 'key') once the relevant custom field schema
 * is defined in Settings, or by overriding the template in a child theme.
 *
 * $item is injected by loadThemeTemplate().
 */

$df_title       = $item['title']    ?? '';
$df_summary     = $item['summary']  ?? $item['meta_description'] ?? '';
$df_content     = $item['content']  ?? '';
$df_base        = getBaseUrl();
$df_settings    = loadConfig();

// Contact/booking URL — update the slug below to match your actual contact page slug,
// or replace with any URL (e.g. a mailto: link or an external booking form).
$df_contact_url = cleanUrl('page', 'contact');
?>
<div class="atrium-exhibit-page">

  <!-- ============================================================
       MARQUEE TITLE BAND — repeats the page title in oversized
       italic serif. Scrolls on a 60s loop, pauses on hover.
       ============================================================ -->
  <?php if (!empty($df_title)): ?>
  <div class="atrium-exh-marquee" aria-hidden="true">
    <div class="atrium-exh-marquee-track">
      <?php
        // Repeat enough times to fill any viewport width.
        $df_sep   = '<span class="atrium-exh-marquee-sep">&#x2014;</span>';
        $df_item  = '<span class="atrium-exh-marquee-item">' . htmlspecialchars($df_title) . '</span>';
        $df_chunk = $df_item . ' ' . $df_sep . ' ';
        echo str_repeat($df_chunk, 8);
      ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- ============================================================
       EDITORIAL HEADER — oversized title left, facts grid right.
       Add or remove <div class="atrium-exh-fact"> entries as needed.
       ============================================================ -->
  <header class="atrium-exh-head atrium-reveal">
    <h1 class="atrium-exh-title"><?php echo htmlspecialchars($df_title); ?></h1>

    <dl class="atrium-exh-facts">
      <div class="atrium-exh-fact">
        <dt><?php echo __t('atrium_exh_fact_dates', 'Dates'); ?></dt>
        <dd><?php echo __t('atrium_exh_fact_dates_val', '14 – 28 June 2025'); ?></dd>
      </div>
      <div class="atrium-exh-fact">
        <dt><?php echo __t('atrium_exh_fact_venue', 'Venue'); ?></dt>
        <dd><?php echo __t('atrium_exh_fact_venue_val', 'Grand Palais · Paris'); ?></dd>
      </div>
      <div class="atrium-exh-fact">
        <dt><?php echo __t('atrium_exh_fact_format', 'Format'); ?></dt>
        <dd><?php echo __t('atrium_exh_fact_format_val', 'Open to all · Free'); ?></dd>
      </div>
      <div class="atrium-exh-fact">
        <dt><?php echo __t('atrium_exh_fact_edition', 'Edition'); ?></dt>
        <dd><?php echo __t('atrium_exh_fact_edition_val', '3rd'); ?></dd>
      </div>
    </dl>
  </header>

  <!-- ============================================================
       FULL-BLEED COVER — uses the page's featured image if set.
       Falls back gracefully to a tinted background.
       ============================================================ -->
  <?php if (!empty($item['image']) && (!isset($item['show_featured_image']) || $item['show_featured_image'])): ?>
  <div class="atrium-exh-cover atrium-reveal">
    <img src="<?php echo $df_base . htmlspecialchars($item['image']); ?>"
         alt="<?php echo htmlspecialchars($df_title); ?>"
         loading="eager" decoding="async">
  </div>
  <?php endif; ?>

  <!-- ============================================================
       OPENING STATEMENT — uses the page summary or meta description
       as the introductory paragraph. Displayed in large editorial
       serif. Falls back to the rendered page content if no summary.
       ============================================================ -->
  <?php if (!empty($df_summary)): ?>
  <div class="atrium-exh-statement atrium-reveal">
    <p class="atrium-article-lede"><?php echo htmlspecialchars($df_summary); ?></p>
  </div>
  <?php endif; ?>

  <!-- ============================================================
       FREE CONTENT BLOCK — anything written in the page editor
       is rendered here (HTML or Markdown). Use it for a curatorial
       text, manifesto, or extended description.
       ============================================================ -->
  <?php if (!empty($df_content)): ?>
  <div class="atrium-exh-statement atrium-prose atrium-reveal">
    <?php echo render_content_html($df_content, $item); ?>
  </div>
  <?php endif; ?>

  <!-- ============================================================
       PROGRAM / TIMELINE — list of events with time and description.
       Duplicate <article class="atrium-exh-event"> for each entry.
       ============================================================ -->
  <section class="atrium-exh-program atrium-reveal" aria-labelledby="atrium-exh-program-title">
    <header class="atrium-section-head">
      <span class="atrium-section-num">I.</span>
      <h2 class="atrium-section-title" id="atrium-exh-program-title">
        <?php echo __t('atrium_exh_program_title', 'Program'); ?>
      </h2>
    </header>

    <div class="atrium-exh-timeline atrium-stagger">

      <article class="atrium-exh-event">
        <div class="atrium-exh-event-time">
          <time datetime="2025-06-14T10:00"><?php echo __t('atrium_exh_ev1_time', 'June 14 · 10:00'); ?></time>
        </div>
        <div class="atrium-exh-event-body">
          <h3><?php echo __t('atrium_exh_ev1_title', 'Opening Ceremony'); ?></h3>
          <p><?php echo __t('atrium_exh_ev1_desc', 'Official opening with a welcome address, artist presentations, and a guided walkthrough of the main galleries.'); ?></p>
        </div>
      </article>

      <article class="atrium-exh-event">
        <div class="atrium-exh-event-time">
          <time datetime="2025-06-15T14:00"><?php echo __t('atrium_exh_ev2_time', 'June 15 · 14:00'); ?></time>
        </div>
        <div class="atrium-exh-event-body">
          <h3><?php echo __t('atrium_exh_ev2_title', 'Roundtable — The Slow Image'); ?></h3>
          <p><?php echo __t('atrium_exh_ev2_desc', 'Four photographers and one philosopher discuss deliberation, analogue process, and the ethics of looking.'); ?></p>
        </div>
      </article>

      <article class="atrium-exh-event">
        <div class="atrium-exh-event-time">
          <time datetime="2025-06-18T19:00"><?php echo __t('atrium_exh_ev3_time', 'June 18 · 19:00'); ?></time>
        </div>
        <div class="atrium-exh-event-body">
          <h3><?php echo __t('atrium_exh_ev3_title', 'Vernissage — Nocturne Edition'); ?></h3>
          <p><?php echo __t('atrium_exh_ev3_desc', 'Evening opening with live string quartet, candle-lit installations, and a limited-edition print available on the night.'); ?></p>
        </div>
      </article>

      <article class="atrium-exh-event">
        <div class="atrium-exh-event-time">
          <time datetime="2025-06-22T11:00"><?php echo __t('atrium_exh_ev4_time', 'June 22 · 11:00'); ?></time>
        </div>
        <div class="atrium-exh-event-body">
          <h3><?php echo __t('atrium_exh_ev4_title', 'Workshop — Silver Gelatin Printing'); ?></h3>
          <p><?php echo __t('atrium_exh_ev4_desc', 'A hands-on darkroom session for twelve participants. Booking required. Materials and chemicals provided.'); ?></p>
        </div>
      </article>

      <article class="atrium-exh-event">
        <div class="atrium-exh-event-time">
          <time datetime="2025-06-28T17:00"><?php echo __t('atrium_exh_ev5_time', 'June 28 · 17:00'); ?></time>
        </div>
        <div class="atrium-exh-event-body">
          <h3><?php echo __t('atrium_exh_ev5_title', 'Closing & Collectors Preview'); ?></h3>
          <p><?php echo __t('atrium_exh_ev5_desc', 'Final afternoon open to registered collectors, followed by a closing toast with the artists.'); ?></p>
        </div>
      </article>

    </div>
  </section>

  <!-- ============================================================
       PEOPLE — speakers, artists, curators. Add or remove <li>.
       Name goes in .atrium-exh-person-name, role in -role.
       ============================================================ -->
  <section class="atrium-exh-people atrium-reveal" aria-labelledby="atrium-exh-people-title">
    <header class="atrium-section-head">
      <span class="atrium-section-num">II.</span>
      <h2 class="atrium-section-title" id="atrium-exh-people-title">
        <?php echo __t('atrium_exh_people_title', 'Participants'); ?>
      </h2>
    </header>

    <ul class="atrium-exh-people-list atrium-stagger">
      <li>
        <span class="atrium-exh-person-name">Élise Martel</span>
        <span class="atrium-exh-person-role"><?php echo __t('atrium_exh_role_curator', 'Curator'); ?></span>
      </li>
      <li>
        <span class="atrium-exh-person-name">Jonas Weerth</span>
        <span class="atrium-exh-person-role"><?php echo __t('atrium_exh_role_photographer', 'Photographer'); ?></span>
      </li>
      <li>
        <span class="atrium-exh-person-name">Amara Diallo</span>
        <span class="atrium-exh-person-role"><?php echo __t('atrium_exh_role_artist', 'Visual artist'); ?></span>
      </li>
      <li>
        <span class="atrium-exh-person-name">Claire Tung</span>
        <span class="atrium-exh-person-role"><?php echo __t('atrium_exh_role_critic', 'Art critic'); ?></span>
      </li>
      <li>
        <span class="atrium-exh-person-name">Rafael Soriano</span>
        <span class="atrium-exh-person-role"><?php echo __t('atrium_exh_role_photographer', 'Photographer'); ?></span>
      </li>
      <li>
        <span class="atrium-exh-person-name">Nour Khalil</span>
        <span class="atrium-exh-person-role"><?php echo __t('atrium_exh_role_filmmaker', 'Filmmaker'); ?></span>
      </li>
    </ul>
  </section>

  <!-- ============================================================
       PRACTICAL INFORMATION — location, hours, access.
       Edit the strings below or wire to custom fields.
       ============================================================ -->
  <section class="atrium-exh-practical atrium-reveal" aria-labelledby="atrium-exh-practical-title">
    <h2 class="atrium-exh-practical-title" id="atrium-exh-practical-title">
      <?php echo __t('atrium_exh_practical_title', 'Plan your visit'); ?>
    </h2>
    <p class="atrium-exh-practical-desc">
      <?php echo __t('atrium_exh_practical_desc', 'Open Tuesday to Sunday, 10:00 – 19:00. Late night Thursdays until 22:00. Free admission. Guided tours every Saturday at 11:00 and 15:00.'); ?>
    </p>
    <div style="display:flex; gap:14px; justify-content:center; flex-wrap:wrap;">
      <a href="<?php echo $df_contact_url; ?>" class="atrium-btn atrium-btn--solid" data-atrium-link>
        <?php echo __t('atrium_exh_cta_book', 'Book a guided tour'); ?>
      </a>
      <a href="<?php echo $df_contact_url; ?>" class="atrium-btn atrium-btn--ghost" data-atrium-link>
        <?php echo __t('atrium_exh_cta_directions', 'Get directions'); ?>
      </a>
    </div>
  </section>

</div>
