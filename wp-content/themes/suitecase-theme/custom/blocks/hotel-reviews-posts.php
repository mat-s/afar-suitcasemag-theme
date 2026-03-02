<?php

global $archives;

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$exlore_posts = get_option('homepage_explore_posts');
$post_ids = array();

if ($exlore_posts) {
    foreach ($exlore_posts['ids'] as $key => $id){
        $post_ids[] = $id;
    }
}

$section_data = array(
    'section_summary' => true,
    'title' => 'Explore',
    'description' => "Planning your next trip? We've picked the brains of those who know to bring you the insider recommendations you won't find elsewhere. This is your little black travel book.",
    'classes' => array(
        'posts-grid-3-3', 'posts-grid'
    ),
    'see_all_link' => get_category_link(get_category_by_slug('explore')),
);

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 6,
        'orderby' => 'post__in',
        'post_ids' => $post_ids
    )
);

if ($posts_db->have_posts()) {
    $archives->get_category_section($posts_db, $section_data);
}
