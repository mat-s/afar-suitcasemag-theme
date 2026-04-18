<?php


class CustomMetaboxes
{
    public $metaboxes = array();
    public $post_meta = array();

    public function __construct()
    {
        $this->metaboxes = array(
            'template_usage' => array(
                'post_type' => 'post',
                'name' => 'template_usage',
                'title' => __('Template usage', 'suitcasemag-theme'),
                'template' => 'template_usage',
                'priority' => 'high'
            ),
            'additional_options' => array(
                'post_type' => 'post',
                'name' => 'additional_options',
                'title' => __('Additional options', 'suitcasemag-theme'),
                'template' => 'additional_options'
            ),
            'post_thumbnail' => array(
                'post_type' => 'post',
                'name' => 'post_thumbnail',
                'title' => __('Hero Image', 'suitcasemag-theme'),
                'template' => 'post_thumbnail'
            ),
            'teaser_image' => array(
                'post_type' => 'post',
                'name' => 'teaser_image',
                'title' => __('Teaser Image (Portrait)', 'suitcasemag-theme'),
                'template' => 'teaser_image'
            ),
            'byline' => array(
                'post_type' => 'post',
                'name' => 'byline',
                'title' => __('Byline', 'suitcasemag-theme'),
                'template' => 'byline'
            ),
            'content_sections' => array(
                'post_type' => 'post',
                'name' => 'content_sections',
                'title' => __('Content sections', 'suitcasemag-theme'),
                'template' => 'content_sections',
                'sections' => array(
                    'single_image' => array(
                        'name' => 'single_image',
                        'title' => __('Single image', 'suitcasemag-theme'),
                        'template' => 'single_image'
                    ),
                    'multiple_image' => array(
                        'name' => 'multiple_image',
                        'title' => __('Multiple image', 'suitcasemag-theme'),
                        'template' => 'multiple_image'
                    ),
                    'richtext' => array(
                        'name' => 'richtext',
                        'title' => __('Richtext', 'suitcasemag-theme'),
                        'template' => 'richtext'
                    ),
                    'lowdown' => array(
                        'name' => 'lowdown',
                        'title' => __('Lowdown', 'suitcasemag-theme'),
                        'template' => 'lowdown'
                    ),
                    'discover_more' => array(
                        'name' => 'discover_more',
                        'title' => __('Discover more', 'suitcasemag-theme'),
                        'template' => 'discover_more'
                    )
                )
            )
        );

        $this->get_post_meta();

        /*add_action('add_metaboxes', array($this, 'add_custom_post_metaboxes'));*/
        add_action('add_meta_boxes', array($this, 'add_custom_metaboxes'));
        add_action('save_post', array($this, 'save_custom_post_data'));
        add_action('category_edit_form_fields', array($this, 'render_attached_image_metabox'));
        add_action( 'edited_category',  array($this, 'save_category_image_meta_data'));

        /*add_action('admin_head', array($this, 'enqueue_styles'));*/

        add_action('wp_ajax_get_content_section', array($this, 'get_content_section'));
        add_action('wp_ajax_nopriv_get_content_section', array($this, 'get_content_section'));

        add_action('wp_ajax_get_metabox_template', array($this, 'get_metabox_template'));
        add_action('wp_ajax_nopriv_get_metabox_template', array($this, 'get_metabox_template'));
    }

    public function get_post_meta()
    {
        $post_id = !empty($post)
            ? $post->ID
            : (isset($_GET['post'])
                ? $_GET['post']
                : (isset($_POST['post'])
                    ? $_POST['post']
                    : null
                )
            );

        if ($post_id) {
            $post_meta = get_post_meta($post_id);
            foreach ($post_meta as $key => $data) {
                if (!is_string($data[0])) {
                    $post_meta[$key] = $data[0];
                    continue;
                }

                $decoded_data = json_decode($data[0], true);
                $post_meta[$key] = is_array($decoded_data) && json_last_error() === JSON_ERROR_NONE
                    ? $decoded_data
                    : $data[0];
            }

            $this->post_meta = $post_meta;
        }
    }

    public function add_custom_metaboxes()
    {
        global $post;
        foreach ($this->metaboxes as $name => $metabox) {
            if (isset($metabox['post_name']) && $metabox['post_name'] != $post->post_name) {
                continue;
            }
            add_meta_box(
                "{$name}_metabox",
                $metabox['title'],
                function() use ($metabox) {
                    $this->render_metabox($metabox);
                },
                !empty($metabox['post_type']) ? $metabox['post_type'] : 'post',
                'normal',
                $metabox['priority'] ?? 'core'
            );
        }
    }
    /*public function add_custom_post_metaboxes() {
        foreach ($this->metaboxes as $name => $metabox) {
            $method_name = "render_{$name}_metabox";
            if (method_exists($this, $method_name)) {
                add_metabox(
                    "{$name}_metabox",
                    $metabox['title'],
                    array($this, $method_name),
                    'post',
                    'normal',
                    'default'
                );
            }
        }
    }*/
    public function get_metabox_template($metabox = array(), $item = array(), $key = 0)
    {
        $template = $metabox['template'] ?? '';
        if (isset($_POST['action']) && $_POST['action'] == 'get_metabox_template'){
            $template = $_POST['template'] ?? '';
        }

        $template_path = get_template_directory() . "/custom/metabox-templates/{$template}.php";
        if (file_exists($template_path)){
            require $template_path;
        }

        if (isset($_POST['action']) && $_POST['action'] == 'get_metabox_template'){
            wp_die();
        }
    }

