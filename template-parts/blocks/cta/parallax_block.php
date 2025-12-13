<?php
$bg_image = get_field('bg_image') ? 'background-image: url(' . get_field('bg_image') . ');' : '';
$heading  = get_field('heading');
$content  = get_field('content');
?>

<section class="parallax-section text-white d-flex align-items-center"
    style="<?php echo $bg_image; ?>">
    <div class="container text-center">
        <?php if ($heading): ?>
            <h2 class="mb-3 text-white"><?php echo $heading; ?></h2>
        <?php endif; ?>

        <?php if ($content): ?>
            <div class="lead text-white"><?php echo $content; ?></div>
        <?php endif; ?>
    </div>
</section>