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
            'type'         => 'flexible_content',
            'instructions' => __('Add, remove or reorder content sections on the homepage.', 'suitcasemag-theme'),
            'button_label' => __('Add Section', 'suitcasemag-theme'),
            'layouts'      => array(

                // -----------------------------------------------------------------
                // Layout: Category
                // -----------------------------------------------------------------
                array(
                    'key'        => 'layout_hcb_category',
                    'name'       => 'category',
                    'label'      => __('Category', 'suitcasemag-theme'),
                    'display'    => 'block',
                    'sub_fields' => array(
                        array(
                            'key'           => 'field_hcb_cat_category',
                            'label'         => __('Category', 'suitcasemag-theme'),
                            'name'          => 'category',
                            'type'          => 'taxonomy',
                            'instructions'  => __('Posts from this category will be shown.', 'suitcasemag-theme'),
                            'required'      => 1,
                            'taxonomy'      => 'category',
                            'field_type'    => 'select',
                            'allow_null'    => 0,
                            'multiple'      => 0,
                            'return_format' => 'id',
                            'wrapper'       => array('width' => '50'),
                        ),
                        array(
                            'key'           => 'field_hcb_cat_posts_count',
                            'label'         => __('Number of Posts', 'suitcasemag-theme'),
                            'name'          => 'posts_count',
                            'type'          => 'number',
                            'instructions'  => __('Total posts to show (including pinned).', 'suitcasemag-theme'),
                            'required'      => 1,
                            'default_value' => 9,
                            'min'           => 3,
                            'max'           => 30,
                            'step'          => 3,
                            'wrapper'       => array('width' => '50'),
                        ),
                        array(
                            'key'           => 'field_hcb_cat_pinned_posts',
                            'label'         => __('Pinned Articles (max. 3)', 'suitcasemag-theme'),
                            'name'          => 'pinned_posts',
                            'type'          => 'relationship',
                            'instructions'  => __('These articles always appear first, regardless of publish date.', 'suitcasemag-theme'),
                            'required'      => 0,
                            'post_type'     => array('post'),
                            'filters'       => array('search'),
                            'max'           => 3,
                            'return_format' => 'id',
                            'wrapper'       => array('width' => '100'),
                        ),
                    ),
                ),

                // -----------------------------------------------------------------
                // Layout: Most Recent
                // -----------------------------------------------------------------
                array(
                    'key'        => 'layout_hcb_recent',
                    'name'       => 'recent',
                    'label'      => __('Most Recent Articles', 'suitcasemag-theme'),
                    'display'    => 'block',
                    'sub_fields' => array(
                        array(
                            'key'          => 'field_hcb_rec_section_title',
                            'label'        => __('Section Title', 'suitcasemag-theme'),
                            'name'         => 'section_title',
                            'type'         => 'text',
                            'instructions' => __('Heading shown above the section.', 'suitcasemag-theme'),
                            'required'     => 1,
                            'wrapper'      => array('width' => '50'),
                        ),
                        array(
                            'key'          => 'field_hcb_rec_section_link',
                            'label'        => __('Section Link (optional)', 'suitcasemag-theme'),
                            'name'         => 'section_link',
                            'type'         => 'url',
                            'instructions' => __('URL the section title links to.', 'suitcasemag-theme'),
                            'required'     => 0,
                            'wrapper'      => array('width' => '50'),
                        ),
                        array(
                            'key'           => 'field_hcb_rec_posts_count',
                            'label'         => __('Number of Posts', 'suitcasemag-theme'),
                            'name'          => 'posts_count',
                            'type'          => 'number',
                            'instructions'  => __('Total posts to show (including pinned).', 'suitcasemag-theme'),
                            'required'      => 1,
                            'default_value' => 9,
                            'min'           => 3,
                            'max'           => 30,
                            'step'          => 3,
                            'wrapper'       => array('width' => '50'),
                        ),
                        array(
                            'key'           => 'field_hcb_rec_pinned_posts',
                            'label'         => __('Pinned Articles (max. 3)', 'suitcasemag-theme'),
                            'name'          => 'pinned_posts',
                            'type'          => 'relationship',
                            'instructions'  => __('These articles always appear first, regardless of publish date.', 'suitcasemag-theme'),
                            'required'      => 0,
                            'post_type'     => array('post'),
                            'filters'       => array('search'),
                            'max'           => 3,
                            'return_format' => 'id',
                            'wrapper'       => array('width' => '100'),
                        ),
                    ),
                ),

                // -----------------------------------------------------------------
                // Layout: Travel Guides
                // -----------------------------------------------------------------
                array(
                    'key'        => 'layout_hcb_travel_guides',
                    'name'       => 'travel_guides',
                    'label'      => __('Travel Guides', 'suitcasemag-theme'),
                    'display'    => 'block',
                    'sub_fields' => array(
                        array(
                            'key'          => 'field_hcb_tg_section_title',
                            'label'        => __('Section Title', 'suitcasemag-theme'),
                            'name'         => 'section_title',
                            'type'         => 'text',
                            'instructions' => __('Heading shown above the section.', 'suitcasemag-theme'),
                            'required'     => 1,
                            'wrapper'      => array('width' => '50'),
                        ),
                        array(
                            'key'          => 'field_hcb_tg_section_link',
                            'label'        => __('Section Link (optional)', 'suitcasemag-theme'),
                            'name'         => 'section_link',
                            'type'         => 'url',
                            'instructions' => __('URL the section title links to.', 'suitcasemag-theme'),
                            'required'     => 0,
                            'wrapper'      => array('width' => '50'),
                        ),
                        array(
                            'key'           => 'field_hcb_tg_categories',
                            'label'         => __('Categories', 'suitcasemag-theme'),
                            'name'          => 'travel_guide_categories',
                            'type'          => 'taxonomy',
                            'instructions'  => __('Select the destination categories to display as cards.', 'suitcasemag-theme'),
                            'required'      => 0,
                            'taxonomy'      => 'category',
                            'field_type'    => 'multi_select',
                            'max'           => 3,
                            'return_format' => 'id',
                            'wrapper'       => array('width' => '100'),
                        ),
                    ),
                ),

                // -----------------------------------------------------------------
                // Layout: Sponsored Post
                // -----------------------------------------------------------------
                array(
                    'key'        => 'layout_hcb_sponsored',
                    'name'       => 'sponsored',
                    'label'      => __('Sponsored Post', 'suitcasemag-theme'),
                    'display'    => 'block',
                    'sub_fields' => array(
                        array(
                            'key'           => 'field_hcb_sp_label',
                            'label'         => __('Show "Sponsored Content" Label', 'suitcasemag-theme'),
                            'name'          => 'sponsored_label',
                            'type'          => 'true_false',
                            'instructions'  => __('Display a "Sponsored Content" label on the section.', 'suitcasemag-theme'),
                            'required'      => 0,
                            'default_value' => 1,
                            'ui'            => 1,
                            'wrapper'       => array('width' => '50'),
                        ),
                        array(
                            'key'           => 'field_hcb_sp_color',
                            'label'         => __('Background Color', 'suitcasemag-theme'),
                            'name'          => 'sponsored_color',
                            'type'          => 'color_picker',
                            'instructions'  => __('Background color for the sponsored section.', 'suitcasemag-theme'),
                            'required'      => 0,
                            'default_value' => '#93614082',
                            'wrapper'       => array('width' => '50'),
                        ),
                        array(
                            'key'           => 'field_hcb_sp_post',
                            'label'         => __('Sponsored Article', 'suitcasemag-theme'),
                            'name'          => 'sponsored_post',
                            'type'          => 'post_object',
                            'instructions'  => __('Select the sponsored article to feature.', 'suitcasemag-theme'),
                            'required'      => 0,
                            'post_type'     => array('post'),
                            'filters'       => array('search'),
                            'multiple'      => 0,
                            'return_format' => 'id',
                            'wrapper'       => array('width' => '100'),
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
