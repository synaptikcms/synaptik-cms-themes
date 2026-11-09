<?php
/**
 * Prism Theme for Synaptik CMS — content-list.php
 *
 * @var string $list_type    Content type: 'article' | 'project' | 'page' | 'category' | 'tag'
 * @var array  $articles     Article items to display
 * @var array  $projects     Project items to display
 * @var string $filter_value Category or tag slug currently applied
 * @var array  $data         Full data store
 * @var array  $settings     Site settings
 */
?>

<?php if ($list_type === 'category' || $list_type === 'tag'): ?>

<section class="prism-list-section">
  <div class="content-container">
    <?php if (empty($articles) && empty($projects)): ?>
    <p><?php echo ($list_type === 'category') ? __t('no_content_in_category') : __t('no_content_with_tag'); ?></p>
    <?php else: ?>
      <?php if (!empty($articles)): ?>
      <div class="prism-section-header">
        <span class="prism-section-label"><?php echo sl_type_label('article', true); ?></span>
      </div>
      <div class="articles-grid">
        <?php foreach ($articles as $article): echo render_article_card($article); endforeach; ?>
      </div>
      <?php endif; ?>
      <?php if (!empty($projects)): ?>
      <div class="prism-section-header prism-section-header--spaced">
        <span class="prism-section-label"><?php echo sl_type_label('project', true); ?></span>
      </div>
      <div class="projects-grid">
        <?php foreach ($projects as $project): echo render_project_card($project); endforeach; ?>
      </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<?php elseif ($list_type === 'project'): ?>

<section class="prism-list-section">
  <div class="content-container">
    <?php if (empty($projects)): ?>
    <p><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
    <?php else: ?>
    <div class="projects-grid">
      <?php foreach ($projects as $project): echo render_project_card($project); endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php else: ?>

<section class="prism-list-section">
  <div class="content-container">
    <?php if (empty($articles)): ?>
    <p><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
    <?php else: ?>
    <div class="articles-grid">
      <?php foreach ($articles as $article): echo render_article_card($article); endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php endif; ?>
