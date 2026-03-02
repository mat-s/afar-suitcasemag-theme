<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div class="wrapper">
    <?php $custom_class = isset($args['custom-class']) ? $args['custom-class'] : ''; ?>
    <header class="header <?php echo esc_attr($custom_class); ?>">
      <div class="desktop-header">
        <div class="header-logo">
          <a class="logo" href="/">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/suitcase-logo.svg" alt="Suitcase Magazine Logo" role="img">
          </a>
        </div>
        <div class="header-nav-wrapper">
          <nav class="header-menu" aria-label="Main navigation">
            <?php
            if ($main_menu = wp_get_nav_menu_object('main-menu')) {
              wp_nav_menu(
                array(
                  'menu' => $main_menu->term_id,
                  'container' => 'nav',
                  'container_class' => 'main-menu-container',
                  'container_role' => 'navigation',
                  'menu_id' => 'main-menu',
                  'menu_class' => 'dropdown-menu menu'
                )
              );
            }
    
            get_template_part('searchform');
    
            ?>
          </nav>
          <div class="header-social-icons">
            <?php require __DIR__ . '/custom/blocks/socials.php'; ?>
          </div>
        </div>
      </div>
      
      <div id="mobile-header" class="fixed-header container">
        <?php

        require get_template_directory() . '/custom/widgets/MobileMenu.php';
        echo (new MobileMenu())->content();

        ?>
        <a class="logo logo-mobile" href="/">
        <img src="<?php echo get_template_directory_uri() . '/assets/images/suitcase-logo.svg'; ?>" alt="Suitcase Magazine Logo" role="img">
        </a>
        <button class="mobile-search-toggle" aria-label="Toggle mobile search">
          <?php echo '<div class="search-icon">' . file_get_contents(get_template_directory() . '/assets/images/icons/magnifying-glass.svg') . '</div>'; ?>
        </button>
        <?php //the_custom_logo(); 
        ?>
      </div>
      <div id="mobile-search-container" class="container" role="search">
        <?php get_template_part('searchform'); ?>
      </div>
  </div>
  </header>