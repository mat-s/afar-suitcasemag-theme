<?php

global $archives;

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$homepage_categories = get_option('homepage_categories');

$post_templates = $archives->get_post_templates();
// Order $homepage_categories in order to priority
if ($homepage_categories) {

    foreach ($homepage_categories['ids'] as $key => $id) {
        $category_template = $homepage_categories['templates'][$key] ?? '';
        $section_data = $post_templates[$category_template] ?? array();

        $category = get_category($id);

        if (!$category) {
            continue;
        }

        $posts_db = $archives->get_posts_db(
            array(
                'category_slug' => $category->slug,
                'per_page' => $section_data['query_limit'] ?? 6
            )
        );

        if (!$posts_db->have_posts()) {
            continue;
        }

        $archives->get_category_section($posts_db, $section_data, $category);
    }
}
