<?php

global $archives;

if (!$archives && !($archives instanceof Archives)) {
    require_once __DIR__ . '/custom/Archives.php';
    $archives = new Archives();
}

$posts_db = $archives->get_posts_db(
    array(
        'per_page' => 1,
        'category_slug' => 'destination-by-month',
    )
);

if ($posts_db->have_posts()) {
    $posts_db->the_post();
?>
    <div class="category-section">
        <div class="category-summary">
            <h3 class="category-section-title">Destination By Month</h3>
            <p class="category-section-description">To help you navigate the pitfalls of going to the wrong place at the wrong time, we've put together the ultimate guide on when to enjoy destinations at their best - even if that means visiting in so-called "off-season".</p>
            <a href="<?php echo get_category_link(get_category_by_slug('destination-by-month')); ?>" class="category-see-all"><?php echo __('See all months', 'suitcasemat-theme'); ?></a>
        </div>
        <ul class="post-covers">
            <li class="post-cover">
                <div style="background-image: url(<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>);" class="post-cover-inner">
                    <span style="position: absolute; top: 20px; left: 50%; transform: translateX(-50%); color: #ffffff; text-transform: uppercase;">DISCOVER MORE</span>
                    <h3 class="post-cover-title">Destination by Month</h3>
                    <a class="read-more" href="<?php echo get_the_permalink(get_the_ID()); ?>">Read now</a>
                </div>
            </li>
        </ul>
    </div>
<?php } ?>