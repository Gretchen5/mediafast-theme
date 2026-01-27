<?php
// ACF Fields
$cards = get_field('card_repeater');
$pdf_intro = get_field('pdf_intro') ?: '';
$pdf_link = get_field('pdf_link');
$number_of_cards = get_field('number_of_cards') ?: 'row-cols-lg-4';

// Dynamic padding class based on PDF Guide presence
$padding_class = (!empty($pdf_link) && is_array($pdf_link)) ? 'py-75' : 'py-5';
?>

<!-- Cards Side by Side Section -->
<section class="component--cards-side-by-side bg-very-light-gray <?php echo esc_attr($padding_class); ?>">
    <?php if (!empty($pdf_link) && is_array($pdf_link)): ?>
        <div class="container pdf-section">
            <div class="pdf-block-card">
                <!-- Vertical PDF Guide Label -->
                <div class="pdf-block-card__label">
                    <span class="pdf-block-card__label-text">PDF GUIDE</span>
                </div>

                <div class="row g-0 align-items-center">
                    <!-- Rocket Icon -->
                    <div class="col-12 col-lg-2 text-center pdf-block-card__icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rocket-icon.svg" alt="Rocket icon" class="img-fluid">
                    </div>

                    <!-- Text Content -->
                    <div class="col-12 col-lg-6 text-center text-lg-start pdf-block-card__content">
                        <p class="pdf-block-card__text mb-0"><?php echo wp_kses_post($pdf_intro); ?></p>
                    </div>

                    <!-- CTA Button -->
                    <div class="col-12 col-lg-4 text-center pdf-block-card__buttons">
                        <a href="<?php echo esc_url($pdf_link['url']); ?>" 
                           target="<?php echo esc_attr($pdf_link['target']); ?>"
                           class="btn btn-primary pdf-block-card__button">
                            <?php echo esc_html($pdf_link['title']); ?>
                        </a>
                    </div>
                </div>
            </div>
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
