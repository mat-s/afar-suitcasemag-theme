<?php

global $archives;

$section_data = array(
    'classes' => array(
        'posts-grid-3-3', 'posts-grid'
    ),
);

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 6,
        'category_slug' => 'hotlists',
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}
wp_reset_postdata();
