<?php get_header('', ['custom-class' =>'header-black']); ?>

<main role="main" aria-label="Content">
  <div class="inner">
    <?php require __DIR__ . '/custom/Archives.php';
    (new Archives())->display_content(); ?>
  </div>
</main>


<?php get_footer(); ?>