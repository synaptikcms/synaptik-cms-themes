<?php
/**
 * Vanta Theme — content-pages.php
 *
 * Static page view.
 * Injected variable: $item
 */
?>
        <article class="vanta-single">

            <?php if (!isset($item['show_title']) || $item['show_title']): ?>
            <h1 class="single-title"><?php echo htmlspecialchars($item['title']); ?></h1>
            <?php endif; ?>

            <?php if (!empty($item['image']) && !empty($item['show_featured_image'])): ?>
            <figure class="single-featured">
                <img src="<?php echo getBaseUrl() . htmlspecialchars($item['image']); ?>"
                     alt="<?php echo htmlspecialchars($item['title']); ?>">
            </figure>
            <?php endif; ?>

            <?php $vantaCF = render_item_custom_fields($item, 'page'); ?>
            <?php if ($vantaCF): ?>
            <div class="vanta-content-wrap">
                <div class="vanta-main-col">
            <?php endif; ?>

            <div class="prose-body">
                <?php echo render_content_html($item['content'] ?? '', $item); ?>
            </div>

            <?php if ($vantaCF): ?>
                </div>
                <aside class="vanta-cf-sidebar"><?php echo $vantaCF; ?></aside>
            </div>
            <?php endif; ?>

        </article>
