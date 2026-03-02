<?php get_header(); ?>

  <main role="main" aria-label="Content">
    <section class="container">
      <h1><?php esc_html_e('Tag Archive: ', 'suitcasemag-theme'); echo single_tag_title('', false); ?></h1>
      <?php get_template_part('loop'); ?>
      <?php get_template_part('pagination'); ?>
    </section>
  </main>


<?php get_footer(); ?>
