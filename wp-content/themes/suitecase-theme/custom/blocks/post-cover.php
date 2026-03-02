<li class="post-cover">
    <?php
    $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    ?>
    <div style="background-image: url(<?php echo esc_url( $thumbnail_url ); ?>)"   class="post-cover-inner">
        <span style="position: absolute; top: 20px; left: 50%; transform: translateX(-50%); color: #ffffff; text-transform: uppercase;"><?php echo __('Discover more', 'suitcasemag-theme'); ?></span>
        <h3 class="post-cover-title"><?php echo esc_attr( get_the_title() ); ?></h3>
        <a class="read-more" href="<?php echo esc_url(get_permalink()); ?>"><?php echo __('Read now', 'suitcasemag-theme'); ?></a>
    </div>
</li>