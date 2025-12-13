<?php

$section_heading = get_field('section_heading');
$description = get_field('description');
$quote_icon = get_field('quote_icon');
$section_cta_button = get_field('section_cta_button') ? get_field('section_cta_button') : '';

$args = array(
    'post_type'      => 'testimonial',
    'posts_per_page' => -1,
    'post_status'    => 'publish'
);
$testimonials = new WP_Query($args);

if ($testimonials->have_posts()) : ?>
    <section class="component--testimonial-slider-section">
        <div class="container position-relative z-index-1 py-75">
            <div class="section-header text-center mb-4">
                <h2 class="section-title"><?php echo esc_html($section_heading); ?></h2>
                <p><?php echo $description; ?></p>
            </div>
            <div class="swiper testimonial-slider">
                <div class="swiper-wrapper">
                    <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                        <div class="swiper-slide swiper-testimonial">
                            <div class="testimonial-card p-4 bg-light rounded shadow-sm h-100 d-flex flex-column align-items-center justify-content-stretch mb-4">
                                <div class="review-star-icon fs-18 lh-24">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                                <div class="testimonial-icon mb-3">
                                    <?php if ($quote_icon) : ?>
                                        <img src="<?php echo esc_url($quote_icon['url']); ?>" alt="<?php echo esc_attr($quote_icon['alt']); ?>" class="img-fluid" />
                                    <?php endif; ?>
                                </div>
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="testimonial-image mb-3 text-center">
                                        <?php the_post_thumbnail('small', ['class' => 'rounded-circle bg-white shadow']); ?>
                                    </div>
                                <?php endif; ?>
                                <h3 class="h5 mb-2 text-center"><?php the_title(); ?></h3>
                                <p class="mb-0"><?php echo wp_trim_words(get_the_content(), 40, '...'); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Optional navigation -->
                <div class="swiper-button-prev swiper-testimonial"></div>
                <div class="swiper-button-next swiper-testimonial"></div>
                <div class="swiper-pagination swiper-testimonial"></div>
                <div class="swiper-scrollbar swiper-testimonial"></div>
            </div>
            <?php if ($section_cta_button) : ?>
                <div class="cta-button-container text-center pt-3">
                    <a href="<?php echo esc_url($section_cta_button['url']); ?>" class="btn btn-primary mt-3"><?php echo $section_cta_button['title']; ?></a>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif;
wp_reset_postdata();
