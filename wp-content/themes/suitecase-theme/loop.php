<?php if (have_posts()) { ?>
  <ul class="posts-grid">
    <?php while (have_posts()) {
      the_post();
      $category = get_the_category()[0];
      require get_template_directory() . '/custom/blocks/post-loop.php'; ?>
    <?php } ?>
  </ul>
  <?php if ($wp_query->found_posts > 15) { ?>
    <div class="pagination">
      <?php echo paginate_links(array(
          'total' => $wp_query->max_num_pages
      )); ?>
    </div>
  <?php } ?>
<?php } else { ?>
    <h2><?php _e('Sorry, nothing to display.', 'suitcasemag-theme'); ?></h2>
<?php }
