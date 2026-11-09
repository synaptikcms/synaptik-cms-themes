<?php
$heroTitle = htmlspecialchars($settings['site_title'] ?? 'Bienvenue');
$heroDesc  = htmlspecialchars($settings['site_description'] ?? '');
?>

<section class="home-hero reveal">
  <p class="hero-eyebrow">
    <?php
    $eyebrow = !empty($settings['site_description']) ? strtok($settings['site_description'], '.') : 'Bienvenue';
    echo htmlspecialchars(mb_strimwidth($eyebrow, 0, 60, '…'));
    ?>
  </p>
  <h1><?php echo $heroTitle; ?></h1>
  <?php if ($heroDesc): ?>
  <p class="site-tagline"><?php echo $heroDesc; ?></p>
  <?php endif; ?>
  <div class="hero-divider" aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12 2C6 2 2 7 2 12c0 5 4 9 10 10C18 21 22 17 22 12c0-5-4-10-10-10zm0 0v20M12 8C9 10 7 13 8 17M12 8c3 2 5 5 4 9"/>
    </svg>
  </div>
</section>
<section class="homepage-content">
  <?php echo render_home_articles($data, $settings); ?>
  <?php echo render_home_projects($data, $settings); ?>
</section>
