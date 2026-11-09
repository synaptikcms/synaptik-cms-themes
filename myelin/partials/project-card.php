<?php
/**
 * Myelin Theme for Synaptik CMS — partials/project-card.php
 *
 * @var array  $project
 * @var string $project_link
 * @var string $card_class
 */
?>
<article class="project-card my-card my-card--project <?php echo htmlspecialchars($card_class ?? ''); ?>">
  <?php if (!empty($project['image'])): ?>
  <a href="<?php echo $project_link; ?>" class="my-card-media my-card-media--tall">
    <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>"
         alt="<?php echo htmlspecialchars($project['title']); ?>"
         loading="lazy" decoding="async">
  </a>
  <?php endif; ?>
  <div class="my-card-body">
    <h3 class="my-card-title">
      <a href="<?php echo $project_link; ?>"><?php echo htmlspecialchars($project['title']); ?></a>
    </h3>
    <?php if (!empty($project['description'])): ?>
    <p class="my-card-excerpt"><?php echo htmlspecialchars($project['description']); ?></p>
    <?php endif; ?>
    <div class="my-card-foot">
      <a href="<?php echo $project_link; ?>" class="my-card-link"><?php echo __t('view_project'); ?> <span aria-hidden="true">→</span></a>
    </div>
  </div>
</article>
