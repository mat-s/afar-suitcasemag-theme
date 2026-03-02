<?php
if (function_exists('get_field')) {
  $travel_guides_section = get_field('home_travel_guides_section');
  if ($travel_guides_section) {
    $categories = $travel_guides_section['home_travel_guides_destinations'];
?>
  <div class="travel-guides">
    <?php foreach ($categories as $category_id) { ?>
      <?php 
        $category_id = $category_id['home_travel_guides_destination'];
        $category = get_category($category_id);
        $category_image = get_field('category_image', 'category_' . $category->term_id);
        $category_name = $category->name;
        $category_link = get_category_link($category->term_id);
        $category_label = sprintf(__('View all posts in %s', 'suitcasemag-theme'), $category_name);
      ?>
      <div class="travel-guide">
        <a href="<?php echo esc_url($category_link); ?>" class="travel-guide-link" aria-label="<?php echo esc_attr($category_label); ?>">
          <figure class="travel-guide-figure">
            <?php if ($category_image) {
              echo wp_get_attachment_image($category_image, 'medium', false, [
                'class' => 'travel-guide-img',
                'alt' => $category_name
              ]);
            } ?>
            <figcaption class="travel-guide-caption">
              <h3 class="travel-guide-title"><?php echo esc_html($category_name); ?></h3>
            </figcaption>
          </figure>
        </a>
      </div>
    <?php } ?>
  </div>
<?php
  }
}
?>
