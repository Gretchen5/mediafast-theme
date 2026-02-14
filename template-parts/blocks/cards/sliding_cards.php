<?php
// ACF Fields
$heading = get_field('heading') ?: '';
$subheading = get_field('subheading') ?: '';
$background_color = get_field('background_color') ?: '';
$bg_class = $background_color ? '' : 'bg-lt-gray';
?>

<!-- Sliding Cards Section -->
<section class="component--sliding-cards <?php echo esc_attr($bg_class); ?> py-5" <?php if ($background_color) : ?>style="background-color: <?php echo esc_attr($background_color); ?>"<?php endif; ?>>
    <div class="container">
        <?php if ($subheading || $heading) : ?>
            <div class="row justify-content-center mb-4">
                <div class="col-lg-11 text-center">
                    <?php if ($subheading) : ?>
                        <span class="d-inline-block fw-500 text-uppercase mb-2 text-gray"><?php echo esc_html($subheading); ?></span>
                    <?php endif; ?>
                    <?php if ($heading) : ?>
                        <h2 class="text-secondary mb-0"><?php echo wp_kses_post($heading); ?></h2>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (have_rows('card_repeater')) : ?>
            <div class="row">
                <div class="position-relative">
                    <div class="sliding-cards-wrapper px-3 px-md-5">
                        <div class="swiper sliding-cards-slider">
                            <div class="swiper-wrapper">
                                <?php while (have_rows('card_repeater')) : the_row();
                                    $image = get_sub_field('image');
                                    $icon = get_sub_field('icon') ?: '';
                                    $card_heading = get_sub_field('card_heading');
                                    $card_description = get_sub_field('card_description');
                                ?>
                                    <div class="swiper-slide">
                                        <div class="sliding-card bg-white shadow-sm h-100">
                                            <div class="row g-0 h-100">
                                                <!-- Content Column -->
                                                <div class="col-12 col-md-6 sliding-card__content">
                                                    <div class="sliding-card__inner p-4 p-md-5 h-100 d-flex flex-column">
                                                        <?php if ($icon) : ?>
                                                            <div class="sliding-card__icon mb-3">
                                                                <i class="<?php echo esc_attr($icon); ?>"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($card_heading) : ?>
                                                            <h3 class="sliding-card__heading h4 text-secondary mb-3"><?php echo wp_kses_post($card_heading); ?></h3>
                                                        <?php endif; ?>
                                                        <?php if ($card_description) : ?>
                                                            <div class="sliding-card__description text-body flex-grow-1">
                                                                <?php echo wp_kses_post($card_description); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <!-- Image Column -->
                                                <?php if ($image) : ?>
                                                    <div class="col-12 col-md-6 sliding-card__image">
                                                        <div class="sliding-card__image-wrapper h-100">
                                                            <?php echo mediafast_get_optimized_image($image, 'acf-large', array('class' => 'img-fluid', 'alt' => $image['alt'] ?: $card_heading)); ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>