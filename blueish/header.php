<?php
$bodyClass = function_exists('theme_body_class') ? theme_body_class() : 'theme-synaptik';
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($settings['active_language'] ?? 'en'); ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $metaTitle; ?></title>
	<?php echo render_meta_tags($settings, $metaTitle, $metaDescription); ?>
	<link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
	<link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Saira+Extra+Condensed:wght@300;500&display=swap">
	<?php echo render_site_favicon($settings); ?>
	<?php echo render_header_scripts($headerScripts); ?>
</head>

<body class="<?php echo $bodyClass; ?>">
<header>
	<div class="site-header">
		<div class="logo"><?php echo render_site_logo($settings) ?></div>
	<?php if ($settings["show_site_title_in_header"]): ?>
	<h1 class="sitetitle"><a href="<?php echo cleanUrl("home"); ?>" style="text-decoration: none; color: inherit;"><?php echo htmlspecialchars($settings["site_title"]); ?></a></h1>
	<?php endif; ?>
	</div>
	<nav>
		<?php echo renderHierarchicalMenu($settings, $data); ?>
	
	</nav>
</header>
<main>