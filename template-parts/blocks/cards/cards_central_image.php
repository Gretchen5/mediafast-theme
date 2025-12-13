<?php
$section_heading = get_field('section_heading') ? get_field('section_heading') : '';
$section_subheading = get_field('section_subheading') ? get_field('section_subheading') : '';
$section_description = get_field('section_description') ? get_field('section_description') : '';
$central_image = get_field('central_image') ? get_field('central_image') : '';
$section_cta_button = get_field('section_cta_button') ? get_field('section_cta_button') : '';
$card_border = get_field('card_border') ? get_field('card_border') : '';
$card_heading_color = get_field('card_heading_color') ? get_field('card_heading_color') : '';
$card_heading_padding_top = get_field('card_heading_padding-top') ? get_field('card_heading_padding_top') : '';
$card_heading_padding_bottom = get_field('card_heading_padding-bottom') ? get_field('card_heading_padding_bottom') : '';
$card_hr = get_field('card_hr') ? get_field('card_hr') : '';
?>

<section class="component--cards py-5">
    <div class="container">
        <?php if ($section_heading) : ?>
            <h2 class="text-center mb-4"><?php echo $section_heading; ?></h2>
        <?php endif; ?>
        <?php if ($section_subheading) : ?>
            <h3 class="text-center mb-4"><?php echo $section_subheading; ?></h3>
        <?php endif; ?>
        <?php if ($section_description) : ?>
            <p class="text-center mb-4"><?php echo $section_description; ?></p>
        <?php endif; ?>
        <div class="row justify-content-center align-items-stretch">
            <div class="col-12 col-lg-3 d-flex flex-column gap-4">
                <?php
                if (have_rows('card_repeater')) :

                    while (have_rows('card_repeater')) : the_row();
                        $card_image = get_sub_field('card_image') ? get_sub_field('card_image') : '';
                        $card_heading = get_sub_field('card_heading');
                        $card_description = get_sub_field('card_description');
                        $card_background_color = get_sub_field('card_background_color');

                ?>
                        <div class="col">
                            <div class="card <?php echo $card_border . ' ' . $card_background_color; ?> h-100">
                                <img width="100" src="<?php echo esc_url($card_image['url']); ?>" class="p-3 mx-auto" alt="<?php echo esc_attr($card_image['alt']); ?>">
                                <div class="card-body d-flex flex-column justify-content-center text-center">
                                    <?php if ($card_heading) : ?>
                                        <h3 class="card-title text-center <?php echo $card_heading_color . ' ' . $card_heading_padding_top . ' ' . $card_heading_padding_bottom; ?>"><?php echo $card_heading; ?></h3>
                                    <?php endif; ?>

                                    <?php if ($card_hr) : ?>
                                        <hr class="<?php echo $card_hr; ?>">
                                    <?php endif; ?>
                                    <div class="description-button-container d-flex flex-column flex-grow-1 justify-content-between text-center">
                                        <?php if ($card_description) : ?>
                                            <?php echo $card_description; ?>
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
            <div class="col-12 col-lg-5 text-center my-4 d-flex flex-column justify-content-center align-items-center">
                <?php if ($central_image) : ?>
                    <img width="400" src="<?php echo esc_url($central_image['url']); ?>" class="img-fluid shadow" alt="<?php echo esc_attr($central_image['alt']); ?>">
                <?php endif; ?>
                <?php if ($section_cta_button) : ?>
                    <div class="cta-button-container text-center pt-3">
                        <a href="<?php echo esc_url($section_cta_button['url']); ?>" class="btn btn-primary mt-3"><?php echo $section_cta_button['title']; ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12 col-lg-3 d-flex flex-column gap-4">
                <?php
                if (have_rows('card_repeater_2')) :

                    while (have_rows('card_repeater_2')) : the_row();
                        $card_image = get_sub_field('card_image') ? get_sub_field('card_image') : '';
                        $card_heading = get_sub_field('card_heading');
                        $card_description = get_sub_field('card_description');
                        $card_background_color = get_sub_field('card_background_color');

                ?>
                        <div class="col">
                            <div class="card <?php echo $card_border . ' ' . $card_background_color; ?> h-100">
                                <img width="100" src="<?php echo esc_url($card_image['url']); ?>" class="p-3 mx-auto" alt="<?php echo esc_attr($card_image['alt']); ?>">
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <?php if ($card_heading) : ?>
                                        <h3 class="card-title text-center <?php echo $card_heading_color . ' ' . $card_heading_padding_top . ' ' . $card_heading_padding_bottom; ?>"><?php echo $card_heading; ?></h3>
                                    <?php endif; ?>

                                    <?php if ($card_hr) : ?>
                                        <hr class="<?php echo $card_hr; ?>">
                                    <?php endif; ?>
                                    <div class="description-button-container d-flex flex-column flex-grow-1 justify-content-between text-center">
                                        <?php if ($card_description) : ?>
                                            <?php echo $card_description; ?>
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
        </div>


    </div>
</section>