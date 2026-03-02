<?php
global $section_value;

if (empty($section_value['value'])) {
  return false;
  //$thumbnail_url = get_template_directory_uri() . '/assets/images/no_image.svg';
}

$image_ids = array();
$image_ids = explode(',', preg_replace('/\s+/', '', $section_value['value']));

if (isset($section_value['apply_swiper']) && $section_value['apply_swiper'] == 'on') { ?>
  <!--Swiper loop-->
  <div class="multiple-image swiper">
    <div class="swiper-wrapper">
      <?php foreach ($image_ids as $image_id) {
        $thumbnail_url = wp_get_attachment_image_url($image_id, 'middle');
      ?>
        <img class="swiper-slide" src="<?php echo esc_url($thumbnail_url); ?>">
      <?php } ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
<?php } else { ?>
  <!--Gallery loop-->
  <div class="multiple-image grid grid-<?php echo min(count($image_ids), 3); ?>">
    <?php foreach ($image_ids as $image_id) {
      $thumbnail_url = wp_get_attachment_image_url($image_id, 'middle');
    ?>
      <img class="" src="<?php echo esc_url($thumbnail_url); ?>">
    <?php } ?>
  </div>
<?php } ?>

<script>
  jQuery(document).ready(function($) {
    new Swiper(".swiper", {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        768: {
          slidesPerView: 3
        },
        420: {
          slidesPerView: 2
        }
      }
    });
  });
</script>