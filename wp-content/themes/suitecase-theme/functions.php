<?php


/**
 * Add theme support for various WordPress features.
 *
 * @return void
 */
function suitcasemag_setup() {
	// Support programmable title tag.
	add_theme_support( 'title-tag' );

	// Support custom logo.
	add_theme_support( 'custom-logo' );

	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on suitcasemag-theme, use a find and replace
	 * to change 'suitcasemag-theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'suitcasemag-theme', get_template_directory() . '/languages' );

	// Register top menu.
	register_nav_menus(
		array(
			'top' => esc_html__( 'Top Menu', 'suitcasemag-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'suitcasemag_setup' );

/**
 * Specify JS && CSS
 *
 * @return void
 */
function enqueue_custom_assets() {
    $version = time();

    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/script.js', array('jquery'), $version);
    wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', array(), $version );
    wp_enqueue_style( 'recover', get_stylesheet_directory_uri() . '/assets/styles/recover.css', array(), $version );
    wp_enqueue_style( 'swiper', get_stylesheet_directory_uri() . '/assets/styles/swiper.css', array(), $version );
    wp_enqueue_script('swiper-bundle', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('script', 'jquery'), $version, true);
    wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/assets/js/swiper.js', array('script', 'jquery'), $version, true);
    wp_enqueue_script('single-post-swiper', get_stylesheet_directory_uri() . '/assets/js/single-post-swiper.js', array('script', 'swiper-bundle', 'jquery'), $version, true);
    wp_enqueue_style( 'swiper-bundle', get_stylesheet_directory_uri() . '/assets/styles/swiper-bundle.min.css', array(), $version );
    wp_enqueue_style( 'single-post-swiper', get_stylesheet_directory_uri() . '/assets/styles/single-post-swiper.css', array(), $version );

    //add advertising widgets style-file with css
    wp_enqueue_style('advertising-style', get_stylesheet_directory_uri() . '/assets/css/ad-widgets-styles.css', array(), $version);

    //add style-file with css fixes
    wp_enqueue_style('fix-style', get_stylesheet_directory_uri() . '/assets/css/fix-styles.css', array(), $version);

    // Define script/style for lightbox
    /*wp_enqueue_style( 'magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', array(), '1.1.0', 'all');
    wp_enqueue_script( 'magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true );*/
}

add_action( 'wp_enqueue_scripts', 'enqueue_custom_assets' );

function enqueue_admin_assets()
{
    $version = time();
    wp_enqueue_media();
    wp_enqueue_script('admin-panel', get_stylesheet_directory_uri() . '/assets/js/admin-panel.js', array('jquery'), $version);
    wp_enqueue_style( 'admin-panel', get_stylesheet_directory_uri() . '/assets/styles/admin-panel.css', array(), $version );
}

add_action( 'admin_enqueue_scripts', 'enqueue_admin_assets' );

/**
 * Register widget area.
 *
 * @return void
 */
function suitcasemag_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'suitcasemag-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'suitcasemag-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'suitcasemag_widgets_init' );

function get_block($block_name)
{
    if ( function_exists('pll_current_language') ) {
        $lang_slug = pll_current_language('slug');
    } else {
        $lang_slug = 'uk';
    }

    if (!file_exists(get_template_directory() . '/custom/blocks/' . $lang_slug . '/' . $block_name . '.php') && !file_exists(get_template_directory() . '/custom/blocks/uk/' . $block_name . '.php')){
        return;
    }

    require get_template_directory() . '/custom/blocks/' . $lang_slug . '/' . $block_name . '.php';
}

/**
 * Allow svg upload
 */
function allow_svg_upload( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'allow_svg_upload' );

/**
 * Disable Gutenberg
 */
add_filter('use_block_editor_for_post', '__return_false');

/**
 * Disable content editor in the post
 */

 define('IS_DEFULT_EDITOR_ENABLED', true);
 if (!IS_DEFULT_EDITOR_ENABLED) {
     add_action('init', function(){
         remove_post_type_support( 'post', 'editor' );
     });
     function change_excerpt_label( $translation, $text, $domain ) {
         if ( $text == 'Excerpt' ) {
             return 'Standfirst';
         }
         return $translation;
     }
     add_filter( 'gettext', 'change_excerpt_label', 20, 3 );
 } else {
    add_theme_support( 'post-thumbnails');
    // Move TinyMCE Editor to the bottom
    add_action('add_meta_boxes', 'action_add_meta_boxes', 0);
    function action_add_meta_boxes() {
        global $_wp_post_type_features;
        if (isset($_wp_post_type_features['post']['editor']) && $_wp_post_type_features['post']['editor']) {
            unset($_wp_post_type_features['post']['editor']);
            add_meta_box(
                'description_section',
                __('Content (Elementor)'),
                'inner_custom_box',
                'post',
                'normal',
                'low'
            );
        }
        add_action('admin_head', 'action_admin_head');
    }

    function action_admin_head() { ?>
        <style type="text/css">.wp-editor-container{background-color:#fff;}</style>
    <?php }

    function inner_custom_box($post) {
        echo '<div class="wp-editor-wrap">';
        wp_editor($post->post_content, 'content', array('dfw' => true, 'tabindex' => 1) );
        echo '</div>';
    }
}

require_once __DIR__ . '/custom/CustomMetaboxes.php';
require_once __DIR__ . '/custom/AdminPanel.php';
require_once __DIR__ . '/custom/custom-hooks.php';
require_once __DIR__ . '/custom/db-cleaning-tools.php';

add_action('acf/init', function () {
    require_once __DIR__ . '/custom/acf-fields/homepage-content-blocks.php';
});

$custom_metaboxes = new CustomMetaboxes();
$admin_panel = new AdminPanel();

/*add_action('admin_init', function(){
    $admin_panel = new AdminPanel();
    $custom_metaboxes = new CustomMetaboxes();
});*/

function correct_images_src($content)
{
    if (!is_single()){
        return $content;
    }

    return preg_replace('/suitcasemag\.horizn\.de/', 'suitcasemag.com', $content);

}

//add_filter('the_content', 'correct_images_src');

function get_current_page()
{
    $url = home_url($_SERVER['REQUEST_URI']);
    return preg_match("/\/page\/(\d+)\//", $url, $matches) ? intval($matches[1]) : 1;
}

// avoid converting special symbols
remove_filter('the_content', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');
remove_filter('the_title', 'wptexturize');

// remove extra breaks from editor
remove_filter('the_content', 'wpautop');

function custom_wpautop($content) {
    // Add paragraph tags, but prevent <br> tags
    return wpautop($content, false);
}

add_filter('the_content', 'custom_wpautop');
add_filter('the_excerpt', 'custom_wpautop');