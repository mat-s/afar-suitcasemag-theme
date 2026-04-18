<?php
$image_id = !empty($item['teaser_image']) ? $item['teaser_image'] : null;
$thumbnail_url = wp_get_attachment_image_url($image_id, 'medium');
?>
<div class="section__teaser_image section-container<?php echo $image_id ? ' isset' : ''; ?>">
    <input class="value-input" type="hidden" name="teaser_image" value="<?php echo $image_id; ?>">
    <div class="image-preview-container">
        <div class="image-preview">
            <img src="<?php echo esc_url($thumbnail_url); ?>">
        </div>
    </div>
    <div class="section-options">
        <button class="select-single-image button"><?php echo __('Select', 'suitcasemag-theme'); ?></button>
        <button class="reset remove-single-image button"><?php echo __('Remove', 'suitcasemag-theme'); ?></button>
    </div>
</div>