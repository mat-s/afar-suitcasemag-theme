<?php
$section_key = $_POST['section_key'] ?? $key;
?>
<div class="repeater-item is-movable permanent-key autocomplete-container" section-key="<?php echo $section_key; ?>">
    <button class="item-move-up item-move">&#8593;</button>
    <button class="item-move-down item-move">&#8595;</button>
    <input type="hidden" data-key="id" name="content_sections[<?php echo $section_key; ?>][discover_more][value][ids][]" value="<?php echo $item['id']; ?>">
    <h4><?php echo __('Post', 'suitcasemag-theme'); ?></h4>
    <input term-type="posts" class="posts-autocomplete autocomplete" type="text" name="content_sections[<?php echo $section_key; ?>][discover_more][value][titles][]" value="<?php echo $item['title']; ?>">
    <h4><?php echo __("Title ('To Eat', 'To drink', etc.)", 'suitcasemag-theme'); ?></h4>
    <input type="text" name="content_sections[<?php echo $section_key; ?>][discover_more][value][headers][]" value="<?php echo $item['header']; ?>">
    <button class="button button-secondary repeater-remove reset"><?php echo __('Remove item', 'suitcasemag-theme'); ?></button>
</div>