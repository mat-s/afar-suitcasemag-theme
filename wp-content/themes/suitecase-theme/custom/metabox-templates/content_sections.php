<?php
global $post;

?>

<div style="margin: 10px 0;">
    <select name="select_new_section" id="select_new_section" post-id="<?php echo $post->ID; ?>">
        <?php foreach ($metabox['sections'] as $name => $section) { ?>
            <option value="<?php echo $name; ?>"><?php echo $section['title']; ?></option>
        <?php } ?>
    </select>
    <button id="add_new_section" post-id="<?php echo $post->ID; ?>" class="button"><?php echo __('Add new section', 'suitcasemag-theme'); ?></button>
</div>
<div class="repeater-items">
<?php if (!empty($item['content_sections'])) {
    $sections = is_string($item['content_sections'])
        ? json_decode($item['content_sections'], true)
        : $item['content_sections'];

    $available_Sections = $metabox['sections']; ?>
    <?php foreach ($sections as $key => $value) {
        if (!$value){
            continue;
        }

        $section_name = key($value);
        $sub_item = reset($value);

        if (!array_key_exists($section_name, $metabox['sections'])){
            continue;
        }

        $sub_metabox = $metabox['sections'][$section_name];
        $this->get_metabox_template($sub_metabox, $sub_item, $key);
    } ?>
<?php } ?>
</div>

