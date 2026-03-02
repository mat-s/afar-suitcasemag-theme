<?php
$socials_option = get_option('suitcasemag_socials');

$available_socials = array(
    'facebook',
    'twitter',
    'instagram',
    'youtube',
    'telegram',
    'tik-tok'
);

if (!empty($socials_option)) {
    foreach ($socials_option as $social_name => $social_link) {
        if (!empty($social_link)) {
            $social_icon = is_file(get_template_directory() . '/assets/images/socials/' . $social_name . '.svg') ? file_get_contents(get_template_directory() . '/assets/images/socials/' . $social_name . '.svg') : '';
            ?>
            <a class="social-link" href="<?php echo $social_link; ?>">
                <i class="social-icon"><?php echo $social_icon; ?></i>
            </a>
        <?php }
    }
}