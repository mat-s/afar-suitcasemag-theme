<form id="searchform" class="search" method="get" action="<?php echo esc_url( home_url() ); ?>">
    <div class="search-container" role="search">
        <input class="search-input" type="search" name="s" aria-label="Search site for:" placeholder="<?php esc_html_e('Search', 'suitcasemag-theme'); ?>">
        <button class="search-submit" type="submit">
            <?php echo '<div class="search-icon">' . file_get_contents(get_template_directory() . '/assets/images/icons/magnifying-glass.svg') . '</div>'; ?>
        </button>
        <div class="search-progress" id="search-progress">
            <div class="search-progress-content">
                <span class="loader"></span>
                Search in progress
            </div>
        </div>
    </div>
</form>
