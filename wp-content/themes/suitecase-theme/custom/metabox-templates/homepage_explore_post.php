<!-- TODO: Remove after relaunch -->
<div class="repeater-item autocomplete-container is-movable section-container">
    <button class="item-move-up item-move">&#8593;</button>
    <button class="item-move-down item-move">&#8595;</button>
    <input type="hidden" data-key="id" name="homepage_explore_posts[ids][]" value="<?php echo $item['id'] ?? ''; ?>">
    <label>
        <input term-type="posts" class="posts-autocomplete autocomplete value-input" type="text" name="homepage_explore_posts[titles][]" value="<?php echo $item['title'] ?? ''; ?>">
    </label>
    <button class="button button-secondary repeater-remove reset"><?php echo __('Remove item', 'suitcasemag-theme'); ?></button>
</div>