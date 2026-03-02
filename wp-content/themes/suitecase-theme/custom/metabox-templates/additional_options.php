<label for="is-discover-more">
    <?php echo __('&quot;Discover more&quot;', 'suitcasemag-theme'); ?>
    <input type="checkbox" id="is-discover-more" name="additional_options[is_discover_more]" <?php echo !empty($item['is_discover_more']) ? 'checked' : ''; ?>>
</label>
<label for="is-favorite">
    <?php echo __('Is favorite', 'suitcasemag-theme'); ?>
    <input type="checkbox" id="is-favorite" name="additional_options[is_favorite]" <?php echo !empty($item['is_favorite']) ? 'checked' : ''; ?>>
</label>