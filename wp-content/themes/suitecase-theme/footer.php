      <footer class="footer">
        <div class="newsletter-subscription-form-container" role="form" aria-label="Subscribe to newsletter">
          <?php require get_template_directory() . '/custom/blocks/newsletter-subscription-form.php'; ?>
        </div>
        <div class="footer-top">
          <div class="footer-top-left">
            <?php
            if ($contact_us_menu = wp_get_nav_menu_object('footer-left-menu')) {
              wp_nav_menu(
                array(
                  'menu' => $contact_us_menu->term_id,
                  'container' => 'nav',
                  'container_class' => 'footer-menu-container',
                  'container_role' => 'navigation',
                  'menu_class' => 'contact-us-menu menu',
                  'container_aria_label' => 'Contact information'
                )
              );
            } ?>
          </div>
          <div class="footer-top-socials">
            <?php require __DIR__ . '/custom/blocks/socials.php'; ?>
          </div>
          <div class="footer-top-left">
            <?php
            if ($info_menu = wp_get_nav_menu_object('footer-right-menu')) {
              wp_nav_menu(
                array(
                  'menu' => $info_menu->term_id,
                  'container' => 'nav',
                  'container_class' => 'footer-menu-container',
                  'container_role' => 'navigation',
                  'menu_class' => 'info-menu menu',
                  'container_aria_label' => 'More information'
                )
              );
            } ?>
          </div>
        </div>
      </footer>
    </div>
    <?php wp_footer(); ?> 
  </body>

</html>