<?php
wp_enqueue_editor();
?>
<div class="repeater-item is-movable section-container" section-key="<?php echo $key; ?>">
    <button class="item-move-up item-move">&#8593;</button>
    <button class="item-move-down item-move">&#8595;</button>
    <h3><?php echo __('Richtext', 'suitcasemag-theme'); ?></h3>
    <label>
        <h4><?php echo __('Title', 'suitcasemag-theme'); ?></h4>
        <input name="content_sections[<?php echo $key; ?>][richtext][value][title]" type="text" value="<?php echo !empty($item['value']['title']) ? $item['value']['title'] : ''; ?>">
    </label>
    <label>
        <h4><?php echo __('Entry', 'suitcasemag-theme'); ?></h4>
        <textarea style="min-height: 10em;" name="content_sections[<?php echo $key; ?>][richtext][value][entry]"><?php echo !empty($item['value']['entry']) ? $item['value']['entry'] : ''; ?></textarea>
    </label>
    <label>
        <h4><?php echo __('Content', 'suitcasemag-theme'); ?></h4>
        <?php $content = !empty($item['value']['content']) ? $item['value']['content'] : '';
        $editor_id = 'content_sections_' . $key . '_richtext_value_entry';
        $settings = array(
            'textarea_name' => 'content_sections[' . $key . '][richtext][value][content]',
            'textarea_rows' => 10,
            'media_buttons' => true,
            'quicktags'           => true,
        );
        /*wp_print_editor_js();
        wp_preload_dialogs();*/
        /*global $is_IE;
        wp_editor(
            $content,
            $editor_id,
            array(
                '_content_editor_dfw' => true,
                'drag_drop_upload'    => true,
                'tabfocus_elements'   => 'content-html,save-post',
                'editor_height'       => 300,
                'tinymce'             => array(
                    'resize'                  => false,
                    'wp_autoresize_on'        => false,
                    'add_unload_trigger'      => false,
                    'wp_keep_scroll_position' => ! $is_IE,
                ),
            )
        );*/
        wp_editor($content, $editor_id, $settings);
        ?>
    </label>
    <div class="section-options">
        <button class="remove-section reset button"><?php echo __('Remove section', 'suitcasemag-theme'); ?></button>
        <button class="duplicate-section button"><?php echo __('Duplicate section', 'suitcasemag-theme'); ?></button>
    </div>
</div>