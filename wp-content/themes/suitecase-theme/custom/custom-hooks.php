<?php

add_action('breadcrumps', function () {
    global $post;
    require get_template_directory() . '/custom/blocks/breadcrumps.php';
});

function hide_post_content_editor() {
    global $post;

    if ('post' === $post->post_type) {
        remove_post_type_support('post', 'editor');
    }
}

add_action('admin_head-post-new.php', 'hide_post_content_editor');