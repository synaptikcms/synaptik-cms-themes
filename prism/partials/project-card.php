<?php
/**
 * Prism Theme for Synaptik CMS — partials/project-card.php
 * Square flat tile: image fades out on hover, bold color fill with white text reveals.
 * Variables: $project, $project_link, $card_class
 */
$project_link = $project_link ?? '#';
$card_class   = $card_class ?? 'project-card';
?>
<article class="<?php echo $card_class; ?>">
  <a href="<?php echo $project_link; ?>" class="project-card-link"
     aria-label="<?php echo htmlspecialchars($project['title']); ?>">
    <?php if (!empty($project['image'])): ?>
    <div class="project-thumbnail">
      <img src="<?php echo getBaseUrl() . htmlspecialchars($project['image']); ?>"
           alt="<?php echo htmlspecialchars($project['title']); ?>"
           loading="lazy">
    </div>
    <?php endif; ?>
    <div class="project-overlay">
      <?php if (!empty($project['category'])): ?>
      <span class="project-category"><?php echo htmlspecialchars($project['category']); ?></span>
      <?php endif; ?>
      <h3><?php echo htmlspecialchars($project['title']); ?></h3>
      <?php
      $desc = !empty($project['description']) ? $project['description'] : ($project['meta_description'] ?? '');
      if ($desc): ?>
      <p class="project-excerpt"><?php echo htmlspecialchars(mb_substr(strip_tags($desc), 0, 110)); ?>…</p>
      <?php endif; ?>
      <?php if (!empty($project['tags']) && is_array($project['tags'])): ?>
      <div class="project-tags">
        <?php $__tagStore = sl_load_tags(); foreach (array_slice($project['tags'], 0, 3) as $tag):
            $__tagSlug = sanitizeSlug($tag);
            if ($__tagSlug === '') continue;
            $__tagName = $__tagStore[$__tagSlug]['name'] ?? $tag;
        ?>
        <a href="<?php echo getBaseUrl() . url_slug('tag') . '/' . $__tagSlug . '/'; ?>" class="tag-link">
          <?php echo htmlspecialchars($__tagName); ?>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <span class="view-project"><?php echo __t('view_project'); ?></span>
    </div>
  </a>
</article>
