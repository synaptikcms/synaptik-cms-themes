<?php
/* Template Name: Studio Landing */

/**
 * Atrium Theme — page-templates/atrium-studio.php
 *
 * Editorial corporate landing template. Each section is wrapped in a clearly
 * commented block so non-developers can locate and edit copy directly in the
 * page content (via the editor's HTML mode) OR by overriding the template in
 * a child theme. Numeric stat targets are read from data-target attributes
 * and counted up by the theme script on first scroll into view.
 */

// $item is injected by loadThemeTemplate()

// Contact page URL — update the slug below to match your actual contact page slug,
// or replace with any URL (e.g. a mailto: link or an external booking page).
$df_contact_url = cleanUrl('page', 'contact');
?>
<section class="atrium-studio">

  <!-- ============================================================
	   HERO — change eyebrow, headline (use <em> for italic accent),
	   lede, and the two CTA hrefs/labels.
	   ============================================================ -->
  <header class="atrium-studio-hero atrium-reveal">
	<p class="atrium-eyebrow"><span class="atrium-eyebrow-line" aria-hidden="true"></span><?php echo __t('atrium_studio_eyebrow', 'Independent studio · Est. 2024'); ?></p>
	<h1 class="atrium-studio-headline">
	  <?php
		// The first word of the page title is wrapped in <em> for the
		// serif italic accent. If you prefer a fully manual headline,
		// replace this block with literal HTML.
		$df_title = $item['title'] ?? __t('atrium_studio_default_title', 'We design quiet things that endure.');
		$df_words = preg_split('/\s+/', $df_title, 2);
		if (count($df_words) === 2) {
			echo '<em>' . htmlspecialchars($df_words[0]) . '</em> ' . htmlspecialchars($df_words[1]);
		} else {
			echo htmlspecialchars($df_title);
		}
	  ?>
	</h1>
	<?php if (!empty($item['summary']) || !empty($item['meta_description'])): ?>
	<p class="atrium-studio-lede"><?php echo htmlspecialchars($item['summary'] ?? $item['meta_description']); ?></p>
	<?php endif; ?>
	<div class="atrium-studio-cta">
	  <a href="#atrium-studio-services" class="atrium-btn atrium-btn--solid"><?php echo __t('atrium_studio_cta_primary', 'Discover the work'); ?></a>
	  <a href="<?php echo $df_contact_url; ?>" class="atrium-btn atrium-btn--ghost" data-atrium-link><?php echo __t('atrium_studio_cta_secondary', 'Start a project'); ?></a>
	</div>
  </header>

  <!-- ============================================================
	   CLIENTS STRIP — purely typographic, no logo uploads needed.
	   Edit the names in the unordered list below.
	   ============================================================ -->
  <section class="atrium-studio-clients atrium-reveal" aria-label="<?php echo htmlspecialchars(__t('atrium_studio_trusted_by', 'Trusted by')); ?>">
	<p class="atrium-studio-clients-label"><?php echo __t('atrium_studio_trusted_by', 'Trusted by'); ?></p>
	<ul class="atrium-studio-clients-list">
	  <li>Maison Calme</li>
	  <li>Atelier Nord</li>
	  <li>Hôtel Verre</li>
	  <li>Studio Pli</li>
	  <li>Édition Quinze</li>
	  <li>La Compagnie</li>
	</ul>
  </section>

  <!-- ============================================================
	   SERVICES — three columns. Duplicate <article> to add more.
	   Each card: span.num (display only), <h3>, <p>.
	   ============================================================ -->
  <section id="atrium-studio-services" class="atrium-studio-services atrium-reveal">
	<header class="atrium-section-head">
	  <span class="atrium-section-num">I.</span>
	  <h2 class="atrium-section-title"><?php echo __t('atrium_studio_services', 'What we do'); ?></h2>
	</header>
	<div class="atrium-studio-services-grid atrium-stagger">

	  <article class="atrium-studio-service">
		<span class="atrium-studio-service-num">01</span>
		<h3><?php echo __t('atrium_studio_s1_title', 'Brand identity'); ?></h3>
		<p><?php echo __t('atrium_studio_s1_desc', 'Marks, typography systems, art direction. Quiet, considered, built to last past the launch.'); ?></p>
	  </article>

	  <article class="atrium-studio-service">
		<span class="atrium-studio-service-num">02</span>
		<h3><?php echo __t('atrium_studio_s2_title', 'Editorial design'); ?></h3>
		<p><?php echo __t('atrium_studio_s2_desc', 'Books, catalogues, long-form web. The kind of reading that asks for a second cup of coffee.'); ?></p>
	  </article>

	  <article class="atrium-studio-service">
		<span class="atrium-studio-service-num">03</span>
		<h3><?php echo __t('atrium_studio_s3_title', 'Digital craft'); ?></h3>
		<p><?php echo __t('atrium_studio_s3_desc', 'Sites that load fast, age well, and do not need a designer to update. Built on flat files.'); ?></p>
	  </article>

	</div>
  </section>

  <!-- ============================================================
	   STATS — animated counters. To change a number, edit data-target.
	   Suffix (% / + / k) is plain text in the markup after <span>.
	   ============================================================ -->
  <section class="atrium-studio-stats atrium-reveal">
	<div class="atrium-studio-stat">
	  <span class="atrium-studio-stat-num" data-atrium-count data-target="64">0</span>
	  <span class="atrium-studio-stat-suffix">+</span>
	  <p class="atrium-studio-stat-label"><?php echo __t('atrium_studio_stat1', 'Projects delivered'); ?></p>
	</div>
	<div class="atrium-studio-stat">
	  <span class="atrium-studio-stat-num" data-atrium-count data-target="12">0</span>
	  <span class="atrium-studio-stat-suffix"></span>
	  <p class="atrium-studio-stat-label"><?php echo __t('atrium_studio_stat2', 'Countries served'); ?></p>
	</div>
	<div class="atrium-studio-stat">
	  <span class="atrium-studio-stat-num" data-atrium-count data-target="98">0</span>
	  <span class="atrium-studio-stat-suffix">%</span>
	  <p class="atrium-studio-stat-label"><?php echo __t('atrium_studio_stat3', 'Returning clients'); ?></p>
	</div>
  </section>

  <!-- ============================================================
	   FREE CONTENT — anything written in the page editor is rendered
	   here. Use it for an "about" paragraph or a manifesto.
	   ============================================================ -->
  <?php if (!empty($item['content'])): ?>
  <section class="atrium-studio-prose atrium-prose atrium-reveal">
	<?php echo render_content_html($item['content'], $item); ?>
  </section>
  <?php endif; ?>

  <!-- ============================================================
	   FINAL CTA — large editorial closing. Edit the headline and
	   the button href/label below.
	   ============================================================ -->
  <section class="atrium-studio-final atrium-reveal">
	<h2 class="atrium-studio-final-title"><?php echo __t('atrium_studio_final_title', 'Have a project that needs unhurried thinking?'); ?></h2>
	<a href="<?php echo $df_contact_url; ?>" class="atrium-btn atrium-btn--solid atrium-btn--lg" data-atrium-link>
	  <?php echo __t('atrium_studio_final_cta', 'Let’s talk'); ?>
	  <svg width="16" height="16" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7h8M7 3l4 4-4 4"/></svg>
	</a>
  </section>

</section>