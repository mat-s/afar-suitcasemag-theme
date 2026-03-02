<?php
global $section_value;

if (empty($section_value['value'])){
    return false;
    //$thumbnail_url = get_template_directory_uri() . '/assets/images/no_image.svg';
}

$thumbnail_url = wp_get_attachment_image_url($section_value['value'], 'large');
?>

<div class="single-image">
    <img src="<?php echo esc_url($thumbnail_url); ?>">
</div>