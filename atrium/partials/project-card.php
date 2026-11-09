<?php
/**
 * Atrium Theme for Synaptik CMS — partials/project-card.php
 *
 * Gallery-style tile: image with corner number, caption strip below.
 * Variables: $project, $project_link, $card_class
 */
$project_link = $project_link ?? '#';
$card_class   = $card_class ?? 'atrium-exhibit';
?>
<article class="<?php echo htmlspecialchars($card_class); ?> atrium-exhibit">
  <a href="<?php echo $project_link; ?>" class="atrium-exhibit-link" data-atrium-link
	 aria-label="<?php echo htmlspecialchars($project['title']); ?>">
	<div class="atrium-exhibit-frame">
	  <?php if (!empty($project['image'])): ?>
	  <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>"
		   alt="<?php echo htmlspecialchars($project['title']); ?>"
		   loading="lazy" decoding="async">
	  <?php else: ?>
	  <div class="atrium-exhibit-placeholder" aria-hidden="true"></div>
	  <?php endif; ?>
	  <span class="atrium-exhibit-corner" aria-hidden="true">
		<svg width="20" height="20" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h8M7 3l4 4-4 4"/></svg>
	  </span>
	</div>
	<div class="atrium-exhibit-caption">
	  <h3 class="atrium-exhibit-title"><?php echo htmlspecialchars($project['title']); ?></h3>
	  <div class="atrium-exhibit-meta">
		<?php if (!empty($project['category'])): ?>
		<span class="atrium-exhibit-cat"><?php echo htmlspecialchars($project['category']); ?></span>
		<?php endif; ?>
		<?php if (!empty($project['date'])): ?>
		<time datetime="<?php echo htmlspecialchars($project['date']); ?>"><?php echo htmlspecialchars(date('Y', strtotime($project['date']))); ?></time>
		<?php endif; ?>
	  </div>
	</div>
  </a>
</article>