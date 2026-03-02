<?php

/**
 * Template name: Home
 */

get_header();

$current_page = get_current_page();

?>

<main role="main" aria-label="Content">
  <?php
  require_once __DIR__ . '/custom/widgets/AdWidgets.php';
  require_once __DIR__ . '/custom/Archives.php';
  $archives = new Archives();

  if ($current_page === 1) { ?>
    <section aria-labelledby="marquee-heading" role="region">
      <h2 id="marquee-heading" class="screen-reader-text">><?php esc_html_e("Featured Posts Slider", 'suitcasemag-theme'); ?></h2>
      <?php require get_template_directory() . '/custom/blocks/marquee-posts.php'; ?>
    </section>

    <section class="section-newsletter" aria-labelledby="newsletter-heading" role="region">
      <h2 id="newsletter-heading" class="screen-reader-text">><?php esc_html_e("Newsletter", 'suitcasemag-theme'); ?></h2>
      <p class="section-newsletter-description"><?php esc_html_e("We explore the world through a local lens, shaking up conventional travel for a globally minded generation", 'suitcasemag-theme'); ?></p>
      <button class="btn btn-primary" id="newsletter-button" aria-label="<?php esc_attr_e("Join us", 'suitcasemag-theme'); ?>"><?php esc_html_e("Join us", 'suitcasemag-theme'); ?></button>
      <div class="section-newsletter-social"><?php require __DIR__ . '/custom/blocks/socials.php'; ?></div>
    </section>

    <section class="wrapper section-featured" aria-labelledby="featured-heading" role="region">
    <h2 id="featured-heading" class="section-title"><a href="<?php echo esc_url(get_category_link(get_cat_ID('Featured'))); ?>"><?php esc_html_e("Featured", 'suitcasemag-theme'); ?></a></h2>
      <?php require get_template_directory() . '/custom/blocks/favorite-posts.php'; ?>
    </section>

    <section class="wrapper section-travel-guides" aria-labelledby="travel-guides-heading" role="region">
    <h2 id="travel-guides-heading" class="section-title"><a href="<?php echo esc_url(get_category_link(get_cat_ID('Travel Guides'))); ?>"><?php esc_html_e("Travel Guides", 'suitcasemag-theme'); ?></a></h2>
      <?php require get_template_directory() . '/custom/blocks/travel-guides.php'; ?>
    </section>

    <section class="section-sponsored" aria-labelledby="sponsored-heading" role="region">
      <h2 id="sponsored-heading" class="screen-reader-text">><?php esc_html_e("Sponsored", 'suitcasemag-theme'); ?></h2>
      <?php require get_template_directory() . '/custom/blocks/sponsored-posts.php'; ?>
    </section>

    <section class="wrapper section-health-and-wellness" aria-labelledby="health-and-wellness-heading" role="region">
    <h2 id="health-and-wellness-heading" class="section-title"><a href="<?php echo esc_url(get_category_link(get_cat_ID('Health & Wellness'))); ?>"><?php esc_html_e("Health & Wellness", 'suitcasemag-theme'); ?></a></h2>
      <?php require get_template_directory() . '/custom/blocks/health-wellness-posts.php'; ?>
    </section>

    <section class="wrapper section-most-recent" aria-labelledby="most-recent-heading" role="region">
    <h2 id="most-recent-heading" class="section-title"><a href="<?php echo esc_url(get_category_link(get_cat_ID('Most Recent'))); ?>"><?php esc_html_e("Most Recent", 'suitcasemag-theme'); ?></a></h2>
      <?php require get_template_directory() . '/custom/blocks/recent-posts.php'; ?>
    </section>
  <?php } ?>
</main>

<?php get_footer(); ?>