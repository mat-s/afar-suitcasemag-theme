<?php

/**
 * Custom single page content based on ACF fields
 */

global $post;

$post_meta = get_post_meta($post->ID);
$categories = get_the_category();

foreach ($post_meta as $key => $data) {
  $decoded_data = json_decode($data[0], true);
  if (is_array($decoded_data) && json_last_error() === JSON_ERROR_NONE) {
    $post_meta[$key] = $decoded_data;
  } else {
    $post_meta[$key] = $data[0];
  }
}

?>
<?php
/**
 * Hero image
 */
?>
<section class="post-summary">
  <?php if (has_post_thumbnail()): ?>
    <div class="post-marquee" role="region" aria-label="Main post thumbnail">
      <?php if (has_post_thumbnail()) { ?>
        <div class="post-marquee-image">
          <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
        </div>
      <?php } ?>
      <div class="post-marquee-content">
        <div class="post-marquee-categories" aria-label="Post categories">
          <?php foreach ($categories as $category) { ?>
            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="post-marquee-category-title">
              <?php echo esc_html($category->name); ?>
            </a>
          <?php } ?>
        </div>
        <h1 class="post-marquee-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
      </div>
    </div>
  <?php endif; ?>

  <div class="byline-wrapper">
    <div class="byline-meta">
      <date class="post-date"><?php echo get_the_date(); ?></date>
      <?php if (!empty($post_meta['byline']['words_by'])) { ?>
        <div class="byline__words_by"><?php echo __('Words by', 'suitcasemag-theme'); ?> <?php echo $post_meta['byline']['words_by']; ?></div>
      <?php } ?>
      <?php if (!empty($post_meta['byline']['photographs_by'])) { ?>
        <div class="byline__photographs_by"><?php echo __('Photographs by', 'suitcasemag-theme'); ?> <?php echo $post_meta['byline']['photographs_by']; ?></div>
      <?php } ?>
      <?php if (!empty($post_meta['byline']['illustrations_by'])) { ?>
        <div class="byline__illustrations_by"><?php echo __('Illustrations by', 'suitcasemag-theme'); ?><?php echo $post_meta['byline']['illustrations_by']; ?></div>
      <?php } ?>
    </div>
    <?php if (!empty($post_meta['byline']['sell_line'])) { ?>
      <p class="article__standfirst"><?php echo $post_meta['byline']['sell_line']; ?></p>
    <?php } ?>

    <?php
    if (!empty($post_meta['byline']['partnership_logo']) || !empty($post_meta['byline']['partnership_text'])) {
      $thumbnail_url = wp_get_attachment_image_url($post_meta['byline']['partnership_logo'], 'large');
    ?>
      <p class="article__sponsor">
        <span class="article__sponsor-label">In partnership with</span>
        <span class="article__sponsor-image">
          <?php if (!empty($post_meta['byline']['partnership_text'])) { ?>
            <?php echo $post_meta['byline']['partnership_text']; ?>
          <?php } else { ?>
            <img decoding="async" alt="Partnership Logo" class="" height="60" src="<?php echo $thumbnail_url; ?>">
          <?php } ?>

        </span>
      </p>
    <?php
    }
    ?>
  </div>

  <?php if (has_excerpt()) : ?>
    <div class="post-excerpt">
      <?php echo get_the_excerpt(); ?>
    </div>
  <?php endif; ?>
</section>


<!--Content-->
<div class="content">
  <?php
  $lowDown = null;
  $discoverMore = null;
  ?>
  <div class="article-content-wrapper">
    <div class="article-content">
      <?php $hasLowdown = false;
      $hasDiscoverMore = false; ?>
      <div class="article-content-sections">
        <?php if (!empty($post_meta['content_sections'])) {
          foreach ($post_meta['content_sections'] as $section) {
            $section_name = key($section);
            $section_value = reset($section);
            if ($section_name === 'lowdown') {
              $hasLowdown = true;
              $lowDown = reset($section);
            }
            if ($section_name === 'discover_more') {
              $hasDiscoverMore = true;
              $discoverMore = reset($section);
            }
            $content_class = $section_name !== 'discover_more' ? 'article-content-' . $section_name : 'article-content-discover';
            $content_class = $section_name === 'single_image' ? 'article-content-discover' : $content_class;
            $content_class = $section_name === 'lowdown' ? 'article-content-discover' : $content_class;
        ?>
            <?php if ($section_name !== 'discover_more' && $section_name !== 'lowdown') { ?>
              <div class="<?php echo $content_class; ?>">
                <?php if (!file_exists(get_template_directory() . "/custom/sections/{$section_name}.php")) {
                  continue;
                }

                ob_start();
                require get_template_directory() . "/custom/sections/{$section_name}.php";
                echo ob_get_clean(); ?>

              </div>
            <?php } ?>
        <?php }
        } ?>
      </div>
    </div>
    <?php if ($hasLowdown) {
      $section_value = $lowDown; ?>
      <div class="article-content-discover">
        <?php if (file_exists(get_template_directory() . "/custom/sections/lowdown.php")) {
          ob_start();
          require get_template_directory() . "/custom/sections/lowdown.php";
          echo ob_get_clean();
        } ?>

      </div>
    <?php } ?>
    <?php if ($hasDiscoverMore) {
      $section_value = $discoverMore; ?>
      <div class="article-content-discover">
        <?php if (file_exists(get_template_directory() . "/custom/sections/discover_more.php")) {
          ob_start();
          require get_template_directory() . "/custom/sections/discover_more.php";
          echo ob_get_clean();
        } ?>

      </div>
    <?php } ?>
  </div>
</div>