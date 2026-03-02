<?php

global $archives;

if (!$archives && !($archives instanceof Archives)) {
	require_once __DIR__ . '/custom/Archives.php';
	$archives = new Archives();
}

$favorite_posts = get_field('home_featured_section');
$post_ids = array();

if ($favorite_posts) {
	foreach ($favorite_posts['home_featured_articles'] as $article) {
    $post_ids[] = $article['home_featured_article'];
  }
}

$section_data = array(
	'classes' => array(
		'posts-grid-3',
		'favorite-posts',
		'posts-grid'
	)
);

$posts_db = $archives->get_posts_db(
	array(
		'per_page' => 3,
		'orderby' => 'post__in',
		'post_ids' => $post_ids
	)
);

if ($posts_db->have_posts()) {
	$archives->get_category_section($posts_db, $section_data);
}
wp_reset_postdata();
