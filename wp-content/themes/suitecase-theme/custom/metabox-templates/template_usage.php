<?php $value = $item['template_usage'] ?? null; ?>
<span>How to display content:</span>
<label for="template_usage"><?php __('How to display content:', 'suitcasemag-theme'); ?></label>
<br />  
<input type="radio" name="template_usage" value="old_variant" <?php checked($value, 'old_variant'); ?> required />
<?php echo __('Old variant: &quot;As is&quot; from Content (Elementor) section [default]', 'suitcasemag-theme'); ?>
<br />
<input type="radio" name="template_usage" value="new_variant" <?php checked($value, 'new_variant'); ?> />
<?php echo __('New variant: from Content sections', 'suitcasemag-theme'); ?>
