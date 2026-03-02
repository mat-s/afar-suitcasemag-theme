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
        $image_url = wp_get_attachment_image_url($image_id, 'large'); ?>
        <div class="discover-more__image">
            <p><img decoding="async" class="" height="560" src="<?php echo esc_url($image_url ?: get_template_directory_uri() . '/assets/images/no_image.svg'); ?>" width="560"></p>
        </div>
        <div class="discover-more__content">
            <div class="discover-more__heading">Discover More</div>
            <div class="discover-more__title"><?php echo $post_data->post_title; ?></div>
            <div class="discover-more__cta">
                <a class="button" href="<?php echo get_permalink($post_id); ?>"><span>Read now</span></a>
            </div>
            <p></p>
        </div>
    <?php } ?>
</div>
