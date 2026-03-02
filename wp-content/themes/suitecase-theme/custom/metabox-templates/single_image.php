<?php

$image_id = !empty($item['value']) ? $item['value'] : null;
$thumbnail_url = wp_get_attachment_image_url($image_id, 'thumbnail');

?>
<div class="repeater-item is-movable section-container<?php echo !empty($image_id) ? ' isset' : ''; ?>" section-key="<?php echo $key; ?>">
    <button class="item-move-up item-move">&#8593;</button>
    <button class="item-move-down item-move">&#8595;</button>
    <h3><?php echo __('Single image', 'suitcasemag-theme'); ?></h3>
    <input class="value-input" type="hidden" name="content_sections[<?php echo $key; ?>][single_image][value]" value="<?php echo esc_attr($image_id); ?>">
    <div class="image-preview-container">
        <div class="image-preview">
            <img src="<?php echo esc_url($thumbnail_url); ?>">
        </div>
    </div>
    <div class="section-options">
        <button class="select-single-image button"><?php echo __('Select', 'suitcasemag-theme'); ?></button>
        <button class="remove-section reset button"><?php echo __('Remove section', 'suitcasemag-theme'); ?></button>
        <button class="duplicate-section button"><?php echo __('Duplicate section', 'suitcasemag-theme'); ?></button>
    </div>
</div>