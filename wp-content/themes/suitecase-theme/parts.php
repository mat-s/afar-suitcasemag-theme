<time datetime="<?php the_time('Y-m-d'); ?> <?php the_time('H:i'); ?>">
    <?php the_date(); ?><?php the_time(); ?>
</time>

<span class="author"><?php esc_html_e('Post by', 'suitcasemag-theme'); ?><?php the_author_posts_link(); ?></span>
<span class="comments"><?php if (comments_open(get_the_ID())) comments_popup_link(__('Leave your thoughts', 'suitcasemag-theme'), __('1 Comment', 'suitcasemag-theme'), __('% Comments', 'suitcasemag-theme')); ?></span>

<p><?php esc_html_e('Post written by ', 'suitcasemag-theme');
    the_author(); ?></p>
<?php comments_template(); ?>
