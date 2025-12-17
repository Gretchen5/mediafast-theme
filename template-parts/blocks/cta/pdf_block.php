<?php
// ACF Fields
$pdf_intro = get_field('pdf_intro') ?: '';
$pdf_link = get_field('pdf_link');
$pdf_link_2 = get_field('pdf_link_2');
$pdf_overlay = get_field('pdf_overlay') ?: '';
?>

<?php if (!empty($pdf_link) && is_array($pdf_link)): ?>
    <div class="container pdf-section <?php echo esc_attr($pdf_overlay); ?>">
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

                <!-- CTA Buttons -->
                <div class="col-12 col-lg-4 text-center pdf-block-card__buttons">
                    <a href="<?php echo esc_url($pdf_link['url']); ?>" 
                       target="<?php echo esc_attr($pdf_link['target']); ?>"
                       class="btn btn-primary pdf-block-card__button">
                        <?php echo esc_html($pdf_link['title']); ?>
                    </a>
                    <?php if ($pdf_link_2 && is_array($pdf_link_2)) : ?>
                        <a href="<?php echo esc_url($pdf_link_2['url']); ?>" 
                           target="<?php echo esc_attr($pdf_link_2['target']); ?>"
                           class="btn btn-primary pdf-block-card__button mt-3">
                            <?php echo esc_html($pdf_link_2['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
