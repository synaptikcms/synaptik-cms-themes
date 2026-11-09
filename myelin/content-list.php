<?php
/**
 * Myelin Theme for Synaptik CMS — content-list.php
 *
 * Renders lists of articles, projects, pages, categories, and tags.
 *
 * @var string $list_type    'article' | 'project' | 'page' | 'category' | 'tag'
 * @var array  $articles
 * @var array  $projects
 * @var array  $items
 * @var string $filter_value
 * @var array  $data
 * @var array  $settings
 */
?>
<section class="my-list">
  <div class="my-list-inner">

    <header class="my-list-head" data-reveal>
      <?php if ($list_type === 'category'): ?>
        <span class="my-list-eyebrow"><?php echo __t('breadcrumb_category', 'Category'); ?></span>
        <h1><?php echo htmlspecialchars($filter_value); ?></h1>
      <?php elseif ($list_type === 'tag'): ?>
        <span class="my-list-eyebrow"><?php echo __t('breadcrumb_tag', 'Tag'); ?></span>
        <h1><?php echo htmlspecialchars($filter_value); ?></h1>
      <?php elseif ($list_type === 'project'): ?>
        <h1><?php echo __t('projects', 'Projects'); ?></h1>
      <?php elseif ($list_type === 'page'): ?>
        <h1><?php echo __t('pages', 'Pages'); ?></h1>
      <?php else: ?>
        <h1><?php echo __t('articles', 'Articles'); ?></h1>
      <?php endif; ?>
    </header>

    <?php if ($list_type === 'category' || $list_type === 'tag'): ?>
      <?php if (empty($articles) && empty($projects)): ?>
        <p class="my-list-empty">
          <?php echo $list_type === 'category' ? __t('no_content_in_category') : __t('no_content_with_tag'); ?>
        </p>
      <?php else: ?>
        <?php if (!empty($articles)): ?>
          <h2 class="my-list-subhead"><?php echo sl_type_label('article', true); ?></h2>
          <div class="articles-grid" data-reveal>
            <?php foreach ($articles as $article): echo render_article_card($article); endforeach; ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($projects)): ?>
          <h2 class="my-list-subhead"><?php echo sl_type_label('project', true); ?></h2>
          <div class="projects-grid" data-reveal>
            <?php foreach ($projects as $project): echo render_project_card($project); endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>

    <?php elseif ($list_type === 'project'): ?>
      <?php if (empty($projects)): ?>
        <p class="my-list-empty"><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
      <?php else: ?>
        <div class="projects-grid" data-reveal>
          <?php foreach ($projects as $project): echo render_project_card($project); endforeach; ?>
        </div>
      <?php endif; ?>

    <?php else: /* article, page */ ?>
      <?php if (empty($articles)): ?>
        <p class="my-list-empty"><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
      <?php else: ?>
        <div class="articles-grid" data-reveal>
          <?php foreach ($articles as $article): echo render_article_card($article); endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </div>
</section>
