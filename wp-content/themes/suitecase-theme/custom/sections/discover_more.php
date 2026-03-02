<?php
global $section_value;

if (empty($section_value['value']['ids'])){
    return false;
}
?>

<div class="discover-more" style="max-width: 100%;">
    <?php foreach ($section_value['value']['ids'] as $key => $post_id) {
        $post_data = get_post($post_id);
        if (!$post_data) {
            continue;
        }

        $image_id = get_post_thumbnail_id($post_id);
        $image_url = wp_get_attachment_image_url($image_id, 'large');

        $post_title = $post_data->post_title;
        $post_title_cropped = strlen($post_title >= 28) ? substr($post_title, 0, 25) . '...' : $post_title;

        $image_title = $section_value['value']['headers'][$key] ?? $post_title_cropped; ?>
        <div class="discover-more__image">
            <p><img decoding="async" class="" height="560" src="<?php echo esc_url($image_url ?: get_template_directory_uri() . '/assets/images/no_image.svg'); ?>" width="560"></p>
        </div>
        <div class="discover-more__content">
            <div class="discover-more__heading">Discover More</div>
            <div class="discover-more__title"><?php echo $image_title; ?></div>
            <div class="discover-more__cta">
                <a class="button" href="<?php echo get_permalink($post_id); ?>"><span>Read now</span></a>
            </div>
            <p></p>
        </div>
    <?php } ?>
</div>
