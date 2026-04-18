<?php
$post_id = get_the_ID();
$post_url = esc_url(get_permalink());
$categories = get_the_category($post_id);
$teaser_image_id = get_post_meta($post_id, 'teaser_image', true);
$thumbnail_url = $teaser_image_id
    ? wp_get_attachment_image_url($teaser_image_id, !empty($image_size) ? $image_size : 'full')
    : get_the_post_thumbnail_url($post_id, !empty($image_size) ? $image_size : 'full');
?>
<article class="post-loop" aria-labelledby="post-title-<?php echo $post_id; ?>">
  <a class="post-loop-thumbnail" href="<?php echo $post_url; ?>">
    <img src="<?php echo esc_url(!empty($thumbnail_url) ? $thumbnail_url : get_template_directory_uri() . '/assets/images/no_image.svg'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
  </a>
  <div class="post-loop-summary">
    <div class="post-loop-summary-content">
      <time datetime="<?php echo get_the_date('c'); ?>" class="post-loop-date">
        <?php echo get_the_date('F j, Y'); ?>
      </time>
      <h3 class="post-loop-title" id="post-title-<?php echo $post_id; ?>">
        <a href="<?php echo $post_url; ?>"><?php the_title(); ?></a>
      </h3>
      <?php if (!empty($section_data['with_description'])) { ?>
        <p class="post-loop-description"><?php echo get_the_excerpt(); ?></p>
      <?php } ?>
    </div>
    <?php if (!empty($categories)) { ?>
      <div class="post-loop-categories" aria-label="<?php esc_attr_e('Post categories', 'textdomain'); ?>">
        <?php foreach ($categories as $cat) { ?>
          <a class="post-loop-category btn btn-primary" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
            <?php echo esc_html($cat->name); ?>
          </a>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
</article>