<?php get_header('', ['custom-class' => 'header-black']); ?>

<main role="main" aria-label="Content">
  <div class="inner">
    <h1><?php esc_html_e('Archives', 'suitcasemag-theme'); ?></h1>
    <?php get_template_part('loop'); ?>
    <?php get_template_part('pagination'); ?>
  </div>
</main>


<?php get_footer(); ?>