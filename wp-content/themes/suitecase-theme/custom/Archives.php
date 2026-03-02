<?php

if (!defined('ABSPATH')) {
  exit;
}

class Archives
{
  public $current_category;
  public $current_page;

  public $settings = array();

  public function __construct()
  {
    $this->current_category = get_queried_object();

    // Forces function if there is no isseted page by query
    $current_page = (!empty($queried_page) && $queried_page != '') ? $queried_page : get_current_page();

    $this->current_page = max(1, $current_page);

    $this->settings = array(
      'per_page' => 18,
      'per_page_with_ad' => 17,
      'category_sections' => array(
        'recent' => array(
          'template' => 'post-loop',
          'query_limit' => 18,
          'image_sizes' => array(
            0 => 'full',
            1 => 'full'
          )
        )
      ),
      'category_templates' => array(
        array(
          'template' => 'post-loop',
          'query_limit' => 4,
          'classes' => array(
            'posts-grid-2-2',
            'posts-grid'
          )
        ),
        array(
          'template' => 'post-loop',
          'query_limit' => 6,
          'classes' => array(
            'posts-grid-3-3',
            'posts-grid'
          )
        ),
        array(
          'template' => 'post-loop',
          'query_limit' => 7,
          'classes' => array(
            'posts-grid-3-4',
            'posts-grid'
          )
        ),
        array(
          'template' => 'post-loop',
          'query_limit' => 8,
          'classes' => array(
            'posts-grid-4-4',
            'posts-grid'
          )
        ),
        array(
          'template' => 'post-loop',
          'query_limit' => 3,
          'with_description' => 1,
          'classes' => array(
            'posts-grid-3',
            'posts-grid'
          )
        ),
        array(
          'template' => 'post-loop',
          'query_limit' => 4,
          'classes' => array(
            'posts-grid-4',
            'posts-grid'
          )
        ),
        array(
          'template' => 'post-cover',
          'query_limit' => 1,
          'classes' => array(
            'post-covers'
          )
        ),
        array(
          'template' => 'post-loop',
          'query_limit' => 5,
          'classes' => array(
            'post-rows'
          )
        ),
        array(
          'template' => 'post-loop',
          'query_limit' => 12,
          'classes' => array(
            'posts-grid-12',
            'posts-grid'
          )
        )
      )
    );
  }

  public function display_content()
  {
    $offset = null;
    if ($this->current_page === 1) { ?>

      <div class="category-entry inner">
        <h1 class="category-title"><?php echo single_cat_title(); ?></h1>
      </div>
    <?php } ?>
    
    <?php
    // $child_categories = get_categories(array(
    //   'parent' => $this->current_category->term_id,
    //   'hide_empty' => false
    // ));


    // if ($child_categories) {
    //   $this->current_category->slug !== 'pack'
    //     ? $this->display_child_categories($child_categories)
    //     : $offset = 12;
    // }
    if ($this->current_page === 1) {
      $this->display_category_template();
    } else {
      $this->display_category_posts($offset,  $this->current_category->slug !== 'explore');
    }

    ?>
      <div class="category-entry">
        <?php echo category_description(); ?>
      </div>
    <?php
  }

  public function get_posts_db($params = array())
  {
    $meta_query = '';

    if (isset($params['section_name']) && in_array($params['section_name'], array('discover_more', 'favorite'))) {
      $meta_query = array(
        array(
          'key' => 'is_' . $params['section_name'],
          'value' => true,
          'compare' => '=',
          'type' => 'BOOLEAN'
        )
      );
    }

    $args = array(
      'category_name' => !empty($params['category_slug']) ? $params['category_slug'] : '',
      'posts_per_page' => !empty($params['per_page']) ? $params['per_page'] : $this->settings['per_page'],
      'post__in' => !empty($params['post_ids']) ? $params['post_ids'] : '',
      'orderby' => !empty($params['orderby']) ? $params['orderby'] : 'date',
      'order' => !empty($params['order']) ? $params['order'] : 'DESC',
      'paged' => isset($params['paged']) ? $this->current_page : 1,
      'post_status' => 'publish'
    );

    if (!empty($params['offset']) && $this->current_page === 1) {
      $args['offset'] = $params['offset'];
    }

    if (!empty($meta_query)) {
      $args['meta_query'] = $meta_query;
    }

    return new WP_Query($args);
  }

