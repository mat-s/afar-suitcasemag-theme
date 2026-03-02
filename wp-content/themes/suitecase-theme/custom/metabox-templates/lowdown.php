<?php
wp_enqueue_editor();
?>
<div class="repeater-item is-movable section-container" section-key="<?php echo $key; ?>">
    <button class="item-move-up item-move">&#8593;</button>
    <button class="item-move-down item-move">&#8595;</button>
    <h3><?php echo __('Lowdown', 'suitcasemag-theme'); ?></h3>
    <label>
        <h4><?php echo __('Content', 'suitcasemag-theme'); ?></h4>
        <?php $content = !empty($item['value']['content']) ? $item['value']['content'] : '';
        $editor_id = 'content_sections_' . $key . '_richtext_value_entry';
        $settings = array(
            'textarea_name' => 'content_sections[' . $key . '][lowdown][value][content]',
            'textarea_rows' => 10,
            'media_buttons' => true,
            'quicktags'           => true,
        );
        wp_editor($content, $editor_id, $settings);
        ?>
    </label>
    <div class="section-options">
        <button class="remove-section reset button"><?php echo __('Remove section', 'suitcasemag-theme'); ?></button>
        <button class="duplicate-section button"><?php echo __('Duplicate section', 'suitcasemag-theme'); ?></button>
    </div>
</div>
