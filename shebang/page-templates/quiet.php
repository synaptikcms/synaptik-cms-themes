<?php /* Template Name: Quiet */ ?>
<article class="content-single shebang-quiet">
    <h1 class="content-title"><?php echo hsc($item['title']); ?></h1>

    <?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
    <figure class="content-featured-image">
        <img src="<?php echo getBaseUrl() . hsc($item['image']); ?>" alt="<?php echo hsc($item['title']); ?>" loading="lazy">
    </figure>
    <?php endif; ?>

    <?php echo render_item_custom_fields($item, 'page'); ?>

    <div class="prose-body">
        <?php echo render_content_html($item['content'] ?? '', $item); ?>
    </div>

    <?php echo render_content_gallery($item); ?>
</article>
