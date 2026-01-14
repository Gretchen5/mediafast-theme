<?php
// ACF Fields
$section_heading = get_field('section_heading');
$description = get_field('description');
$heading_color = get_field('heading_color') ?: 'text-secondary';
$text_color = get_field('text_color') ?: 'text-body';
$vertical_padding = get_field('vertical_padding') ?: '';
$images = get_field('image_slider');
?>

<!-- Image Slider Section -->
<section class="component--image-slider-section bg-lt-gray <?php echo esc_attr($vertical_padding); ?>">
    <?php if ($section_heading || $description) : ?>
        <div class="container text-center">
            <?php if ($section_heading) : ?>
                <h2 class="section-title pb-2 <?php echo esc_attr($heading_color); ?> mb-0 lh-1">
                    <?php echo wp_kses_post($section_heading); ?>
                </h2>
            <?php endif; ?>
            <?php if ($description) : ?>
                <p class="<?php echo esc_attr($text_color); ?> mb-0">
                    <?php echo wp_kses_post($description); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>

<?php if ($images && is_array($images)) : ?>
    <section class="bg-lt-gray pb-4">
        <div class="container-fluid">
            <div class="row overflow-hidden">
                <div class="col-12">
                    <div class="image-slider-wrapper px-3 px-md-5">
                        <div class="swiper image-slider">
                            <div class="swiper-wrapper">
                                <?php foreach ($images as $image) : ?>
                                    <div class="swiper-slide">
                                        <div class="image-swiper-slide">
                                            <img 
                                                src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt'] ?: 'Slider image'); ?>"
                                                class="img-fluid bg-white"
                                                loading="lazy"
                                            >
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="swiper-pagination"></div>
                            
                            <!-- Navigation -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
