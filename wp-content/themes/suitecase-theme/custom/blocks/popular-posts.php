<?php

global $archives;

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$popular_posts = get_option('homepage_popular_posts');
$post_ids = array();

if ($popular_posts) {
    foreach ($popular_posts['ids'] as $key => $id){
        $post_ids[] = $id;
    }
}

$section_data = array(
    'section_summary' => true,
    'title' => 'Most popular',
    'description' => "The people, places and things that you can't get enough of this week. Stay ahead of the travel curve here.",
    'classes' => array(
        'post-rows'
    )
);

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 4,
        'orderby' => 'post__in',
        'post_ids' => $post_ids
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}
