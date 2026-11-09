<?php
/**
 * Nova Theme for Synaptik CMS — header.php
 * Fixed header with transparent-to-solid scroll effect and burger menu overlay.
 */
?><!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $metaTitle; ?></title>
  <?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800;900&display=swap">
  <?php echo render_site_favicon($settings); ?>
  <?php echo render_header_scripts($headerScripts); ?>
</head>
<body>
<?php render_adminbar(); ?>
  <header>
    <?php if ($settings['show_site_title_in_header']): ?>
    <div class="logo-container">
      <a href="<?php echo cleanUrl('home'); ?>" class="site-logo">
        <?php echo render_site_title($settings, $pageTitle); ?>
      </a>
    </div>
    <?php endif; ?>
    <button class="burger-button" aria-label="<?php echo __t('toggle_menu'); ?>">
      <span class="burger-line"></span>
      <span class="burger-line"></span>
      <span class="burger-line"></span>
    </button>
    <div class="menu-overlay">
      <nav>
        <?php
        $menu_html = renderHierarchicalMenu($settings, $data);
        $menu_html = str_replace('<ul>', '<ul class="main-menu">', $menu_html);
        $menu_html = str_replace('<a href', '<a class="menu-link" href', $menu_html);
        echo $menu_html;
        ?>
      </nav>
    </div>
  </header>
  <main>
