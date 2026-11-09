<?php
/**
 * Nova Theme for Synaptik CMS — content-list.php
 *
 * Renders lists of articles, projects, pages, categories, and tags.
 *
 * Available variables
 * -------------------
 * @var string $list_type    Content type: 'article' | 'project' | 'page' | 'category' | 'tag'
 * @var array  $articles     Article items to display
 * @var array  $projects     Project items to display
 * @var array  $items        All found items with '_content_type' key
 * @var string $filter_value Category or tag slug currently applied
 * @var array  $data         Full data store
 * @var array  $settings     Site settings
 */
?>

<?php if ($list_type === 'category'): ?>

    <section class="category-content">
      <div class="content-container">
        <?php if (empty($articles) && empty($projects)): ?>
            <p><?php echo __t('no_content_in_category'); ?></p>
        <?php else: ?>
            <?php if (!empty($articles)): ?>
                <h2><?php echo sl_type_label('article', true); ?></h2>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <?php echo render_article_card($article); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($projects)): ?>
                <h2><?php echo sl_type_label('project', true); ?></h2>
                <div class="projects-grid">
                    <?php foreach ($projects as $project): ?>
                        <?php echo render_project_card($project); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
      </div>
    </section>

<?php elseif ($list_type === 'tag'): ?>

    <section class="tag-content">
      <div class="content-container">
        <?php if (empty($articles) && empty($projects)): ?>
            <p><?php echo __t('no_content_with_tag'); ?></p>
        <?php else: ?>
            <?php if (!empty($articles)): ?>
                <h2><?php echo sl_type_label('article', true); ?></h2>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <?php echo render_article_card($article); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($projects)): ?>
                <h2><?php echo sl_type_label('project', true); ?></h2>
                <div class="projects-grid">
                    <?php foreach ($projects as $project): ?>
                        <?php echo render_project_card($project); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
      </div>
    </section>

<?php elseif ($list_type === 'project'): ?>

    <section class="content-list">
      <div class="content-container">
        <?php if (empty($projects)): ?>
            <p><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
        <?php else: ?>
            <section class="projects-grid">
                <?php foreach ($projects as $project): ?>
                    <?php echo render_project_card($project); ?>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
      </div>
    </section>

<?php else: /* article, page */ ?>

    <section class="content-list">
      <div class="content-container">
        <?php if (empty($articles)): ?>
            <p><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
        <?php else: ?>
            <section class="articles-grid">
                <?php foreach ($articles as $article): ?>
                    <?php echo render_article_card($article); ?>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
      </div>
    </section>

<?php endif; ?>
