<?php
$section_heading = get_field('section_heading') ? get_field('section_heading') : '';
$section_subheading = get_field('section_subheading') ? get_field('section_subheading') : '';
$section_description = get_field('section_description') ? get_field('section_description') : '';
$section_cta_button = get_field('section_cta_button') ? get_field('section_cta_button') : '';
$front_heading_color = get_field('front_heading_color') ? get_field('front_heading_color') : '';
$front_description_color = get_field('front_description_color') ? get_field('front_description_color') : '';
$padding = get_field('padding');
?>

<section class="component--flip-cards <?php echo esc_attr($padding); ?>">
    <div class="container-xxl px-5 px-xl-3">
        <div class="heading-container container pb-4">
            <?php if ($section_heading) : ?>
                <h2 class="text-center mb-4"><?php echo $section_heading; ?></h2>
            <?php endif; ?>
            <?php if ($section_subheading) : ?>
                <h3 class="text-center mb-4"><?php echo $section_subheading; ?></h3>
            <?php endif; ?>
            <?php if ($section_description) : ?>
                <div class="text-center mb-4"><?php echo $section_description; ?></div>
            <?php endif; ?>
        </div>
        <!-- Flip Card Repeater -->
        <?php if (have_rows('flip_cards')) : ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                <?php while (have_rows('flip_cards')) : the_row();
                    $front_heading = get_sub_field('front_heading');
                    $front_description = get_sub_field('front_description');
                    $back_heading = get_sub_field('back_heading');
                    $back_description = get_sub_field('back_description');
                    $card_color = get_sub_field('card_background_color');
                    $icon = get_sub_field('icon') ? get_sub_field('icon') : '';
                    $card_icon_color = get_sub_field('card_icon_color') ? get_sub_field('card_icon_color') : '';
                    $back_image = get_sub_field('back_image') ? get_sub_field('back_image') : '';
                ?>
                    <div class="col">
                        <div class="flip-card shadow rounded h-100" role="region" aria-labelledby="flip-<?php echo get_row_index(); ?>-front-heading">
                            <div class="flip-card-inner rounded <?php echo esc_attr($card_color); ?>">
                                <div class="flip-card-front p-4 d-flex flex-column justify-content-stretch">
                                    <?php if ($icon) : ?>
                                        <div class="card-icon text-center p-3">
                                            <i class="<?php echo $icon . ' ' . $card_icon_color; ?>" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($front_heading) : ?>
                                        <h3 class="<?php echo $front_heading_color; ?> pt-3" id="flip-<?php echo get_row_index(); ?>-front-heading"><?php echo esc_html($front_heading); ?></h3>
                                    <?php endif; ?>
                                    <?php if ($front_description) : ?>
                                        <p class="<?php echo $front_description_color; ?>"><?php echo $front_description; ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="flip-card-back p-4 bg-white rounded" role="contentinfo" aria-label="<?php echo esc_attr($back_heading); ?>">
                                    <?php if ($back_heading) : ?>
                                        <h3><?php echo $back_heading; ?></h3>
                                    <?php endif; ?>
                                    <?php if ($back_description) : ?>
                                        <p><?php echo $back_description; ?></p>
                                    <?php endif; ?>
                                    <?php if ($back_image) : ?>
                                        <img src="<?php echo esc_url($back_image['url']); ?>" alt="<?php echo esc_attr($back_image['alt']); ?>" class="img-fluid mt-3">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <!-- End Flip Card Repeater -->

        <?php if ($section_cta_button) : ?>
            <div class="cta-button-container text-center pt-3">
                <a href="<?php echo esc_url($section_cta_button['url']); ?>" class="btn btn-primary mt-3"><?php echo $section_cta_button['title']; ?></a>
            </div>
        <?php endif; ?>
    </div>
</section>