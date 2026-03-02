<?php

class MobileMenu extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'mobile_menu_widget',
            'Мобільне меню (віджет)'
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        echo $this->content();
        echo $args['after_widget'];
    }

    public function content()
    {
        ob_start();
        ?>
        <a class="button mobile-menu-toggle menu-open" menu-id="mobile-menu-container">
            <?php echo '<div class="open-icon">' . file_get_contents(get_template_directory() . '/assets/images/icons/bars.svg') . '</div>'; ?>
            <?php echo '<div class="close-icon">' . file_get_contents(get_template_directory() . '/assets/images/icons/xmark.svg') . '</div>'; ?>
        </a>
        <?php
        if ($mobile_menu = wp_get_nav_menu_object('main-menu')) {
            wp_nav_menu(
                array(
                    'menu' => $mobile_menu->term_id,
                    'container' => 'nav',
                    'container_class' => 'mobile-menu-container',
                    'container_id' => 'mobile-menu-container',
                    'container_role' => 'navigation',
                    'menu_id' => 'mobile-menu',
                    'menu_class' => 'toggle-menu menu'
                )
            );
        } ?>
        <?php return ob_get_clean();
    }


    private function script()
    {
        ob_start(); ?>
        <script>
            $('.menu-open').on('click', function() {
                toggle_menu(this);
            });

            $('.menu-close').on('click', function() {
                toggle_menu(this);
            });

            $('.overlay').on('click', function() {
                toggle_menu(this);
            });

            function toggle_menu(element){
                let menu_id = $(element).attr('menu-id');

                let toggle_menu = $(document).find('#' + menu_id);

                if (!toggle_menu) return;

                $(toggle_menu).toggleClass('opened');
                $('body').toggleClass('overflow-hidden');
                $('.overlay[menu-id=' + menu_id + ']').toggleClass('displayed');
            }
        </script>
        <?php return ob_get_clean();
    }

    private function style()
    {
        ob_start(); ?>
        <style>
            .menu-open,
            .menu-close{
                background-color: #0054B2!important;
                background-position: center;
                background-repeat: no-repeat;
                cursor: pointer;
                border-radius: 5px!important;
                padding: 0!important;
                width: 40px;
                height: 40px;
                display: flex!important;
                justify-content: center;
                align-items: center;
            }
            .menu-close{
                position: absolute!important;
                right: 5px;
                top: 5px;
            }
            .overlay{
                position: fixed;
                top: 0;
                bottom: 0;
                right: 0;
                left: 0;
                z-index: 5;
                background: rgba(0, 0, 0, 0.5);
                display: none;
            }

            .toggle-menu-container{
                overflow-y: scroll;
                z-index: 10;
                background-color: #ffffff;
                width: 70%;
                position: fixed;
                top: 0;
                left: -100%;
                min-width: 240px;
                height: 100%;
                transition: left 0.3s ease-out;
            }
            .toggle-menu-container .menu{
                padding: 0;
            }
            .toggle-menu-header{
                padding: 20px;
                background-color: var(--e-global-color-primary);
            }
            .toggle-menu-header a{
                text-decoration: unset!important;
                color: #ffffff;
            }
            .toggle-menu-body{
                padding: 20px;
            }
            .mobile-menu-item{
                margin-bottom: 20px;
            }
            .mobile-menu-item i{
                margin-right: 10px;
            }
            .overflow-scroll-hidden::-webkit-scrollbar {
                width: 0;
            }
            .overflow-scroll-hidden {
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
        </style>
        <?php return ob_get_clean();
    }
}