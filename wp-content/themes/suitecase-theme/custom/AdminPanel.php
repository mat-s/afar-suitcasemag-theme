<?php

if (!defined('ABSPATH')) {
  exit;
}

class AdminPanel extends CustomMetaboxes
{
  public $metaboxes;

  public $settings = array();

  public function __construct()
  {

    $this->metaboxes = array();

    foreach ($this->metaboxes as $key => $metabox) {
      $option_value = get_option($key);
      if (!empty($option_value)) {
        if (is_array($option_value)) {
          $this->settings[$key] = $option_value;
          continue;
        }

        $decoded_option = json_decode($option_value, true);

        if (is_array($decoded_option) && json_last_error() === JSON_ERROR_NONE) {
          $this->settings[$key] = $decoded_option;
        } else {
          $this->settings[$key] = $option_value;
        }
      }
    }

    $general_settings = get_option('suitcasemag_settings');

    if (!empty($general_settings)) {
      foreach ($general_settings as $key => $option_value) {
        $this->settings[$key] = $option_value;
      }
    }

    /**
     * Extended by @class CustomMetaboxes
     */
    add_action('add_meta_boxes', array($this, 'add_custom_metaboxes'));

    /*$this->register_settings();
        $this->add_menu_items();*/
    add_action('admin_menu', array($this, 'register_settings'));
    add_action('admin_menu', array($this, 'add_menu_items'));
    add_action('save_post', array($this, 'save_custom_page_data'));

    add_action('wp_ajax_reset_all_settings', array($this, 'reset_all_settings'));
    add_action('wp_ajax_nopriv_reset_all_settings', array($this, 'reset_all_settings'));
  }


  public function add_menu_items()
  {
    add_menu_page( // Or add_submenu_page();
      'Suitcasemag Settings',
      'Suitcasemag',
      'manage_options',
      'suitcasemag-general-settings',
      array($this, 'render_general_settings_page'),
      'dashicons-media-document'
    );

    add_submenu_page(
      'suitcasemag-general-settings',
      'General Settings',
      'General',
      'manage_options',
      'suitcasemag-general-settings',
      array($this, 'render_general_settings_page')
    );
  }

  public function render_general_settings_page()
  {
    ob_start(); ?>

    <div class="wrap">
      <?php if (isset($_GET['settings-reset']) && $_GET['settings-reset'] == 'true') {
        add_settings_error('reset-settings', 'reset-success', __('Settings reset successfully.', 'suitcasemag-theme'), 'updated');
      }
      settings_errors('reset-settings'); ?>
      <form id="suitcasemag-general-settings" method="post" action="options.php">
        <?php
        settings_fields('suitcasemag_settings_group');
        do_settings_sections('suitcasemag-general-settings');
        submit_button(__('Save Settings', 'suitcasemag-theme'), 'primary', 'submit', false);
        ?>
        <button type="button" class="button" id="reset-settings"><?php esc_html_e('Reset Settings', 'suitcasemag-theme'); ?></button>
      </form>
    </div>

  <?php echo ob_get_clean();
  }

  public function register_settings()
  {
    register_setting('suitcasemag_settings_group', 'suitcasemag_settings');

    register_setting('suitcasemag_settings_group', 'suitcasemag_socials');

    add_settings_section(
      'suitcasemag_general_settings_section', // Section name
      __('General Settings', 'suitcasemag-theme'),
      array($this, 'settings_section_general'), // Callback function
      'suitcasemag-general-settings'
    );

    add_settings_field(
      'suitcasemag_socials', // Field name
      false, // Field header
      array($this, 'settings_field_socials'), // Callback function
      'suitcasemag-general-settings',
      'suitcasemag_general_settings_section' // Section name
    );
  }

  public function settings_section_general()
  {
    echo '<p><div class="message"></div></p>';
  }

  public function settings_field_socials()
  {
    $available_socials = array(
      'facebook',
      'twitter',
      'instagram',
      'youtube',
      'telegram',
      'tik-tok'
    );

    $socials_option = get_option('suitcasemag_socials');

  ?>
    <h3><?php echo __('Suitcasemag Socials', 'suitcasemag-theme'); ?></h3>
    <ul class="suitcasemag-settings-socials">
      <?php foreach ($available_socials as $social_name) {
        $social_icon = is_file(get_template_directory() . '/assets/images/socials/' . $social_name . '.svg') ? file_get_contents(get_template_directory() . '/assets/images/socials/' . $social_name . '.svg') : ''; ?>
        <li>
          <label for="<?php echo $social_name . '-link'; ?>"><?php echo ucfirst($social_name); ?><i class="social-icon"><?php echo $social_icon; ?></i></label>
          <input type="text" id="<?php echo $social_name . '-link'; ?>" name="suitcasemag_socials[<?php echo $social_name; ?>]" value="<?php echo esc_attr($socials_option[$social_name] ?? ''); ?>">
        </li>
      <?php } ?>
    </ul>
<?php
  }

  public function save_custom_page_data($post_id)
  {
    global $post;

    if (!empty($post) && $post->post_name !== 'home') {
      return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
      return $post_id;
    }

    foreach ($this->metaboxes as $key => $metabox) {

      if (!empty($_POST[$key])) {
        update_option($key, $_POST[$key]);
      } else {
        delete_option($key);
      }
    }
  }

  public function reset_all_settings()
  {
    delete_option('suitcasemag_settings');

    wp_send_json(array('success' => true));
  }
}
