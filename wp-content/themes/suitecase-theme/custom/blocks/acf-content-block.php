<?php

/**
 * ACF-driven homepage content block.
 * Expects $args['block'] with fields from the homepage_content_blocks repeater.
 */

$block = $args['block'] ?? [];

global $archives;

if (!$archives instanceof Archives) {
  require_once get_template_directory() . '/custom/Archives.php';
  $archives = new Archives();
}

$content_type  = $block['content_type'] ?? '';
$section_title = $block['section_title'] ?? '';
$section_link  = $block['section_link'] ?? '';
$posts_count   = !empty($block['posts_count']) ? (int) $block['posts_count'] : 9;
$pinned_ids    = !empty($block['pinned_posts']) ? array_map('intval', (array) $block['pinned_posts']) : [];

if ($content_type === 'category' && !empty($block['category'])) {
    $category      = get_category((int) $block['category']);
    $section_title = $category->name;
    $section_link  = get_category_link($category->term_id);
}

$section_id = 'acf-section-' . sanitize_title($section_title);
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
  // Category / Recent
  // -------------------------------------------------------------------------
  if ($content_type === 'category' || $content_type === 'recent') :
    $category_slug = '';

    if ($content_type === 'category' && !empty($category)) {
      $category_slug = $category->slug;
    }

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
  elseif ($content_type === 'travel_guides') :
    $category_ids = !empty($block['travel_guide_categories'])
      ? (array) $block['travel_guide_categories']
      : [];
    ?>
    <div class="travel-guides">
      <?php foreach ($category_ids as $category_id) :
        $category       = get_category((int) $category_id);
        $category_image = get_field('category_image', 'category_' . $category->term_id);
        $category_link  = get_category_link($category->term_id);
        $category_label = sprintf(__('View all posts in %s', 'suitcasemag-theme'), $category->name);
      ?>
        <div class="travel-guide">
          <a href="<?php echo esc_url($category_link); ?>" class="travel-guide-link" aria-label="<?php echo esc_attr($category_label); ?>">
            <figure class="travel-guide-figure">
              <?php if ($category_image) : ?>
                <?php echo wp_get_attachment_image($category_image, 'medium', false, [
                  'class' => 'travel-guide-img',
                  'alt'   => esc_attr($category->name),
                ]); ?>
              <?php endif; ?>
              <figcaption class="travel-guide-caption">
                <h3 class="travel-guide-title"><?php echo esc_html($category->name); ?></h3>
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
  elseif ($content_type === 'sponsored') :
    $post_id = !empty($block['sponsored_post']) ? (int) $block['sponsored_post'] : null;
    $color         = !empty($block['sponsored_color']) ? $block['sponsored_color'] : '#93614082';
    $show_label    = !empty($block['sponsored_label']);

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