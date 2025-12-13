<?php

$heading = get_field('heading') ? get_field('heading') : '';
$subheading = get_field('subheading') ? get_field('subheading') : '';

?>

<!-- start section -->
<section class="component--sliding-cards bg-very-light-gray overflow-hidden py-75">
    <div class="container">
        <div class="row justify-content-center mb-2">
            <div class="col-lg-11 text-center" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <span class="fs-17 d-inline-block fw-500 text-uppercase text-base-color ls-1px"><?php echo $subheading; ?></span>
                <h2 class="alt-font text-dark-gray fw-600 ls-minus-1px"><?php echo $heading; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 position-relative">
                <div class="outside-box-right-50 md-outside-box-right-70 sm-outside-box-right-0" data-anime='{ "translateX": [100, 0], "opacity": [0,1], "duration": 800, "delay": 100, "staggervalue": 250, "easing": "easeOutQuad" }'>
                    <div class="swiper ps-30px pe-30px sm-ps-0 sm-pe-0" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 35, "loop": true, "autoplay": { "delay": 6000, "disableOnInteraction": false }, "speed": 1500, "pagination": { "el": ".slider-four-slide-pagination-1", "clickable": true, "dynamicBullets": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 3 }, "992": { "slidesPerView": 2, "spaceBetween": 50 }, "768": { "slidesPerView": 2, "spaceBetween": 40 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
                        <div class="swiper-wrapper pt-30px pb-30px">
                            <!-- start slider item -->
                            <?php
                            if (have_rows('card_repeater')) :

                                while (have_rows('card_repeater')) : the_row();
                                    $image = get_sub_field('image') ? get_sub_field('image') : '';
                                    $icon = get_sub_field('icon') ? get_sub_field('icon') : '';
                                    $card_heading = get_sub_field('card_heading');
                                    $card_description = get_sub_field('card_description');

                            ?>
                                    <div class="swiper-slide">
                                        <div class="row g-0 services-box-style-02 bg-white" style="min-height: 300px;">
                                            <div class="col-sm-6 services-box bg-white p-10 xxl-p-8 box-shadow-extra-large">
                                                <div class="services-box-icon">
                                                    <i class="<?php echo esc_attr($icon); ?> icon-extra-large text-base-color mb-25px"></i>
                                                </div>
                                                <div class="services-box-content h-100 d-flex flex-column justify-content-stretch">
                                                    <h3 class="d-inline-block alt-font text-dark-gray fs-22 md-fs-20 fw-500"><?php echo $card_heading; ?></h3>
                                                    <p class="sm-mb-15px"><?php echo $card_description; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 services-box-img xs-h-300px border">
                                                <div class="h-100 cover-background" style="background-image: url(<?php echo $image['url']; ?>)"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end slider item -->
                            <?php
                                endwhile;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <!-- start slider pagination -->
                <!--<div class="swiper-pagination slider-four-slide-pagination-1 swiper-pagination-style-2 swiper-pagination-clickable swiper-pagination-bullets"></div>-->
                <!-- end slider pagination -->
            </div>
        </div>
    </div>
</section>
<!-- end section -->