<?php
/**
 * Case Studies Display Block
 */

$section_heading = get_field('section_heading');
$description = get_field('description');
$vertical_padding = get_field('vertical_padding') ?: '';
?>

<section class="component--case-studies-slider bg-lt-gray <?php echo esc_attr($vertical_padding); ?>">
    <div class="section-header container text-center pb-3">
        <?php if ($section_heading): ?>
            <h2 class="section-title text-secondary mb-0 lh-1"><?php echo $section_heading; ?></h2>
        <?php endif; ?>
        <?php if ($description): ?>
            <p class="py-3"><?php echo $description; ?></p>
        <?php endif; ?>
    </div>

    <div class="container-fluid pb-5">
        <div class="row overflow-hidden">
            <div class="col-12">
                <div class="swiper" data-slider-options='{
                    "loop": true,
                    "spaceBetween": 30,
                    "autoplay": { "delay": 4000, "disableOnInteraction": false },
                    "pagination": { "el": ".swiper-pagination", "clickable": true },
                    "navigation": { "nextEl": ".slider-next", "prevEl": ".slider-prev" },
                    "keyboard": { "enabled": true },
                    "breakpoints": {
                        "320":  { "slidesPerView": 1 },
                        "576":  { "slidesPerView": 1 },
                        "768":  { "slidesPerView": 2 },
                        "992":  { "slidesPerView": 3 },
                        "1200": { "slidesPerView": 3 }
                    }
                }'>
                    <div class="swiper-wrapper text-center pb-5">

                        <?php
                        $transient_key = 'mediafast_case_studies_slider';
                        $case_posts    = get_transient($transient_key);

                        if (false === $case_posts) {
                            $case_query = new WP_Query([
                                'post_type'              => 'case-study',
                                'posts_per_page'         => 20,
                                'orderby'                => 'rand',
                                'no_found_rows'          => true,
                                'update_post_meta_cache' => false,
                            ]);
                            $case_posts = $case_query->posts;
                            wp_reset_postdata();
                            set_transient($transient_key, $case_posts, HOUR_IN_SECONDS);
                        }

                        if (! empty($case_posts)) :
                            foreach ($case_posts as $post) :
                                setup_postdata($post);
                                $thumb = get_the_post_thumbnail_url($post->ID, 'large');
                                $excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(strip_tags(get_the_content()), 25, '…');
                                $industry = wp_get_post_terms($post->ID, 'industry');
                                $industry_name = $industry ? $industry[0]->name : '';
                                $industry_link = $industry ? get_term_link($industry[0]) : '';
                        ?>
                               <div class="swiper-slide case-study-slide">
                                <div class="case-study-card bg-white border-radius-6px shadow h-100 d-flex flex-column overflow-hidden">

                                    <?php if ($thumb): ?>
                                        <div class="case-image" 
                                            style="background-image:url('<?php echo esc_url($thumb); ?>');
                                                background-size:contain;
                                                background-position:center top;
                                                height:250px;
                                                background-repeat: no-repeat;">
                                                
                                        </div>
                                    <?php endif; ?>

                                    <div class="p-4 d-flex flex-column flex-grow-1">

                                        <h3 class="fs-5 fw-600 text-dark mb-2"><?php the_title(); ?></h3>

                                        <p class="text-muted flex-grow-1 mb-3">
                                            <?php echo esc_html($excerpt); ?>
                                        </p>

                                        <?php if ($industry_name): ?>
                                            <a href="<?php echo esc_url($industry_link); ?>" 
                                            class="btn btn-primary text-white mb-2 mx-auto">
                                                <?php echo esc_html($industry_name); ?>
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>

                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>

                    </div>
                    <div class="swiper-pagination mt-75 d-flex justify-content-center"></div>
                </div>
            </div>
        </div>
    </div>
</section>
