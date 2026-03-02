<?php get_header('', ['custom-class' => 'header-black']); ?>

<main role="main" aria-label="Content">
  <div class="inner">
    <div class="search-page-header inner">
      <h1><?php echo sprintf(__('Search Results for: ', 'suitcasemag-theme'), $wp_query->found_posts);
          echo get_search_query(); ?></h1>
      <?php get_search_form(array('echo' => get_search_query(),)); ?>
    </div>
    <?php if (have_posts()) { ?>
      <ul class="posts-grid-3 posts-grid">
        <?php while (have_posts()) {
          the_post();
          $category = get_the_category();
          if ($category) {
            $category = $category[0];
          }
          require get_template_directory() . '/custom/blocks/post-loop.php'; ?>
        <?php } ?>
      </ul>
      <?php if ($wp_query->found_posts > 15) { ?>
        <div class="pagination">
          <?php
          $prev_arrow = file_get_contents(get_template_directory() . '/assets/images/icons/arrow-left.svg');
          $next_arrow = file_get_contents(get_template_directory() . '/assets/images/icons/arrow-right.svg');
          echo paginate_links(array(
            'total' => $wp_query->max_num_pages,
            'prev_text' => $prev_arrow,
            'next_text'  => $next_arrow
          )); ?>
        </div>
      <?php } ?>
    <?php } else { ?>
      <h2><?php _e('Sorry, nothing to display.', 'suitcasemag-theme'); ?></h2>
    <?php } ?>
  </div>
</main>

<?php get_footer(); ?>