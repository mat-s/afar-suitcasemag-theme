<?php

// global $archives;

// if (!$archives && !($archives instanceof Archives)) {
// 	require_once __DIR__ . '/custom/Archives.php';
// 	$archives = new Archives();
// }

// $sponsored_posts = get_option('homepage_sponsored_posts');
// $post_ids = array();


// if ($sponsored_posts) {
// 	foreach ($sponsored_posts['ids'] as $key => $id) {
// 		$post_ids[] = $id;
// 	}
// }

// $section_data = array(
// 	'classes' => array(
// 		'posts-grid-1',
// 		'sponsored-posts',
// 		'posts-grid'
// 	)
// );

// $posts_db = $archives->get_posts_db(
// 	array(
// 		'per_page' => 1,
// 		'orderby' => 'post__in',
// 		'post_ids' => $post_ids
// 	)
// );



// if ($posts_db->have_posts()) {
// 	while ($posts_db->have_posts()) {
// 		$posts_db->the_post();
// 		$categories = get_the_category();
?>

		<!-- <article class="sponsored-post wrapper" style="background-color: #93614082">
			<div class="sponsored-post-image">
				<?php if (has_post_thumbnail()) { ?>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
					</a>
				<?php } ?>
			</div>
			<div class="sponsored-post-content">
				<div class="sponsored-post-meta">
					<div class="sponsored-post-date">
						<?php echo esc_html(get_the_date()); ?>
					</div>
					<div class="sponsored-post-label">
						<?php esc_html_e("Sponsored Content", 'suitcasemag-theme'); ?>
					</div>
				</div>
				<h3 class="sponsored-post-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<div class="sponsored-post-excerpt">
					<?php the_excerpt(); ?>
				</div>
				<div class="sponsored-post-categories" aria-label="Post categories">
					<?php foreach ($categories as $category) { ?>
						<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="sponsored-post-category-title btn btn-primary">
							<?php echo esc_html($category->name); ?>
						</a>
					<?php } ?>
				</div>
			</div>
		</article> -->
<?php
// 	}
// }
// wp_reset_postdata();
?>



<?php
if (function_exists('get_field')) {
	$sponsored_post_section = get_field('home_sponsored_post_section');
	if ($sponsored_post_section) {
		$post = $sponsored_post_section['home_sponsored_post'];
		setup_postdata($post);
		
		$color = $sponsored_post_section['home_sponsored_post_color'] != '' ? $sponsored_post_section['home_sponsored_post_color'] : '#93614082';
		$timestamp = strtotime($post->post_date);
		$formatted_date = date('F j, Y', $timestamp);
		$categories = get_the_category($post->ID);
?>

		<article class="sponsored-post" style="background-color:<?php echo $color; ?>">
			<div class="sponsored-post-image">
				<?php if (has_post_thumbnail()) { ?>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
					</a>
				<?php } ?>
			</div>
			<div class="sponsored-post-content">
				<div class="sponsored-post-meta">
					<time class="sponsored-post-date">
						<?php echo esc_html($formatted_date); ?>
				</time>
					<?php if ($sponsored_post_section['home_sponsored_post_label']) : ?>
						<div class="sponsored-post-label">
							<?php esc_html_e("Sponsored Content", 'suitcasemag-theme'); ?>
						</div>
					<?php endif; ?>
				</div>
				<h3 class="sponsored-post-title">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<div class="sponsored-post-excerpt">
					<?php echo $post->post_excerpt; ?>
				</div>
				<div class="sponsored-post-categories" aria-label="Post categories">
					<?php foreach ($categories as $category) { ?>
						<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="sponsored-post-category-title btn btn-primary">
							<?php echo esc_html($category->name); ?>
						</a>
					<?php } ?>
				</div>
			</div>
		</article>
<?php
		wp_reset_postdata();
	}
}
