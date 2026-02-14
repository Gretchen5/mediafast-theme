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
        <?php
        // Count total cards for dynamic layout
        $card_count = 0;
        if (have_rows('card_repeater')) {
            $card_count = count(get_field('card_repeater'));
        }
        
        // Determine column classes based on card count
        // 5 cards: 3 on top, 2 on bottom (use col-lg-4 for 3 columns)
        // 8 cards: 4 on top, 4 on bottom (use col-lg-3 for 4 columns)
        // Default: responsive columns
        $col_class = 'col-12 col-md-6 col-lg-4'; // Default 3 columns on large screens
        if ($card_count === 8) {
            $col_class = 'col-12 col-md-6 col-lg-3'; // 4 columns for 8 cards
        } elseif ($card_count === 5) {
            $col_class = 'col-12 col-md-6 col-lg-4'; // 3 columns for 5 cards
        }
        
        // Add class to container for CSS targeting
        $container_class = 'circle-cards-container';
        if ($card_count === 5) {
            $container_class .= ' circle-cards-5';
        } elseif ($card_count === 8) {
            $container_class .= ' circle-cards-8';
        }
        ?>
        <div class="row gap-2 justify-content-center <?php echo esc_attr($container_class); ?>">
            <?php
            if (have_rows('card_repeater')) :
                $card_index = 0;
                while (have_rows('card_repeater')) : the_row();
                    $card_index++;
                    $card_heading = get_sub_field('card_heading');
                    $card_heading_link = get_sub_field('card_heading_link');
                    $card_description = get_sub_field('card_description');
                    $card_background_color = get_sub_field('card_background_color');

            ?>
                    <div class="<?php echo esc_attr($col_class); ?> card-col card-col-circle d-flex justify-content-center align-items-stretch px-0">
                        <div class="card circle-card shadow <?php echo $card_border . ' ' . $card_background_color; ?> p-2 d-flex flex-column justify-content-center align-items-center">
                            <div class="card-body d-flex flex-column align-items-center justify-content-stretch">
                                <?php if ($card_heading_link) : ?>
                                    <h3 class="card-title text-center"><a class="<?php echo $card_heading_color; ?> circle-card-heading-link" href="<?php echo esc_url($card_heading_link['url']); ?>" target="<?php echo $card_heading_link['target']; ?>"><?php echo $card_heading_link['title']; ?></a></h3>
                                <?php else: ?>
                                    <h3 class="card-title text-center <?php echo $card_heading_color; ?>"><?php echo $card_heading; ?></h3>
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