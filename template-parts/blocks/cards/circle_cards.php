<?php
$section_heading = get_field('section_heading') ? get_field('section_heading') : '';
$section_subheading = get_field('section_subheading') ? get_field('section_subheading') : '';
$section_description = get_field('section_description') ? get_field('section_description') : '';
$cards = get_field('card_repeater');
$card_border = get_field('card_border') ? get_field('card_border') : '';
$card_heading_color = get_field('card_heading_color') ? get_field('card_heading_color') : '';
$card_hr = get_field('card_hr') ? get_field('card_hr') : '';
$padding = get_field('padding');
?>

<section class="component--cards <?php echo esc_attr($padding); ?>">
    <div class="container">
        <?php if ($section_heading) : ?>
            <h2 class="text-center mb-4"><?php echo $section_heading; ?></h2>
        <?php endif; ?>
        <?php if ($section_subheading) : ?>
            <h3 class="text-center mb-4"><?php echo $section_subheading; ?></h3>
        <?php endif; ?>
        <?php if ($section_description) : ?>
            <?php echo $section_description; ?>
        <?php endif; ?>
        <div class="row g-4 justify-content-center">
            <?php
            if (have_rows('card_repeater')) :

                while (have_rows('card_repeater')) : the_row();
                    $card_heading = get_sub_field('card_heading');
                    $card_heading_link = get_sub_field('card_heading_link');
                    $card_description = get_sub_field('card_description');
                    $card_background_color = get_sub_field('card_background_color');

            ?>
                    <div class="col card-col card-col-circle">
                        <div class="card circle-card shadow <?php echo $card_border . ' ' . $card_background_color; ?> p-4 d-flex flex-column justify-content-center align-items-center">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <?php if ($card_heading_link) : ?>
                                    <h3 class="card-title text-center"><a class="<?php echo $card_heading_color; ?> circle-card-heading-link" href="<?php echo esc_url($card_heading_link['url']); ?>" target="<?php echo $card_heading_link['target']; ?>"><?php echo $card_heading_link['title']; ?></a></h3>
                                <?php else: ?>
                                    <h3 class="card-title text-center <?php echo $card_heading_color; ?>"><?php echo $card_heading; ?></h3>
                                <?php endif; ?>
                                <?php if ($card_hr) : ?>
                                    <hr class="<?php echo $card_hr; ?> w-75">
                                <?php endif; ?>
                                <div class="description-container">
                                    <?php if ($card_description) : ?>
                                        <p class="<?php echo $card_heading_color; ?> text-center"><?php echo $card_description; ?></p>
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
</section>