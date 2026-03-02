<?php
$post_meta = get_post_meta(get_post()->ID);
$isTemplateUsagePresent = is_array($post_meta)
  && array_key_exists('template_usage', $post_meta)
  && is_array($post_meta['template_usage'])
  && count($post_meta['template_usage']) > 0;

$templateVariant = $isTemplateUsagePresent
  ? $post_meta['template_usage'][0]
  : 'old_variant';

$use_new_format = $templateVariant !== 'old_variant'; ?>

<?php if ($use_new_format) { ?>
  <?php get_header(); ?>
  <main role="main" aria-label="Content">
    <?php if (have_posts()):
      while (have_posts()): the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <?php require get_template_directory() . '/custom/custom-single.php'; 
          ?>
          <?php dynamic_sidebar(AdWidgets::getWidgetIdByName(AdWidgets::BILLBOARD)); ?>
          <?php dynamic_sidebar(AdWidgets::getWidgetIdByName(AdWidgets::MPU)); ?>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <article>
        <h1><?php esc_html_e('Sorry, nothing to display.', 'suitcasemag-theme'); ?></h1>
      </article>
    <?php endif; ?>
  </main>
<?php } else { ?>
  <?php get_header('', ['custom-class' =>'header-black']); ?>
  <div class="recover">
    <?php the_content(); ?>
  </div>
<?php } ?>

<?php
$trailblazer_query = new WP_Query([
  'category_name' => 'trailblazer',
  'posts_per_page' => 9,
  'post_status' => 'publish',
  'orderby' => 'date',
]);

if ($trailblazer_query->have_posts()) : ?>
  <section class="wrapper section-trailblazer" aria-labelledby="trailblazer-heading" role="region">
    <h2 id="trailblazer-heading" class="section-title"><?php esc_html_e("Trailblazer", 'suitcasemag-theme'); ?></h2>
    <div class="posts-grid-3 posts-grid">
      <?php while ($trailblazer_query->have_posts()) : $trailblazer_query->the_post(); ?>
        <?php
          require get_template_directory() . '/custom/blocks/post-loop.php';
        ?>
      <?php endwhile; ?>
    </div>
  </section>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>