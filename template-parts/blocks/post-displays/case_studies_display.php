<?php
/**
 * Case Studies Display Block
 */

$section_heading = get_field('section_heading');
$description = get_field('description');
$vertical_padding = get_field('vertical_padding') ?: '';
?>

<?php
// Get background image from ACF or use default
$background_image = get_field('background_image') ? get_field('background_image') : '';
$background_image_url = $background_image ? (is_array($background_image) ? $background_image['url'] : $background_image) : '';
?>
<section class="component--case-studies-slider <?php echo esc_attr($vertical_padding); ?>">
    <div class="section-header container text-center pb-3">
        <?php if ($section_heading): ?>
            <h2 class="section-title text-secondary mb-0 lh-1"><?php echo $section_heading; ?></h2>
        <?php endif; ?>
        <?php if ($description): ?>
            <p class="py-3"><?php echo $description; ?></p>
        <?php endif; ?>
    </div>

    <div class="case-studies-slider-wrapper" 
         <?php if ($background_image_url): ?>
         style="background-image: url('<?php echo esc_url($background_image_url); ?>');"
         <?php endif; ?>>
        <div class="container pb-5 position-relative">
        <div class="row overflow-hidden">
            <div class="col-12">
                <div class="swiper case-studies-swiper">
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
                                'update_post_meta_cache' => true, // Need meta cache for thumbnails
                                'update_post_term_cache' => true, // Need term cache for industry terms
                            ]);
                            $case_posts = $case_query->posts;
                            wp_reset_postdata();
                            set_transient($transient_key, $case_posts, HOUR_IN_SECONDS);
                        }

                        if (! empty($case_posts)) :
                            global $post;
                            $card_index = 0;
                            foreach ($case_posts as $cached_post) :
                                $post = $cached_post;
                                setup_postdata($post);
                                
                                $thumb = get_the_post_thumbnail_url($post->ID, 'large');
                                $excerpt = has_excerpt($post->ID) ? get_the_excerpt($post->ID) : wp_trim_words(strip_tags(get_post_field('post_content', $post->ID)), 25, '…');
                                $industry = wp_get_post_terms($post->ID, 'industry');
                                $industry_name = $industry && !is_wp_error($industry) ? $industry[0]->name : '';
                                $industry_link = $industry && !is_wp_error($industry) ? get_term_link($industry[0]) : '';
                                
                                // Alternate card colors - cycle through secondary, cyan, teal, and dk-gray
                                $color_variations = ['card-color-1', 'card-color-2', 'card-color-3', 'card-color-4'];
                                $card_color_class = $color_variations[$card_index % 4];
                                $card_index++;
                        ?>
                               <div class="swiper-slide case-study-slide">
                                <div class="case-study-card case-study-card-overlay <?php echo esc_attr($card_color_class); ?> d-flex flex-column overflow-hidden position-relative">

                                    <?php if ($thumb): ?>
                                        <div class="case-image-wrapper">
                                            <div class="case-image" 
                                                style="background-image:url('<?php echo esc_url($thumb); ?>');
                                                    background-size:contain;
                                                    background-position:center top;
                                                    background-repeat: no-repeat;">
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="case-study-content d-flex flex-column">

                                        <p class="case-study-testimonial text-white mb-3">
                                            <?php echo esc_html($excerpt); ?>
                                        </p>
                                        <div class="case-study-read-more mb-3">
                                            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="btn btn-primary text-white">
                                                <?php esc_html_e('Read More', 'mediafast'); ?>
                                            </a>
                                        </div>

                                        <div class="case-study-divider mb-2"></div>

                                        <?php if ($industry_name): ?>
                                            <div class="case-study-industry text-white text-uppercase fw-bold">
                                                <?php echo esc_html($industry_name); ?>
                                            </div>
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
                    <div class="swiper-pagination case-studies-swiper-pagination mt-75 d-flex justify-content-center"></div>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>
