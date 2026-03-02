<?php
$image_id = !empty($item['byline']['partnership_logo']) ? $item['byline']['partnership_logo'] : null;
$thumbnail_url = wp_get_attachment_image_url($image_id, 'thumbnail');
?>
<label for="byline_words_by">
    <h4><?php echo __('Words By', 'suitcasemag-theme'); ?></h4>
    <input type="text" id="byline_words_by" name="byline[words_by]" value="<?php echo $item['byline']['words_by'] ?? ''; ?>">
</label>
<label for="byline_photographs_by">
    <h4><?php echo __('Photographs By', 'suitcasemag-theme'); ?></h4>
    <input type="text" id="byline_photographs_by" name="byline[photographs_by]" value="<?php echo $item['byline']['photographs_by'] ?? ''; ?>">
</label>
<label for="byline_illustrations_by">
    <h4><?php echo __('Illustrations By', 'suitcasemag-theme'); ?></h4>
    <input type="text" id="byline_illustrations_by" name="byline[illustrations_by]" value="<?php echo $item['byline']['illustrations_by'] ?? ''; ?>">
</label>
<label for="byline_sell_line">
    <h4><?php echo __('Sell line', 'suitcasemag-theme'); ?></h4>
    <input type="text" id="byline_sell_line" name="byline[sell_line]" value="<?php echo $item['byline']['sell_line'] ?? ''; ?>">
</label>
<label for="byline_partnership">
    <h4><?php echo __('Partnership logo', 'suitcasemag-theme'); ?></h4>
    <div class="section-container <?php echo $image_id ? ' isset' : ''; ?>">
        <button class="select-single-image button"><?php echo __('Select image', 'suitcasemag-theme'); ?></button>
        <button class="remove-single-image reset button"><?php echo __('Remove image', 'suitcasemag-theme'); ?></button>
        <div class="image-preview-container">
            <div class="image-preview">
                <img src="<?php echo esc_url($thumbnail_url); ?>">
            </div>
        </div>
        <input class="value-input" type="hidden" name="byline[partnership_logo]" value="<?php echo esc_attr($image_id); ?>">
    </div>
</label>
<label for="byline_partnership_text">
    <h4><?php echo __('Partnership Text (alternative to image)', 'suitcasemag-theme'); ?></h4>
    <input type="text" id="byline_partnership_text" name="byline[partnership_text]" value="<?php echo $item['byline']['partnership_text'] ?? ''; ?>">
</label>
