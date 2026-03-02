<?php

global $archives;

if (!$archives && !($archives instanceof Archives)) {
  require_once __DIR__ . '/custom/Archives.php';
  $archives = new Archives();
}

$marquee_posts = get_field('home_marquee_section'); 
$post_ids = array();

if ($marquee_posts) {
  foreach ($marquee_posts['home_marquee_articles'] as $article) {
    $post_ids[] = $article['home_marquee_article'];
  }
}

$section_data = array(
  'image_sizes' => array(
    0 => 'large',
    1 => 'large'
  ),
  'classes' => array(
    'posts-grid-2-4',
    'marquee-posts',
    'posts-grid'
  )
);

$posts_db = $archives->get_posts_db(
  array(
    'per_page' => 6,
    'orderby' => 'post__in',
    'post_ids' => $post_ids
  )
);

if ($posts_db->have_posts()) {
?>
  <div class="swiper marquee-swiper" role="region" aria-label="Featured posts slider">
    <div class="swiper-wrapper">
      <?php while ($posts_db->have_posts()) {
        $posts_db->the_post();
        $categories = get_the_category();
      ?>
        <article class="marquee-swiper-slide swiper-slide">
          <?php if (has_post_thumbnail()) { ?>
            <div class="marquee-swiper-image">
              <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
            </div>
          <?php } ?>
          <div class="marquee-swiper-content">
            <div class="marquee-swiper-categories" aria-label="Post categories">
              <?php foreach ($categories as $category) { ?>
                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="marquee-swiper-category-title">
                  <?php echo esc_html($category->name); ?>
                </a>
              <?php } ?>
            </div>
            <h3 class="marquee-swiper-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          </div>
        </article>
      <?php } ?>
    </div>
    <div class="marquee-swiper-pagination"></div>
  </div>

  <script>
    jQuery(document).ready(function($) {
      new Swiper(".swiper", {
        slidesPerView: 1,
        loop: true,
        effect: 'fade',
        speed: 1500,
        fadeEffect: {
          crossFade: true,
        },
        autoplay: {
          delay: 8000,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.marquee-swiper-pagination',
          clickable: true,
        },
      });
    });
  </script>
<?php
}
wp_reset_postdata();