<li class="category-loop">
    <a class="category-loop-thumbnail" href="<?php echo get_category_link($category->term_id); ?>">
        <img src="<?php echo $image_url ? esc_url($image_url) : ''; ?>" alt="">
    </a>
    <div class="category-loop-summary">
        <h3 class="category-loop-title">
            <a href="<?php echo get_category_link($category->term_id); ?>"><?php printf($category->name); ?></a>
        </h3>
        <p class="category-description"><?php printf($category->description); ?></p>
    </div>
</li>