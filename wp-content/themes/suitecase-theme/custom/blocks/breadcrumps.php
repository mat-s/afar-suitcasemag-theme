<ul class="breadcrumbs">
    <?php if (!is_home()) { ?>
        <li><a href="<?php echo home_url(); ?>"><?php echo __('Home', 'suitcasemag-theme'); ?></a></li>
        <?php if (is_single()) {
            $categories = get_the_category($post->ID);
            if ($categories) {
                $category = $categories[0];
                $breadcrumbs = array();

                while($category){
                    $breadcrumbs[] = '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
                    if ($category->parent === 0){
                        break;
                    }
                    $category = get_category($category->parent);

                }

                $breadcrumbs = array_reverse($breadcrumbs);

                foreach ($breadcrumbs as $crumb) {
                    echo $crumb;
                }
            } ?>
            <li><?php echo __('Current article', 'suitcasemag-theme'); /*get_the_title();*/ ?></li>
        <?php } elseif (is_category()) { ?>
            <li><?php echo single_cat_title('', false); ?></li>
        <?php } elseif (is_page()) {
            if ($post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo $crumb;
                }
            }
            echo '<li>' . get_the_title() . '</li>';
        }
    } ?>
</ul>