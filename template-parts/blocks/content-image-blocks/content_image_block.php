<?php

$heading = get_field('heading');
$description = get_field('description');
$image = get_field('image');
$cta_button = get_field('cta_button') ? get_field('cta_button') : '';
$alignment = get_field('alignment');
$vertical_padding = get_field('vertical_padding') ? get_field('vertical_padding') : '';
$background_color = get_field('background_color') ? get_field('background_color') : '';
?>

<section class="component--content-image-block <?php echo esc_attr($vertical_padding . ' ' . $background_color); ?>">
    <div class="container">
        <div class="row d-flex <?php echo esc_attr($alignment); ?> gap-3 justify-content-center align-items-center">
            <div class="col-12 col-lg-5">
                <h2 class="text-primary lh-1 pb-3"><?php echo $heading; ?></h2>
                <?php echo $description; ?>
                <?php if ($cta_button) : ?>
                    <a href="<?php echo esc_url($cta_button['url']); ?>" class="btn btn-primary mt-3"><?php echo $cta_button['title']; ?></a>
                <?php endif; ?>
            </div>
            <div class="col-12 col-lg-6">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="img-fluid" />
            </div>
        </div>
    </div>
</section>