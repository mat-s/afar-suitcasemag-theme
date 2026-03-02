<?php
/**
* Template name: Default
*/

get_header('', ['custom-class' =>'header-black']); ?>
  <main role="main" aria-label="Content">
    <div class="container">

      <h1 class="page-title"><?php echo get_the_title(); ?></h1>
      <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <?php the_content(); ?>
          <?php comments_template('', true); ?>
        </article>
      <?php endwhile; ?>
      <?php else: ?>
        <article>
          <h2><?php _e('Sorry, nothing to display.', 'suitcasemag-theme'); ?></h2>
        </article>
      <?php endif; ?>
    </div>
  </main>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
