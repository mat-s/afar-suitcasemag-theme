<?php

global $archives;

if (!$archives && !($archives instanceof Archives)) {
    require_once get_template_directory() . '/custom/Archives.php';
    $archives = new Archives();
}

$section_data = $archives->get_post_templates()['posts-grid-15'];

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 15,
        'paged' => 1, // Bool
        'offset' => 0
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}