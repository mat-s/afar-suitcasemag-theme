<?php

global $archives;

$section_data = array(
    'section_summary' => true,
    'title' => 'Wild Cards',
    'description' => "Not sure where you want to go but like to be ahead of the curve? These under-the-radar spots are the places that everybody will be talking about soon. You heard it here first.",
    'classes' => array(
        'posts-grid-4-4', 'posts-grid'
    ),
    'see_all_link' => get_category_link(get_category_by_slug('wild-cards')),
);

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 8,
        'category_slug' => 'wild-cards',
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}
