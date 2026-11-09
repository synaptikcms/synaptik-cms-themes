<?php
/**
 * Axion Theme — partials/project-card.php
 *
 * @var array  $project
 * @var string $project_link
 * @var string $card_class
 */
?>
<article class="project-card ax-pcard <?php echo htmlspecialchars($card_class ?? ''); ?>">
  <?php if (!empty($project['image'])): ?>
  <a href="<?php echo $project_link; ?>" class="ax-pcard-media">
    <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" loading="lazy" decoding="async">
  </a>
  <?php endif; ?>
  <div class="ax-pcard-body">
    <h3 class="ax-pcard-title">
      <a href="<?php echo $project_link; ?>"><?php echo htmlspecialchars($project['title']); ?></a>
    </h3>
    <?php if (!empty($project['description'])): ?>
    <p class="ax-pcard-excerpt"><?php echo htmlspecialchars($project['description']); ?></p>
    <?php endif; ?>
    <span class="ax-pcard-arrow" aria-hidden="true">→</span>
  </div>
</article>