  /**
   * Latest category posts
   */
  private function display_category_posts(?int $offset = null, ?bool $is_show_advertising = false)
  {
    $params = array(
      'category_slug' => $this->current_category->slug,
      'paged' => 1, // Bool
      'offset' => is_null($offset) ? 8 : $offset
    );

    if ($is_show_advertising) {
      $params['per_page'] = $this->settings['per_page_with_ad'];
    }

    $posts_db = $this->get_posts_db($params);

    $this->get_category_section(
      $posts_db,
      $this->get_post_templates()['posts-grid-15'],
      null,
      $is_show_advertising
    );
  }

  private function display_category_template()
  {
    if (empty($this->settings['category_sections'])) {
      echo '<h3>' . __('There is no content to display.', 'suitcasemag-theme') . '</h3>';
      return;
    }

    foreach ($this->settings['category_sections'] as $section_name => $section_data) {
      if ($section_name === 'discover_more' && $this->current_category->slug !== 'explore') {
    ?>
      <?php
      }

      $posts_db = $this->get_posts_db(
        array(
          'category_slug' => $this->current_category->slug,
          'per_page' => $section_data['query_limit'],
          'section_name' => $section_name
        )
      );

      if (!$posts_db->have_posts()) {
        continue;
      }

      $section_data['section_summary'] = true;

      $this->get_category_section($posts_db, $section_data);
    }
  }

  private function display_child_categories($categories)
  {
    if (empty($this->settings['category_templates'])) {
      echo '<h3>' . __('There is no content to display.', 'suitcasemag-theme') . '</h3>';
      return;
    }

    foreach ($categories as $key => $category) {
      if ($category->slug === 'hotel-reviews') {
      ?>
    <?php
      }

      if ($this->settings['category_templates'][$key]) {
        $category_template = $this->settings['category_templates'][$key];
      } elseif ($key > 0) {
        $category_template = $this->settings['category_templates'][$key % count($this->settings['category_templates'])];
      } else {
        continue;
      }

      $posts_db = $this->get_posts_db(
        array(
          'category_slug' => $category->slug,
          'per_page' => $category_template['query_limit']
        )
      );

      if (!$posts_db->have_posts()) {
        continue;
      }

      $category_template['section_summary'] = true;

      $this->get_category_section($posts_db, $category_template, $category);
    }
  }

  public function get_category_section(
    $posts_db = null,
    $section_data = null,
    $category = null,
    ?bool $is_show_advertising = false
  ) { ?>
    <div class="category-section">
      <?php if (isset($section_data['section_summary']) || !empty($category)) { ?>
        <div class="category-summary">
          <?php if (isset($section_data['section_summary'])) { ?>
            <?php if (!empty($section_data['title'])) { ?>
              <h3 class="category-section-title"><?php echo $section_data['title']; ?></h3>
            <?php } ?>
            <?php if (!empty($section_data['description'])) { ?>
              <p class="category-section-description"><?php echo $section_data['description']; ?></p>
            <?php } ?>
            <?php if (!empty($section_data['see_all_link'])) { ?>
              <a href="<?php echo $section_data['see_all_link']; ?>" class="category-see-all"><?php echo __('See all', 'suitcasemat-theme'); ?></a>
            <?php } ?>
          <?php } ?>
          <?php if (!empty($category)) { ?>
            <?php if ($category->parent != 0) {
              $parent_category = get_category($category->parent); ?>
              <h4 class="parent-category-title"><?php echo $parent_category->name ?></h4>
            <?php } ?>
            <?php if (!empty($category->name)) { ?>
              <h3 class="category-section-title"><?php echo $category->name; ?></h3>
            <?php } ?>
            <?php if (!empty($category->description)) { ?>
              <p class="category-section-description"><?php echo $category->description; ?></p>
            <?php } ?>
            <a href="<?php echo get_category_link($category->term_id); ?>" class="category-see-all"><?php echo __('See all', 'suitcasemat-theme'); ?></a>
          <?php } ?>
        </div>
      <?php } ?>
      <!-- <div class="<?php echo !empty($section_data['classes']) ? implode(' ', $section_data['classes']) : 'posts-grid'; ?> <?php echo isset($section_data['with_description']) ? 'with-description' : ''; ?>"> -->
      <div class="posts-grid-3 posts-grid <?php echo isset($section_data['with_description']) ? 'with-description' : ''; ?>">
        <?php $qty = 0;
        while ($posts_db->have_posts()) {
          $qty++;
          $posts_db->the_post();
          $key = $posts_db->current_post;
          $image_size = !empty($section_data['image_sizes'][$key]) ? $section_data['image_sizes'][$key] : 'full';
          require get_template_directory() . '/custom/blocks/post-loop.php';
        }

        $isLastItemReplacedToAdvertising = $is_show_advertising
          && $qty === $this->settings['per_page_with_ad'];

        if ($isLastItemReplacedToAdvertising) { ?>
          <article class="post-loop">

          </article>
        <?php } ?>
      </div>
    </div>
    <?php if (
      $posts_db->found_posts > $posts_db->query['posts_per_page']
      && ($posts_db->query['posts_per_page'] >= $this->settings['per_page']
        || ($isLastItemReplacedToAdvertising
          && $posts_db->query['posts_per_page'] >= $this->settings['per_page_with_ad']
        )
      )
    ) { ?>
      <div class="pagination">
        <?php
        $prev_arrow = file_get_contents(get_template_directory() . '/assets/images/icons/arrow-left.svg');
        $next_arrow = file_get_contents(get_template_directory() . '/assets/images/icons/arrow-right.svg');
        echo paginate_links(array(
          'total' => $posts_db->max_num_pages,
          'prev_text' => $prev_arrow,
          'next_text'  => $next_arrow,
          'current' => $this->current_page
        )); ?>
      </div>
<?php }
  }

