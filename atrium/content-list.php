<?php
/**
 * Atrium Theme for Synaptik CMS — content-list.php
 *
 * List view: articles, projects, category, tag. Editorial grids with a
 * dedicated header that announces the section like a gallery room.
 *
 * @var string $list_type    Content type: article | project | page | category | tag
 * @var array  $articles     Article items
 * @var array  $projects     Project items
 * @var string $filter_value Active category or tag slug
 * @var array  $data         Full data store
 * @var array  $settings     Site settings
 */

$df_kicker = '';
$df_title  = '';
if ($list_type === 'article')        { $df_kicker = __t('atrium_room_articles', 'Reading room'); $df_title = sl_type_label('article', true); }
elseif ($list_type === 'project')    { $df_kicker = __t('atrium_room_projects', 'Project gallery'); $df_title = sl_type_label('project', true); }
elseif ($list_type === 'page')       { $df_kicker = __t('atrium_room_pages',    'Index'); $df_title = sl_type_label('page', true); }
elseif ($list_type === 'category')   { $df_kicker = __t('breadcrumb_category'); $df_title = htmlspecialchars($filter_value ?? ''); }
elseif ($list_type === 'tag')        { $df_kicker = __t('breadcrumb_tag');      $df_title = htmlspecialchars($filter_value ?? ''); }
?>

<section class="atrium-list">
  <header class="atrium-list-head atrium-reveal">
    <p class="atrium-eyebrow"><span class="atrium-eyebrow-line" aria-hidden="true"></span><?php echo htmlspecialchars($df_kicker); ?></p>
    <h1 class="atrium-list-title"><?php echo $df_title; ?></h1>
  </header>

  <?php if ($list_type === 'category' || $list_type === 'tag'): ?>
    <?php if (empty($articles) && empty($projects)): ?>
    <p class="atrium-empty"><?php echo ($list_type === 'category') ? __t('no_content_in_category') : __t('no_content_with_tag'); ?></p>
    <?php else: ?>
      <?php if (!empty($articles)): ?>
      <h2 class="atrium-list-sub"><?php echo sl_type_label('article', true); ?></h2>
      <div class="atrium-cards atrium-stagger">
        <?php foreach ($articles as $df_a): echo render_article_card($df_a); endforeach; ?>
      </div>
      <?php endif; ?>
      <?php if (!empty($projects)): ?>
      <h2 class="atrium-list-sub atrium-list-sub--spaced"><?php echo sl_type_label('project', true); ?></h2>
      <div class="atrium-salon-grid atrium-stagger">
        <?php foreach ($projects as $df_p): echo render_project_card($df_p); endforeach; ?>
      </div>
      <?php endif; ?>
    <?php endif; ?>

  <?php elseif ($list_type === 'project'): ?>
    <?php if (empty($projects)): ?>
    <p class="atrium-empty"><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
    <?php else: ?>
    <div class="atrium-salon-grid atrium-stagger">
      <?php foreach ($projects as $df_p): echo render_project_card($df_p); endforeach; ?>
    </div>
    <?php endif; ?>

  <?php else: ?>
    <?php if (empty($articles)): ?>
    <p class="atrium-empty"><?php echo sprintf(__t('no_type_found'), $list_type); ?></p>
    <?php else: ?>
    <div class="atrium-cards atrium-stagger">
      <?php foreach ($articles as $df_a): echo render_article_card($df_a); endforeach; ?>
    </div>
    <?php endif; ?>
  <?php endif; ?>
</section>