    public function render_metabox($metabox)
    {
        $available_section_types = array('repeater', 'simple');
        $section_type = !empty($metabox['type']) && in_array($metabox['type'], $available_section_types) ? $metabox['type'] : 'simple';
        ?>
        <div class="section__<?php echo $metabox['name']; ?> section-type__<?php echo $section_type; ?>" template="<?php echo $metabox['repeater_template'] ?? ''; ?>">
            <?php
            $this->get_metabox_template($metabox, $this->post_meta);
            ?>
        </div>
        <?php
    }

    public function get_section_key()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';

        return !empty($_POST['repeater_key']) && is_numeric($_POST['repeater_key']) ? $_POST['repeater_key'] : substr(str_shuffle($characters), 0, 12);
    }

    public function save_custom_post_data($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        foreach ( $_POST as $key => $value ) {
            if (!isset($this->metaboxes[$key])){
                continue;
            }

            // Filter empty content sections
            if ($key == 'content_sections' && !empty($value)){
                $ordered_content_sections = array();
                foreach ($value as $section_key => $section_content){
                    $section_name = key($section_content);
                    $section_value = reset($section_content);
                    if (!empty($section_value['value'])){
                        if (isset($section_value['value']['content'])){
                            // $section_value['value']['content'] = htmlspecialchars($section_value['value']['content']);
                            $section_value['value']['content'] = str_replace(
                                "\r\n",
                                '<br>',
                                str_replace("\'", "'", trim($section_value['value']['content']))
                            );
                            /*$section_value['value']['content'] = nl2br($section_value['value']['content']);*/
                        }

                        $ordered_content_sections[] = array($section_name => $section_value);
                    }/* else {
                        unset($value[$section_key][$section_name]);
                    }*/
                }
                $value = $ordered_content_sections;
            }

            if (is_array($value)){
                $value = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }

            update_post_meta($post_id, $key, $value);
        }

        /*foreach ($_POST as $key => $value) {
            if (in_array($allowed_meta_keys, $key)){
                update_post_meta($post_id, $key, $value);
            };
        }*/
        /*    if (isset($_POST['is_discover_more'])) {
                update_post_meta($post_id, 'is_discover_more', $_POST['is_discover_more']);
            }

            if (isset($_POST['is_favorite'])) {
                update_post_meta($post_id, 'is_favorite', $_POST['is_favorite']);
            }*/

        if (!empty($_POST['post_thumbnail']) && empty($_POST['_thumbnail_id'])) {
            update_post_meta($post_id, '_thumbnail_id', $_POST['post_thumbnail']);
        }

        update_post_meta($post_id, 'is_discover_more', isset($_POST['additional_options']['is_discover_more']));
        update_post_meta($post_id, 'is_favorite', isset($_POST['additional_options']['is_favorite']));
    }

    /**
     * Categories extra fields
     *
     * @param $category_obj
     * @return void
     */
    public function render_attached_image_metabox( $category_obj ) {

        $category_image = get_term_meta( $category_obj->term_id, 'category_image', true );
        $image_url = wp_get_attachment_image_url( $category_image, 'medium' );

        ?>
        <tr class="form-field">
            <th><?php echo __('Attached image', 'suitcasemag-theme'); ?></th>
            <td>
                <img id="category-image-preview" src="<?php echo $image_url ? esc_url($image_url) : ''; ?>" alt="" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                <input type="hidden" id="category-image" name="category_image" value="<?php echo esc_attr( $category_image ); ?>" style="width: 100%;">
                <button type="button" id="category-image-select" class="button"><?php echo __('Select the image', 'suitcasemag-theme'); ?></button>
                <button type="button" id="category-image-remove" class="button remove-button"><?php echo __('Remove the image', 'suitcasemag-theme'); ?></button>
            </td>
        </tr>
        <?php
    }

    public function save_category_image_meta_data( $term_id ) {
        if ( isset( $_POST['category_image'] ) ) {
            update_term_meta( $term_id, 'category_image', sanitize_text_field( $_POST['category_image'] ) );
        }
    }

    public function get_content_section()
    {
        wp_enqueue_editor();

        $available_sections = $this->metaboxes['content_sections']['sections'];
        $selected_section = !empty($_POST['selected_section']) ? $_POST['selected_section'] : '';

        if (array_key_exists($selected_section, $available_sections)){
            $metabox = $available_sections[$selected_section];
            $key = !empty($_POST['section_key']) ? $_POST['section_key'] : 0;
            $this->get_metabox_template($metabox, array(), $key);
        }

        wp_die();
    }

    public function enqueue_styles(){
        ?>
            <style>
            </style>
        <?php
    }
}