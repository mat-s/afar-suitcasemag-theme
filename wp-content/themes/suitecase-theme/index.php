<?php get_header();?>

  <main role="main" aria-label="Content">
    <section class="container">
      <h1><?php _e('Latest posts', 'suitcasemag-theme'); ?></h1>
      <?php get_template_part('loop'); ?>
      <?php get_template_part('pagination'); ?>
    </section>
  </main>


<?php get_footer(); ?>
