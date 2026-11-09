<?php
/**
 * Axion Theme for Synaptik CMS — content-list.php
 * List view for articles, projects, pages, categories, and tags.
 *
 * @var string $list_type
 * @var array  $articles
 * @var array  $projects
 * @var array  $items
 * @var string $filter_value
 * @var array  $data
 * @var array  $settings
 */
?>
<section class="ax-list">
  <div class="ax-list-inner">

    <header class="ax-list-head" data-reveal>
      <?php if ($list_type === 'category'): ?>
        <?php
            // Resolve the display name from the categories store — $filter_value is only the slug
            $categories   = sl_load_categories();
            $categoryName = $categories[$filter_value]['name'] ?? $filter_value;
        ?>
        <span class="ax-eyebrow"><?php echo __t('breadcrumb_category', 'Category'); ?></span>
        <h1 class="ax-list-title"><?php echo htmlspecialchars($categoryName); ?></h1>
      <?php elseif ($list_type === 'tag'): ?>
        <?php
            // Resolve the display name from the tags store — $filter_value is only the slug
            $tags    = sl_load_tags();
            $tagName = $tags[$filter_value]['name'] ?? $filter_value;
        ?>
        <span class="ax-eyebrow"><?php echo __t('breadcrumb_tag', 'Tag'); ?></span>
        <h1 class="ax-list-title">#<?php echo htmlspecialchars($tagName); ?></h1>
      <?php elseif ($list_type === 'project'): ?>
        <span class="ax-eyebrow"><?php echo __t('archive', 'Archive'); ?></span>
        <h1 class="ax-list-title"><?php echo __t('projects', 'Projects'); ?></h1>
      <?php elseif ($list_type === 'page'): ?>
        <span class="ax-eyebrow"><?php echo __t('archive', 'Archive'); ?></span>
        <h1 class="ax-list-title"><?php echo __t('pages', 'Pages'); ?></h1>
      <?php else: ?>
        <span class="ax-eyebrow"><?php echo __t('archive', 'Archive'); ?></span>
        <h1 class="ax-list-title"><?php echo __t('articles', 'Articles'); ?></h1>
      <?php endif; ?>
    </header>

    <?php if ($list_type === 'category' || $list_type === 'tag'): ?>
      <?php if (empty($articles) && empty($projects)): ?>
        <p class="ax-list-empty">
          <?php echo $list_type === 'category' ? __t('no_content_in_category') : __t('no_content_with_tag'); ?>
        </p>
      <?php else: ?>
        <?php if (!empty($articles)): ?>
          <h2 class="ax-subhead"><?php echo sl_type_label('article', true); ?></h2>
          <div class="articles-grid">
            <?php foreach ($articles as $a): echo render_article_card($a); endforeach; ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($projects)): ?>
          <h2 class="ax-subhead"><?php echo sl_type_label('project', true); ?></h2>
          <div class="projects-grid">
            <?php foreach ($projects as $p): echo render_project_card($p); endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>

    <?php elseif ($list_type === 'project'): ?>
      <?php if (empty($projects)): ?>
        <p class="ax-list-empty"><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
      <?php else: ?>
        <div class="projects-grid">
          <?php foreach ($projects as $p): echo render_project_card($p); endforeach; ?>
        </div>
      <?php endif; ?>

    <?php else: ?>
      <?php if (empty($articles)): ?>
        <p class="ax-list-empty"><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
      <?php else: ?>
        <div class="articles-grid">
          <?php foreach ($articles as $a): echo render_article_card($a); endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

  </div>
</section>
