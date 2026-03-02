<!-- TODO: Remove after relaunch -->
<?php

global $archives;

if (!$archives && !($archives instanceof AdminPanel)) {
    require_once get_template_directory() . '/custom/Archives.php';
    $archives = new Archives();
}

?>

<div class="repeater-item is-movable autocomplete-container">
    <button class="item-move-up item-move">&#8593;</button>
    <button class="item-move-down item-move">&#8595;</button>
    <input type="hidden" data-key="id" name="homepage_categories[ids][]" value="<?php echo $item['id'] ?? ''; ?>">
    <label>
        <span><?php echo __('Category', 'suitcasemag-theme'); ?></span>
        <input term-type="categories" class="categories-autocomplete autocomplete value-input" type="text" name="homepage_categories[titles][]" value="<?php echo $item['title'] ?? ''; ?>">
    </label>
    <?php
    $template_options = $archives->get_post_templates();
    if ($template_options) {
        $selected_value = $item['template'] ?? ''; ?>
        <label>
            <span><?php echo __('Template', 'suitcasemag-theme'); ?></span>
            <select name="homepage_categories[templates][]">
                <?php foreach ($template_options as $option_name => $option_data) { ?>
                    <option value="<?php echo $option_name; ?>" <?php echo $option_name == $selected_value ? 'selected' : ''; ?>><?php echo $option_data['title']; ?></option>
                <?php } ?>
            </select>
        </label>
    <?php } ?>
    <button class="button button-secondary repeater-remove reset"><?php echo __('Remove item', 'suitcasemag-theme'); ?></button>
</div>