<?php

global $section_value;

?>

<div class="article__richtext">
  <?php if (!empty($section_value['value']['title'])) { ?>
    <h2 class="richtext__title">
      <?php echo $section_value['value']['title']; ?>
    </h2>
  <?php } ?>
  <?php if (!empty($section_value['value']['entry'])) { ?>
    <p class="richtext__entry">
      <?php echo $section_value['value']['entry']; ?>
    </p>
  <?php } ?>
  <?php if (!empty($section_value['value']['content'])) { ?>
    <div class="richtext__content">
      <?php echo do_shortcode($section_value['value']['content']); ?>
    </div>
  <?php } ?>
</div>