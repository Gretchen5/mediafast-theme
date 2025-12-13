<?php

$marquee_text = get_sub_field('marquee_text');

?>

<section class="component--marquee">
    <div class="py-5 bg-purple">
        <div class="marquee-container">
            <div class="marquee-track">
                <div class="marquee-item d-flex align-items-center">
                    <?php echo $marquee_text; ?>
                </div>
                <div class="marquee-item d-flex align-items-center">
                    <?php echo $marquee_text; ?>
                </div>
            </div>
        </div>
    </div>
</section>