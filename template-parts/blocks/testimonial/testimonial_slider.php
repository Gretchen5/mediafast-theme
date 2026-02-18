<?php
$section_heading      = get_field('section_heading');
$description          = get_field('description');
$quote_icon           = get_field('quote_icon');
$section_cta_button   = get_field('section_cta_button');

$transient_key = 'mediafast_testimonials_slider';
$posts        = get_transient($transient_key);

if (false === $posts) {
	$query = new WP_Query([
		'post_type'              => 'testimonial',
		'posts_per_page'         => 50,
		'post_status'            => 'publish',
		'no_found_rows'          => true,
		'update_post_meta_cache' => true, // Need meta cache for thumbnails
		'update_post_term_cache' => false,
	]);
	$posts = $query->posts;
	wp_reset_postdata();
	set_transient($transient_key, $posts, HOUR_IN_SECONDS);
}

if (! empty($posts)) : ?>
<section class="component--testimonial-slider-section">

    <div class="container py-5 position-relative">

        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="section-title"><?php echo $section_heading; ?></h2>
            <p><?php echo $description; ?></p>
        </div>

        <!-- Swiper -->
        <div class="swiper testimonial-swiper pb-5">
            <div class="swiper-wrapper">

                <?php 
                global $post;
                foreach ($posts as $cached_post) : 
                    $post = $cached_post;
                    setup_postdata($post);
                    $title = get_the_title();
$label = wp_trim_words($title, 8);
                ?>
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
                        <?php if (has_post_thumbnail($post->ID)) : ?>
                        <div class="testimonial-headshot mb-3">
                            <?php echo get_the_post_thumbnail($post->ID, 'acf-medium', array('loading' => 'lazy', 'class' => 'img-fluid')); ?>
                        </div>
                        <?php endif; ?>

                        <h3 class="h5 py-3 text-body"><?php echo get_the_title($post->ID); ?></h3>

                        <p class="testimonial-excerpt">
                            <?php echo wp_trim_words(get_post_field('post_content', $post->ID), 40, '...'); ?>
                        </p>

                        <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="btn btn-primary testimonial-read-more mt-3" aria-label="Read more testimonial: <?php echo esc_attr($label); ?>">
                            View Testimonial
                        </a>

                    </div>

                </div>
                <?php endforeach; ?>

            </div>

            <!-- Localized Navigation -->
            <div class="testimonial-swiper-button-prev swiper-button-prev" aria-label="Previous testimonial" role="button" tabindex="0"></div>
            <div class="testimonial-swiper-button-next swiper-button-next" aria-label="Next testimonial" role="button" tabindex="0"></div>

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
