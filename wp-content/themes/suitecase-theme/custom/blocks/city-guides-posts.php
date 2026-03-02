<?php

global $archives;

$section_data = array(
    'section_summary' => true,
    'title' => 'City Guides',
    'description' => "You know how you have that one friend who knows their hometown inside out? That's us. This is the kind of guide that you don't need to run by a local - it was written by one.",
    'classes' => array(
        'posts-grid-3', 'posts-grid'
    ),
    'see_all_link' => get_category_link(get_category_by_slug('city-guides')),
);

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 3,
        'category_slug' => 'city-guides',
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}
