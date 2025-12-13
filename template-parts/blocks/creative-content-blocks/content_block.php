<?php

$content = get_field('content');
$vertical_padding = get_field('vertical_padding') ? get_field('vertical_padding') : 'py-5';
$background_color = get_field('background_color') ? get_field('background_color') : 'bg-white';

?>

<section class="content-block <?php echo $background_color; ?> <?php echo $vertical_padding; ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</section>