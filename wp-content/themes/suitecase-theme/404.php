<?php get_header(); ?>

<main role="main" aria-label="Content">
  <div class="container">
    <article style="text-align: center;" id="post-404">
      <h1><?php esc_html_e('Page not found', 'suitcasemag-theme'); ?></h1>
      <img style="display: block; margin: 40px 0; width: 100%; height: 160px; object-fit: contain;" src="<?php echo get_template_directory_uri() . '/assets/images/404.svg'; ?>" alt="404">
      <a style="display: block;" href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('Return home?', 'suitcasemag-theme'); ?></a>
    </article>
  </div>
</main>


<?php get_footer(); ?>
