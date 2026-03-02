<?php

global $archives;

$section_data = array(
    'section_summary' => true,
    'title' => 'Podcast',
    'description' => "Tune in to The Upgrade podcast to discover our favourite destinations, best-kept travel secrets and check in with the people who are shaking up the way we explore the world.",
    'classes' => array(
        'posts-grid-3', 'posts-grid'
    ),
    'see_all_link' => get_category_link(get_category_by_slug('podcasts')),
);

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 3,
        'category_slug' => 'podcasts',
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}
