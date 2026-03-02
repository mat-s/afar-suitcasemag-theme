<!-- TODO: Remove after relaunch -->
<div class="repeater-items">
<?php if (!empty($this->settings['homepage_categories']) && is_array($this->settings['homepage_categories'])){
    foreach ($this->settings['homepage_categories']['ids'] as $key => $id) {
        $category = get_category($id);

        if (!$category){
            continue;
        }

        $item = array(
            'id' => $category->term_id,
            'template' => $this->settings['homepage_categories']['templates'][$key],
            'title' => $category->name
        );

        $this->get_metabox_template(
            array(
                'name' => $metabox['repeater_template'] ?? '',
                'template' => $metabox['repeater_template'] ?? ''
            ),
            $item,
            $key
        );
    }
} ?>
</div>
<div class="section-options">
    <button class="button button-secondary repeater-add"><?php echo __('Add item', 'suitcasemag-theme'); ?></button>
</div>
