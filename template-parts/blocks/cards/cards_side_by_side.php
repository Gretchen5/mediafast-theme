<?php
// ACF Fields
$cards = get_field('card_repeater');
$pdf_link = get_field('pdf_link');
$number_of_cards = get_field('number_of_cards') ?: 'row-cols-lg-4';

?>

<!-- Cards Side by Side Section -->
<section class="component--cards-side-by-side bg-very-light-gray py-5">
    <?php if (!empty($pdf_link) && is_array($pdf_link)): ?>
        <div class="container text-center pb-5">
            <a href="<?php echo esc_url($pdf_link['url']); ?>"
               target="<?php echo esc_attr($pdf_link['target']); ?>"
               class="pdf-cta-link text-primary text-decoration-underline fw-semibold">
                <?php echo esc_html($pdf_link['title']); ?>
            </a>
        </div>
    <?php endif; ?>

    <!-- Cards Grid -->
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 justify-content-center g-4">
            <?php
            if (have_rows('card_repeater')) :
                while (have_rows('card_repeater')) : the_row();
                    $icon = get_sub_field('icon') ?: '';
                    $heading = get_sub_field('heading');
                    $description = get_sub_field('description');
            ?>
                <div class="col">
                    <article class="side-by-side-card h-100" data-animate>
                        <div class="side-by-side-card__icon-wrapper">
                            <i class="<?php echo esc_attr($icon); ?> side-by-side-card__icon"></i>
                        </div>
                        <div class="side-by-side-card__content">
                            <h2 class="side-by-side-card__heading"><?php echo wp_kses_post($heading); ?></h2>
                            <div class="side-by-side-card__description">
                                <?php echo wp_kses_post($description); ?>
                            </div>
                        </div>
                    </article>
                </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>
