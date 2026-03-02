<div class="repeater-item is-movable section-container section-type__repeater" section-key="<?php echo $key; ?>" template="discover_more_item">
    <button class="item-move-up item-move">&#8593;</button>
    <button class="item-move-down item-move">&#8595;</button>
    <h3><?php echo __('&quot;Discover more&quot;', 'suitcasemag-theme'); ?></h3>
    <div class="repeater-items">
        <?php
            $sub_metabox = array(
                'name' => 'discover_more_item',
                'template' => 'discover_more_item'
            );
            if (!empty($item['value']['ids'])) {
                foreach ($item['value']['ids'] as $item_key => $item_id) {
                    $sub_item = array(
                        'id' => $item_id,
                        'title' => $item['value']['titles'][$item_key] ?? '',
                        'header' => $item['value']['headers'][$item_key] ?? ''
                    );
                    $this->get_metabox_template($sub_metabox, $sub_item, $key);
                }
            } else {
                $this->get_metabox_template($sub_metabox, array(), $key);
            }
        ?>
    </div>
    <div class="section-options">
        <button class="button button-secondary repeater-add"><?php echo __('Add item', 'suitcasemag-theme'); ?></button>
        <button class="remove-section reset button"><?php echo __('Remove section', 'suitcasemag-theme'); ?></button>
        <button class="duplicate-section button"><?php echo __('Duplicate section', 'suitcasemag-theme'); ?></button>
    </div>
</div>