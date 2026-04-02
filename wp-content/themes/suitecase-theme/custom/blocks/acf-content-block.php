<?php

/**
 * ACF-driven homepage content block.
 * Must be called from within a have_rows() / the_row() loop.
 */

global $archives;

if (!$archives instanceof Archives) {
    require_once get_template_directory() . '/custom/Archives.php';
    $archives = new Archives();
}

$layout        = get_row_layout();
$section_title = '';
$section_link  = '';

// Derive title and link per layout
if ($layout === 'category') {
    $category_id = get_sub_field('category');
    if ($category_id) {
        $category      = get_category((int) $category_id);
        $section_title = $category->name;
        $section_link  = get_category_link($category->term_id);
    }
} elseif ($layout === 'recent' || $layout === 'travel_guides') {
    $section_title = get_sub_field('section_title') ?? '';
    $section_link  = get_sub_field('section_link') ?? '';
}

$section_id = 'acf-section-' . sanitize_title($section_title . '-' . uniqid());
?>

<section class="wrapper section-acf-block" aria-labelledby="<?php echo esc_attr($section_id); ?>">

    <?php if ($section_title) : ?>
        <h2 id="<?php echo esc_attr($section_id); ?>" class="section-title">
            <?php if ($section_link) : ?>
                <a href="<?php echo esc_url($section_link); ?>"><?php echo esc_html($section_title); ?></a>
            <?php else : ?>
                <?php echo esc_html($section_title); ?>
            <?php endif; ?>
        </h2>
    <?php endif; ?>

    <?php
    // -------------------------------------------------------------------------
    // Category
    // -------------------------------------------------------------------------
    if ($layout === 'category') :
        $posts_count = (int) (get_sub_field('posts_count') ?: 9);
        $pinned_ids  = get_sub_field('pinned_posts') ?: [];
        $pinned_ids  = array_map('intval', (array) $pinned_ids);
        $category_slug = isset($category) ? $category->slug : '';

    // -------------------------------------------------------------------------
    // Most Recent
    // -------------------------------------------------------------------------
    elseif ($layout === 'recent') :
        $posts_count   = (int) (get_sub_field('posts_count') ?: 9);
        $pinned_ids    = get_sub_field('pinned_posts') ?: [];
        $pinned_ids    = array_map('intval', (array) $pinned_ids);
        $category_slug = '';
    endif;

    if ($layout === 'category' || $layout === 'recent') :
        if (!empty($pinned_ids)) {
            $remaining_count = max(0, $posts_count - count($pinned_ids));
            $remaining_ids   = [];

            if ($remaining_count > 0) {
                $remaining_query = new WP_Query([
                    'post_type'      => 'post',
                    'post_status'    => 'publish',
                    'posts_per_page' => $remaining_count,
                    'category_name'  => $category_slug,
                    'post__not_in'   => $pinned_ids,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ]);

                $remaining_ids = wp_list_pluck($remaining_query->posts, 'ID');
                wp_reset_postdata();
            }

            $all_ids  = array_merge($pinned_ids, $remaining_ids);
            $posts_db = new WP_Query([
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => count($all_ids),
                'post__in'       => $all_ids,
                'orderby'        => 'post__in',
            ]);
        } else {
            $posts_db = $archives->get_posts_db([
                'category_slug' => $category_slug,
                'per_page'      => $posts_count,
            ]);
        }

        if ($posts_db->have_posts()) : ?>
            <div class="posts-grid-3 posts-grid">
                <?php while ($posts_db->have_posts()) : $posts_db->the_post(); ?>
                    <?php require get_template_directory() . '/custom/blocks/post-loop.php'; ?>
                <?php endwhile; ?>
            </div>
        <?php
            wp_reset_postdata();
        endif;

    // -------------------------------------------------------------------------
    // Travel Guides
    // -------------------------------------------------------------------------
    elseif ($layout === 'travel_guides') :
        $category_ids = (array) (get_sub_field('travel_guide_categories') ?: []);
        ?>
        <div class="travel-guides">
            <?php foreach ($category_ids as $category_id) :
                $cat            = get_category((int) $category_id);
                $category_image = get_field('category_image', 'category_' . $cat->term_id);
                $category_link  = get_category_link($cat->term_id);
                $category_label = sprintf(__('View all posts in %s', 'suitcasemag-theme'), $cat->name);
            ?>
                <div class="travel-guide">
                    <a href="<?php echo esc_url($category_link); ?>" class="travel-guide-link" aria-label="<?php echo esc_attr($category_label); ?>">
                        <figure class="travel-guide-figure">
                            <?php if ($category_image) : ?>
                                <?php echo wp_get_attachment_image($category_image, 'medium', false, [
                                    'class' => 'travel-guide-img',
                                    'alt'   => esc_attr($cat->name),
                                ]); ?>
                            <?php endif; ?>
                            <figcaption class="travel-guide-caption">
                                <h3 class="travel-guide-title"><?php echo esc_html($cat->name); ?></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    <?php
    // -------------------------------------------------------------------------
    // Sponsored Post
    // -------------------------------------------------------------------------
    elseif ($layout === 'sponsored') :
        $post_id    = (int) get_sub_field('sponsored_post');
        $color      = get_sub_field('sponsored_color') ?: '#93614082';
        $show_label = (bool) get_sub_field('sponsored_label');

        if ($post_id) :
            $post       = get_post($post_id);
            $categories = get_the_category($post_id);
            $post_url   = get_permalink($post_id);
        ?>
            <article class="sponsored-post" style="background-color: <?php echo esc_attr($color); ?>">
                <div class="sponsored-post-image">
                    <?php if (has_post_thumbnail($post_id)) : ?>
                        <a href="<?php echo esc_url($post_url); ?>">
                            <?php echo get_the_post_thumbnail($post_id, 'full', ['alt' => esc_attr($post->post_title)]); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="sponsored-post-content">
                    <div class="sponsored-post-meta">
                        <time class="sponsored-post-date">
                            <?php echo esc_html(get_the_date('F j, Y', $post_id)); ?>
                        </time>
                        <?php if ($show_label) : ?>
                            <div class="sponsored-post-label">
                                <?php esc_html_e('Sponsored Content', 'suitcasemag-theme'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h3 class="sponsored-post-title">
                        <a href="<?php echo esc_url($post_url); ?>"><?php echo esc_html($post->post_title); ?></a>
                    </h3>
                    <?php if ($post->post_excerpt) : ?>
                        <div class="sponsored-post-excerpt">
                            <?php echo esc_html($post->post_excerpt); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($categories)) : ?>
                        <div class="sponsored-post-categories" aria-label="Post categories">
                            <?php foreach ($categories as $cat) : ?>
                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="sponsored-post-category-title btn btn-primary">
                                    <?php echo esc_html($cat->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        <?php
        endif;
    endif;
    ?>

</section>
