<?php
// ACF Fields
$section_heading = get_field('section_heading');
$cta_button = get_field('cta_button') ?: '';
$background_color = get_field('background_color');
$section_padding_top = get_field('section_padding_top') ?: '';
$section_padding_bottom = get_field('section_padding_bottom') ?: '';

// Build WP_Query args
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC'
);

// Filter by category if selected
$category = get_field('post_category');
if ($category) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $category
        )
    );
}

$recent_posts = new WP_Query($args);
?>

<!-- Post Display Section -->
<section class="component--recent-posts py-75 <?php echo esc_attr($background_color); ?>" 
         style="padding-top: <?php echo esc_attr($section_padding_top); ?>; padding-bottom: <?php echo esc_attr($section_padding_bottom); ?>;">
    <div class="container">
        <!-- Section Header -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">
                <span class="fs-17 d-inline-block fw-500 text-uppercase text-dk-gold ls-1px mb-2">
                    Best Practices, Testimonials, Case Studies and Videos
                </span>
                <?php if ($section_heading) : ?>
                    <h2 class="text-secondary fw-600 mb-0"><?php echo esc_html($section_heading); ?></h2>
                <?php endif; ?>
            </div>
        </div>

        <!-- Blog Posts Grid -->
        <?php if ($recent_posts->have_posts()) : ?>
            <div class="row g-4 g-lg-4">
                <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                    <div class="col-12 col-lg-4">
                        <article class="post-display-card h-100" data-animate>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-display-card__image">
                                    <a href="<?php the_permalink(); ?>" class="d-block">
                                        <?php the_post_thumbnail('post-display-thumbnail', array(
                                            'class' => 'img-fluid w-100',
                                            'loading' => 'lazy'
                                        )); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-display-card__content">
                                <div class="post-display-card__date has-lt-gold-text-color text-uppercase fw-500 mb-2">
                                    <?php echo get_the_date('F j, Y'); ?>
                                </div>
                                <h3 class="post-display-card__title h5 mb-3">
                                    <a href="<?php the_permalink(); ?>" class="text-white text-decoration-none">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <a href="<?php the_permalink(); ?>" class="post-display-card__link btn btn-link text-white p-0">
                                    Continue reading
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-center">No posts available.</p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
