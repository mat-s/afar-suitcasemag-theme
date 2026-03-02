<?php

global $section_value;

?>

<div class="block--lowdown">
    <div class="block__content lowdown-block">
        <h2 class="lowdown-title">
            The Lowdown
        </h2>
        <?php if (!empty($section_value['value']['content'])){ ?>
            <div class="block__body richtext">
                <?php echo do_shortcode($section_value['value']['content']); ?>
            </div>
        <?php } ?>
    </div>
</div>
