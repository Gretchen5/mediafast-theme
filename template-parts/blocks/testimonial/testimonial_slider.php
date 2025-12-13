<?php
$section_heading      = get_field('section_heading');
$description          = get_field('description');
$quote_icon           = get_field('quote_icon');
$section_cta_button   = get_field('section_cta_button');

$args = array(
    'post_type'      => 'testimonial',
    'posts_per_page' => -1,
    'post_status'    => 'publish'
);
$testimonials = new WP_Query($args);

if ($testimonials->have_posts()) : ?>
<section class="component--testimonial-slider-section">

    <div class="container py-5 position-relative">

        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="section-title"><?php echo $section_heading; ?></h2>
            <p><?php echo $description; ?></p>
        </div>

        <!-- Swiper -->
        <div class="swiper testimonial-swiper pb-75">
            <div class="swiper-wrapper">

                <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                <div class="swiper-slide testimonial-swiper-slide">

                    <div class="testimonial-card p-4 d-flex flex-column align-items-center text-center">

                        <!-- Stars -->
                        <div class="testimonial-stars mb-3">⭐⭐⭐⭐⭐
                        </div>

                        <!-- Quote icon -->
                        <?php if ($quote_icon) : ?>
                        <div class="testimonial-quote-icon mb-3">
                            <img src="<?php echo esc_url($quote_icon['url']); ?>"
                                 alt="<?php echo esc_attr($quote_icon['alt']); ?>">
                        </div>
                        <?php endif; ?>

                        <!-- Headshot -->
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="testimonial-headshot mb-3">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                        <?php endif; ?>

                        <h3 class="h5 py-3 text-body"><?php the_title(); ?></h3>

                        <p class="">
                            <?php echo wp_trim_words(get_the_content(), 40, '...'); ?>
                        </p>

                    </div>

                </div>
                <?php endwhile; ?>

            </div>

            <!-- Localized Navigation -->
            <div class="testimonial-swiper-button-prev swiper-button-prev"></div>
            <div class="testimonial-swiper-button-next swiper-button-next"></div>

            <!-- Localized Pagination -->
            <div class="testimonial-swiper-pagination swiper-pagination mt-75"></div>

        </div>

        <!-- CTA -->
        <?php if ($section_cta_button) : ?>
        <div class="text-center mt-4">
            <a href="<?php echo esc_url($section_cta_button['url']); ?>"
               class="btn btn-primary">
               <?php echo $section_cta_button['title']; ?>
            </a>
        </div>
        <?php endif; ?>

    </div>
</section>
<?php endif;
wp_reset_postdata(); ?>