  public function get_post_templates()
  {
    return array(
      'posts-grid-2-2' => array(
        'template' => 'post-loop',
        'query_limit' => 4,
        'title' => __('2-2 posts grid', 'suitcasemag-theme'),
        'classes' => array(
          'posts-grid-2-2',
          'posts-grid'
        ),
        'image_sizes' => array(
          0 => 'full',
          1 => 'full',
          2 => 'full',
          3 => 'full'
        )
      ),
      'posts-grid-2-4' => array(
        'template' => 'post-loop',
        'query_limit' => 6,
        'title' => __('2-4 posts grid', 'suitcasemag-theme'),
        'classes' => array(
          'posts-grid-2-4',
          'posts-grid'
        ),
        'image_sizes' => array(
          0 => 'full',
          1 => 'full'
        )
      ),
      'posts-grid-3' => array(
        'template' => 'post-loop',
        'query_limit' => 3,
        'title' => __('3 posts grid', 'suitcasemag-theme'),
        'classes' => array(
          'posts-grid-3',
          'posts-grid'
        )
      ),
      'posts-grid-3-3' => array(
        'template' => 'post-loop',
        'query_limit' => 6,
        'title' => __('3-3 posts grid', 'suitcasemag-theme'),
        'classes' => array(
          'posts-grid-3-3',
          'posts-grid'
        )
      ),
      'posts-grid-3-3' => array(
        'template' => 'post-loop',
        'query_limit' => 9,
        'title' => __('3-3-3 posts grid', 'suitcasemag-theme'),
        'classes' => array(
          'posts-grid-3-3-3',
          'posts-grid'
        )
      ),
      'posts-grid-3-4' => array(
        'template' => 'post-loop',
        'query_limit' => 7,
        'title' => __('3-4 posts grid', 'suitcasemag-theme'),
        'classes' => array(
          'posts-grid-3-4',
          'posts-grid'
        )
      ),
      'posts-grid-4-4' => array(
        'template' => 'post-loop',
        'query_limit' => 8,
        'title' => __('4-4 posts grid', 'suitcasemag-theme'),
        'classes' => array(
          'posts-grid-4-4',
          'posts-grid'
        )
      ),
      'posts-grid-15' => array(
        'with_description' => 1,
        'template' => 'post-loop',
        'query_limit' => 15,
        'title' => __('15 posts grid', 'suitcasemag-theme'),
        'classes' => array(
          'posts-grid-15',
          'posts-grid'
        )
      ),
      'post-covers' => array(
        'template' => 'post-cover',
        'query_limit' => 1,
        'title' => __('Post covers', 'suitcasemag-theme'),
        'classes' => array(
          'post-covers'
        )
      ),
      'post-rows' => array(
        'template' => 'post-loop',
        'query_limit' => 5,
        'title' => __('Post rows', 'suitcasemag-theme'),
        'classes' => array(
          'post-rows'
        )
      ),
    );
  }
}
