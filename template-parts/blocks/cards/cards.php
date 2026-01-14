<?php
$section_heading = get_field('section_heading') ? get_field('section_heading') : '';
$section_subheading = get_field('section_subheading') ? get_field('section_subheading') : '';
$section_heading_color = get_field('section_heading_color') ? get_field('section_heading_color') : '';
$section_subheading_color = get_field('section_subheading_color') ? get_field('section_subheading_color') : '';
$section_description = get_field('section_description') ? get_field('section_description') : '';
$vertical_padding = get_field('vertical_padding') ? get_field('vertical_padding') : '';

$section_cta_button = get_field('section_cta_button') ? get_field('section_cta_button') : '';
$cards = get_field('card_repeater');
$card_cta_button_color = get_field('card_cta_button_color') ? get_field('card_cta_button_color') : '';
$card_border = get_field('card_border') ? get_field('card_border') : '';
$card_heading_color = get_field('card_heading_color') ? get_field('card_heading_color') : '';
$card_subheading_color = get_field('card_subheading_color') ? get_field('card_subheading_color') : '';
$card_heading_padding_top = get_field('card_heading_padding-top') ? get_field('card_heading_padding_top') : '';
$card_heading_padding_bottom = get_field('card_heading_padding-bottom') ? get_field('card_heading_padding_bottom') : '';
$card_hr = get_field('card_hr') ? get_field('card_hr') : '';
?>

<section class="component--cards <?php echo esc_attr($vertical_padding); ?>">
    <div class="container">
        <?php if ($section_heading) : ?>
            <h2 class="text-center mb-4 <?php echo esc_attr($section_heading_color); ?>"><?php echo $section_heading; ?></h2>
        <?php endif; ?>
        <?php if ($section_subheading) : ?>
            <p class="text-center mb-4 fw-600 fs-20 <?php echo esc_attr($section_subheading_color); ?>"><?php echo $section_subheading; ?></p>
        <?php endif; ?>
        <?php if ($section_description) : ?>
            <div class="my-4"><?php echo $section_description; ?></div>
        <?php endif; ?>
        <div class="row g-4 pt-4 justify-content-center">
            <?php
            if (have_rows('card_repeater')) :

                while (have_rows('card_repeater')) : the_row();
                    $card_image = get_sub_field('card_image') ? get_sub_field('card_image') : '';
                    $card_icon = get_sub_field('card_icon') ? get_sub_field('card_icon') : '';
                    $card_heading = get_sub_field('card_heading');
                    $card_subheading = get_sub_field('card_subheading');
                    $card_description = get_sub_field('card_description');
                    $card_background_color = get_sub_field('card_background_color');
                    $card_cta_button = get_sub_field('card_cta_button') ? get_sub_field('card_cta_button') : '';
                    $card_icon_color = get_sub_field('card_icon_color') ? get_sub_field('card_icon_color') : '';

            ?>
                    <div class="col-10 col-md-6 col-lg-4 card-col">
                        <div class="card shadow <?php echo $card_border . ' ' . $card_background_color; ?> h-100 border-radius-40 px-3">
                            <?php if ($card_image) : ?>
                                <img src="<?php echo esc_url($card_image['url']); ?>" class="card-img-top p-3" alt="<?php echo esc_attr($card_image['alt']); ?>">
                            <?php elseif ($card_icon) : ?>
                                <div class="card-icon text-center p-3 <?php echo $card_icon_color; ?>">
                                    <?php echo get_inline_icon($card_icon); ?>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column justify-content-start px-2">
                                <?php if ($card_heading) : ?>
                                    <h3 class="card-title text-center <?php echo $card_heading_color . ' ' . $card_heading_padding_top . ' ' . $card_heading_padding_bottom; ?>"><?php echo $card_heading; ?></h3>
                                <?php endif; ?>
                                <?php if ($card_subheading) : ?>
                                    <h4 class="card-subtitle mb-2 text-center <?php echo esc_attr($card_subheading_color); ?>"><?php echo $card_subheading; ?></h4>
                                <?php endif; ?>
                                <?php if ($card_hr) : ?>
                                    <hr class="<?php echo $card_hr; ?>">
                                <?php endif; ?>
                                <div class="description-button-container d-flex flex-column flex-grow-1 justify-content-between">
                                    <?php if ($card_description) : ?>
                                        <?php echo $card_description; ?>
                                    <?php endif; ?>
                                    <?php if ($card_cta_button) : ?>
                                        <div class="button-container text-center">
                                            <a href="<?php echo esc_url($card_cta_button['url']); ?>" class="btn <?php echo esc_attr($card_cta_button_color); ?> my-3"><?php echo $card_cta_button['title']; ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
        <?php if ($section_cta_button) : ?>
            <div class="cta-button-container text-center pt-3">
                <a href="<?php echo esc_url($section_cta_button['url']); ?>" class="btn btn-primary mt-3"><?php echo $section_cta_button['title']; ?></a>
            </div>
        <?php endif; ?>
    </div>
</section>