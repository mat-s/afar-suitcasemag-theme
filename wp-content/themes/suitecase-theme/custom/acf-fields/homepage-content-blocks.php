<?php

if (!defined('ABSPATH')) {
  exit;
}

if (!function_exists('acf_add_local_field_group')) {
  return;
}

acf_add_local_field_group(array(
  'key'      => 'group_homepage_content_blocks',
  'title'    => __('Homepage Content Blocks', 'suitcasemag-theme'),
  'fields'   => array(
    array(
      'key'          => 'field_homepage_content_blocks',
      'label'        => __('Content Blocks', 'suitcasemag-theme'),
      'name'         => 'homepage_content_blocks',
      'type'         => 'repeater',
      'instructions' => __('Add, remove or reorder content sections on the homepage.', 'suitcasemag-theme'),
      'layout'       => 'block',
      'button_label' => __('Add Section', 'suitcasemag-theme'),
      'sub_fields'   => array(

        array(
          'key'           => 'field_hcb_content_type',
          'label'         => __('Content Type', 'suitcasemag-theme'),
          'name'          => 'content_type',
          'type'          => 'select',
          'instructions'  => __('Type of content to display in this section.', 'suitcasemag-theme'),
          'required'      => 1,
          'choices'       => array(
            'category'      => __('Category', 'suitcasemag-theme'),
            'recent'        => __('Most Recent Articles', 'suitcasemag-theme'),
            'travel_guides' => __('Travel Guides', 'suitcasemag-theme'),
            'sponsored'     => __('Sponsored Post', 'suitcasemag-theme'),
          ),
          'default_value' => 'recent',
          'wrapper'       => array('width' => '33'),
        ),

        array(
          'key'               => 'field_hcb_section_title',
          'label'             => __('Section Title', 'suitcasemag-theme'),
          'name'              => 'section_title',
          'type'              => 'text',
          'instructions'      => __('Heading shown above the section.', 'suitcasemag-theme'),
          'required'          => 0,
          'wrapper'           => array('width' => '33'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '!=',
                'value'    => 'sponsored',
              ),
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '!=',
                'value'    => 'category',
              ),
            ),
          ),
        ),

        array(
          'key'               => 'field_hcb_section_link',
          'label'             => __('Section Link (optional)', 'suitcasemag-theme'),
          'name'              => 'section_link',
          'type'              => 'url',
          'instructions'      => __('URL the section title links to (e.g. category archive).', 'suitcasemag-theme'),
          'required'          => 0,
          'wrapper'           => array('width' => '33'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '!=',
                'value'    => 'sponsored',
              ),
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '!=',
                'value'    => 'category',
              ),
            ),
          ),
        ),

        array(
          'key'               => 'field_hcb_category',
          'label'             => __('Category', 'suitcasemag-theme'),
          'name'              => 'category',
          'type'              => 'taxonomy',
          'instructions'      => __('Posts from this category will be shown.', 'suitcasemag-theme'),
          'required'          => 0,
          'taxonomy'          => 'category',
          'field_type'        => 'select',
          'allow_null'        => 1,
          'multiple'          => 0,
          'return_format'     => 'id',
          'wrapper'           => array('width' => '33'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'category',
              ),
            ),
          ),
        ),

        array(
          'key'               => 'field_hcb_posts_count',
          'label'             => __('Number of Posts', 'suitcasemag-theme'),
          'name'              => 'posts_count',
          'type'              => 'number',
          'instructions'      => __('Total posts to show (including pinned).', 'suitcasemag-theme'),
          'required'          => 1,
          'default_value'     => 9,
          'min'               => 3,
          'max'               => 30,
          'step'              => 3,
          'wrapper'           => array('width' => '33'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'category',
              ),
            ),
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'recent',
              ),
            ),
          ),
        ),

        array(
          'key'               => 'field_hcb_pinned_posts',
          'label'             => __('Pinned Articles (max. 3)', 'suitcasemag-theme'),
          'name'              => 'pinned_posts',
          'type'              => 'relationship',
          'instructions'      => __('These articles always appear first, regardless of publish date.', 'suitcasemag-theme'),
          'required'          => 0,
          'post_type'         => array('post'),
          'filters'           => array('search', 'post_type'),
          'max'               => 3,
          'return_format'     => 'id',
          'wrapper'           => array('width' => '100'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'category',
              ),
            ),
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'recent',
              ),
            ),
          ),
        ),

        // --- Travel Guides ---

        array(
          'key'               => 'field_hcb_travel_guide_categories',
          'label'             => __('Categories', 'suitcasemag-theme'),
          'name'              => 'travel_guide_categories',
          'type'              => 'taxonomy',
          'instructions'      => __('Select the destination categories to display as cards.', 'suitcasemag-theme'),
          'required'          => 0,
          'taxonomy'          => 'category',
          'field_type'        => 'multi_select',
          'max'               => 3,
          'return_format'     => 'id',
          'wrapper'           => array('width' => '100'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'travel_guides',
              ),
            ),
          ),
        ),

        // --- Sponsored Post ---

        array(
          'key'               => 'field_hcb_sponsored_label',
          'label'             => __('Show "Sponsored Content" Label', 'suitcasemag-theme'),
          'name'              => 'sponsored_label',
          'type'              => 'true_false',
          'instructions'      => __('Display a "Sponsored Content" label on the section.', 'suitcasemag-theme'),
          'required'          => 0,
          'default_value'     => 1,
          'ui'                => 1,
          'wrapper'           => array('width' => '33'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'sponsored',
              ),
            ),
          ),
        ),

        array(
          'key'               => 'field_hcb_sponsored_color',
          'label'             => __('Background Color', 'suitcasemag-theme'),
          'name'              => 'sponsored_color',
          'type'              => 'color_picker',
          'instructions'      => __('Background color for the sponsored section.', 'suitcasemag-theme'),
          'required'          => 0,
          'default_value'     => '#93614082',
          'wrapper'           => array('width' => '33'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'sponsored',
              ),
            ),
          ),
        ),

        array(
          'key'               => 'field_hcb_sponsored_post',
          'label'             => __('Sponsored Article', 'suitcasemag-theme'),
          'name'              => 'sponsored_post',
          'type'              => 'post_object',
          'instructions'      => __('Select the sponsored article to feature.', 'suitcasemag-theme'),
          'required'          => 0,
          'post_type'         => array('post'),
          'filters'           => array('search'),
          'multiple'          => 0,
          'return_format'     => 'id',
          'wrapper'           => array('width' => '100'),
          'conditional_logic' => array(
            array(
              array(
                'field'    => 'field_hcb_content_type',
                'operator' => '==',
                'value'    => 'sponsored',
              ),
            ),
          ),
        ),

      ),
    ),
  ),
  'location' => array(
    array(
      array(
        'param'    => 'page_type',
        'operator' => '==',
        'value'    => 'front_page',
      ),
    ),
  ),
  'menu_order'            => 10,
  'position'              => 'normal',
  'style'                 => 'default',
  'label_placement'       => 'top',
  'instruction_placement' => 'label',
  'active'                => true,
));
