<?php
$image_ids = array();

if (!empty($item['value'])){
    $image_ids = explode(',', preg_replace('/\s+/', '', $item['value']));
}
?>
<div class="repeater-item is-movable section-container<?php echo !empty($image_ids) ? ' isset' : ''; ?>" section-key="<?php echo $key; ?>">
    <button class="item-move-up item-move">&#8593;</button>
    <button class="item-move-down item-move">&#8595;</button>
    <h3><?php echo __('Multiple image', 'suitcasemag-theme'); ?></h3>
    <input class="value-input" type="hidden" name="content_sections[<?php echo $key; ?>][multiple_image][value]" value="<?php echo esc_attr(implode(',', $image_ids)); ?>">
    <div class="image-preview-container">
        <?php if ($image_ids) {
            foreach ($image_ids as $image_id) {
                $thumbnail_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                ?>
                <div class="image-preview">
                    <img src="<?php echo esc_url($thumbnail_url); ?>">
                    <button image-id="<?php echo $image_id; ?>" class="remove-multiple-image reset button">&times;</button>
                </div>
            <?php }
        } ?>
    </div>
    <div class="section-options">
        <label style="display: block; margin: 10px 0;">
            <input name="content_sections[<?php echo $key; ?>][multiple_image][apply_swiper]" type="checkbox" <?php echo isset($item['apply_swiper']) && $item['apply_swiper'] == 'on' ? 'checked' : ''; ?>><?php echo __('Apply swiper', 'suitcasemag-theme'); ?>
        </label>
        <button class="select-multiple-image button"><?php echo __('Select', 'suitcasemag-theme'); ?></button>
        <button class="remove-section reset button"><?php echo __('Remove section', 'suitcasemag-theme'); ?></button>
        <button class="duplicate-section button"><?php echo __('Duplicate section', 'suitcasemag-theme'); ?></button>
    </div>
</div>