<?php

global $archives;

$section_data = array(
    'section_summary' => true,
    'title' => 'People',
    'description' => "From local heroes to trailblazing explorers and fashion powerhouses, these are individuals who are pushing boundaries around the globe. Get to know them better.",
    'classes' => array(
        'posts-grid-2-2', 'posts-grid'
    ),
    'see_all_link' => get_category_link(get_category_by_slug('people')),
);

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 4,
        'category_slug' => 'people',
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}
