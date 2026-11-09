<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $metaTitle; ?></title>
  <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link href="https://fonts.bunny.net/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,600;0,9..144,700;1,9..144,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet">
  <?php echo render_header_scripts($headerScripts); ?>
  <link rel="icon" type="image/x-icon" href="https://dorianfichot.com/data/files/favicon.ico">
</head>
<body class="natura-theme">
<div class="leaf-particles" aria-hidden="true"></div>

<header class="site-header" id="site-header">
  <div class="header-inner container">
    <div class="site-brand">
      <?php if ($settings['show_site_title_in_header']): ?>
      <a href="<?php echo cleanUrl('home'); ?>" class="brand-link">
        <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M12 2C6 2 2 7 2 12c0 5 4 9 10 10C18 21 22 17 22 12c0-5-4-10-10-10z"/>
          <path d="M12 2v20"/>
          <path d="M12 8C9 10 7 13 8 17"/>
          <path d="M12 8c3 2 5 5 4 9"/>
        </svg>
        <span class="brand-name"><?php echo htmlspecialchars($settings['site_title']); ?></span>
      </a>
      <?php endif; ?>
    </div>
    <nav class="site-nav" id="site-nav" aria-label="Navigation principale">
      <?php echo renderHierarchicalMenu($settings, $data); ?>
      <?php echo render_search_icon(); ?>
    </nav>
    <button class="nav-toggle" id="nav-toggle" aria-label="Ouvrir le menu" aria-controls="site-nav">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>
  <div class="header-plants" aria-hidden="true">
    <svg class="header-plant-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 90" fill="none">
      <!-- Main stem -->
      <path d="M80 90 Q78 60 72 40 Q65 20 60 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/>
      <!-- Large left leaf -->
      <path d="M72 40 Q52 28 40 18 Q55 22 72 40Z" fill="currentColor" opacity=".9"/>
      <path d="M72 40 Q54 32 42 22" stroke="currentColor" stroke-width=".8" stroke-linecap="round" opacity=".5"/>
      <!-- Large right leaf -->
      <path d="M76 55 Q96 38 110 30 Q98 40 76 55Z" fill="currentColor" opacity=".85"/>
      <path d="M76 55 Q94 42 108 33" stroke="currentColor" stroke-width=".8" stroke-linecap="round" opacity=".5"/>
      <!-- Upper left leaf -->
      <path d="M68 25 Q48 15 38 8 Q53 14 68 25Z" fill="currentColor" opacity=".75"/>
      <!-- Small top leaf -->
      <path d="M63 12 Q50 5 45 0 Q56 7 63 12Z" fill="currentColor" opacity=".6"/>
      <!-- Small right mid leaf -->
      <path d="M79 70 Q100 58 118 55 Q103 62 79 70Z" fill="currentColor" opacity=".7"/>
      <!-- Tiny accent leaf -->
      <path d="M80 82 Q92 76 100 74 Q91 79 80 82Z" fill="currentColor" opacity=".5"/>
    </svg>
  </div>
</header>

<main id="main-content">
<?php do_theme_action('before_content'); ?>