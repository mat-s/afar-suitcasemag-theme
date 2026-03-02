<?php
/**
 * Template name: Posts
 */

get_header();
?>

<main role="main" aria-label="Content">
    <div class="container">
        <?php require get_template_directory() . '/custom/blocks/recent-posts.php'; ?>
    </div>
</main>

<?php get_footer(); ?>
