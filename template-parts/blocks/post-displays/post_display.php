<?php
$section_heading = get_field('section_heading');
$cta_button = get_field('cta_button') ?: '';
$background_color = get_field('background_color');
$section_padding_top = get_field('section_padding_top') ?: '';
$section_padding_bottom = get_field('section_padding_bottom') ?: '';

?>

<!-- start section -->
<section class="component--recent-posts py-75 <?php echo esc_attr($background_color); ?>" style="padding-top: <?php echo esc_attr($section_padding_top); ?>; padding-bottom: <?php echo esc_attr($section_padding_bottom); ?>;">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <span class="fs-17 d-inline-block fw-500 text-uppercase text-base-color ls-1px">Best Practices, Testimonials, Case Studies and Videos</span>
                <h2 class="alt-font text-secondary fw-600 ls-minus-1px mb-0"><?php echo $section_heading; ?></h2>
            </div>
        </div>
        <?php

        $args = array(
            'post_type'      => 'post',  // Only pull blog posts
            'posts_per_page' => 3,       // Show 3 most recent posts
            'orderby'        => 'date',  // Order by newest first
            'order'          => 'DESC'
        );

        $category = get_field('post_category');
        if ($category) {
            $args['tax_query'] = array(array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $category
            ));
        }





        $recent_posts = new WP_Query($args);


        if ($recent_posts->have_posts()) : ?>
            <div class="row">
                <div class="col-12">
                    <ul class="blog-simple blog-wrapper grid-loading grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large" data-anime='{ "el": "childs", "willchange": "transform", "translateY": [30, 0], "perspective": [1200,1200], "scale": [1.05, 1], "rotateY": [-30, 0], "opacity": [0,1], "duration": 800, "delay": 100, "staggervalue": 200, "easing": "easeOutQuad" }'>
                        <li class="grid-sizer"></li>
                        <?php while ($recent_posts->have_posts()) : $recent_posts->the_post();

                            $excerpt = get_the_content();
                            $trimmed_excerpt = wp_trim_words($excerpt, 7, '...'); // Trim based on word count
                            $char_limit = 45; // Define the desired character length

                            if (strlen($trimmed_excerpt) > $char_limit) {
                                $trimmed_excerpt = substr($trimmed_excerpt, 0, $char_limit) . '...'; // Trimming by character length
                            }
                        ?>
                            <!-- start blog item -->
                            <li class="grid-item">

                                <figure class="position-relative mb-0 box-hover">

                                    <div class="blog-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="post-featured-image">
                                                <figure class="mb-0">
                                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-display-thumbnail'); ?></a>
                                                    <div class="bg-secondary dark-section-post-display"></div>
                                                </figure>
                                            </div>
                                        <?php endif; ?>

                                        <span class="box-overlay bg-dark-slate-blue"></span>
                                        <span class="bg-gradient-gray-light-dark-transparent position-absolute opacity-4 top-0px left-0px w-100 h-100"></span>
                                    </div>

                                    <figcaption class="d-flex flex-column h-100 justify-content-end">
                                        <div class="position-relative post-content p-11 text-center last-paragraph-no-margin">
                                            <div class="position-relative z-index-2 overflow-hidden">
                                                <div class="d-inline-block fs-16 mb-5px text-base-color text-uppercase fw-500"><?php echo get_the_date('F j, Y'); ?></div>
                                                <a href="<?php the_permalink(); ?>" class="card-title fs-22 alt-font fw-400 text-white mb-0 d-block text-decoration-none">
                                                    <h3 class="h5 alt-font fw-600 text-white"><?php the_title(); ?></h3>
                                                </a>
                                                <div class="hover-text"><a href="<?php the_permalink(); ?>" class="btn btn-link-gradient btn-large text-white thin mt-20px mb-5px fw-400">Continue reading<span class="bg-white"></span></a></div>
                                            </div>
                                            <div class="box-overlay bg-dark-gray"></div>
                                        </div>
                                    </figcaption>
                                </figure>

                            </li>
                        <?php endwhile; ?>
                        <!-- end blog item -->

                    </ul>
                </div>
            </div>
        <?php else : ?>
            <p>No posts available.</p>
        <?php endif;
        wp_reset_postdata();
        ?>
    </div>
</section>
<!-- end section -->