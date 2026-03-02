<?php

global $archives;

$section_data = array(
    'section_summary' => true,
    'title' => 'Photo Journals',
    'description' => "Escape to a wild landscape or peer around corners in a city's backstreets. These visual diaries from international photographers show destinations in a different light. This is your window to the world.",
    'classes' => array(
        'posts-grid-4-4', 'posts-grid'
    ),
    'see_all_link' => get_category_link(get_category_by_slug('photo-journals')),
);

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 8,
        'category_slug' => 'photo-journals',
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}
