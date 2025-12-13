

<!-- start banner slider -->
<section class="component--video-hero p-0 bg-dk-gray">
    <div class="swiper home-hero-swiper swiper-light-pagination swiper-pagination-style-3">
         
            <div class="swiper-wrapper">
            
            <?php if (have_rows('home_hero_slider')) :
                while (have_rows('home_hero_slider')) : the_row();
                    $slider_image = get_sub_field('slider_image') ? 'background-image:url(' . get_sub_field('slider_image') . ');' : '';
                    $heading = get_sub_field('heading');
                    $subheading = get_sub_field('subheading');
                    $cta_button_1 = get_sub_field('cta_button_1') ? get_sub_field('cta_button_1') : '';
                    $cta_button_2 = get_sub_field('cta_button_2') ? get_sub_field('cta_button_2') : '';
            ?>
                    
                    <div class="swiper-slide">
                        <div class="position-absolute left-0px top-0px w-100 h-100 cover-background no-anime" style="<?php echo $slider_image; ?>"></div>
                        <div class="opacity-extra-medium bg-gradient-black-dark-brown"></div>
                        <div class="container h-100">
                            <div class="row align-items-center h-100 justify-content-center">
                                <div class="col-12 position-relative text-white text-center">
                                    <div class="d-inline-block position-relative mb-35px" data-anime='{ "opacity": [0, 1], "easing": "easeOutCubic", "duration": 500, "delay": 200 }'>
                                        <span class="d-inline-block position-relative fw-400 text-white fs-22 mb-0"><?php echo $subheading; ?></span>
                                        <span class="h-1px opacity-3 w-100 bg-white d-inline-block transform-origin-left position-absolute bottom-0px left-0px"></span>
                                    </div>
                                    <h1 class="h1-fs-5 text-capitalize pt-4"><?php echo esc_attr($heading); ?></h1>
                                    <?php if ($cta_button_1) : ?>
                                        <div class="cta-button-container text-center pt-3 d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                                            <a href="<?php echo esc_url($cta_button_1['url']); ?>" class="btn btn-primary btn-box-shadow btn-round-edge" data-anime='{ "opacity": [0, 1], "easing": "easeOutCubic", "delay": 800, "duration": 800 }'><?php echo $cta_button_1['title']; ?></a>
                                            <?php if ($cta_button_2) : ?>
                                                <a href="<?php echo esc_url($cta_button_2['url']); ?>" class="btn btn-primary btn-box-shadow btn-round-edge mt-3 mt-md-0" data-anime='{ "opacity": [0, 1], "easing": "easeOutCubic", "delay": 800, "duration": 800 }'><?php echo $cta_button_2['title']; ?></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
            <?php endwhile;
            endif; ?>
        </div>
        <!-- start slider pagination -->
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets d-block d-sm-none"></div>
        <!-- end slider pagination -->
        <!-- start slider navigation -->
        <div class="slider-one-slide-prev-1 icon-very-small text-white swiper-button-prev slider-navigation-style-06 d-none d-sm-inline-block"><i class="line-icon-Arrow-OutLeft icon-extra-large"></i></div>
        <div class="slider-one-slide-next-1 icon-very-small text-white swiper-button-next slider-navigation-style-06 d-none d-sm-inline-block"><i class="line-icon-Arrow-OutRight icon-extra-large"></i></div>
        <!-- end slider navigation -->
    </div>
</section>
<!-- end banner slider -->


<!-- start FEATURE CARDS section -->

<section class="about-section-home-page overflow-visible lg-background-image-none">
    <div class="container">
        <div class="row row-cols-1 row-cols-lg-4 justify-content-center overlap-section z-index-1 overlap-section-three-fourth position-relative" data-anime='{ "el": "childs", "willchange": "transform", "perspective": [1200,1200], "translateY": [0, 0], "scale": [1.1, 1], "rotateX": [30, 0], "opacity": [0,1], "duration": 1000, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
            <?php if (have_rows('home_hero_feature_cards')) : $i = 1;
                while (have_rows('home_hero_feature_cards')) : the_row();

                    $card_title = get_sub_field('card_title') ? get_sub_field('card_title') : '';
                    $card_description = get_sub_field('card_description') ? get_sub_field('card_description') : '';
                    $card_link = get_sub_field('card_link') ? get_sub_field('card_link') : '';
            ?>
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-04 transition-inner-all lg-mb-30px">
                        <div class="feature-box bg-white h-100 justify-content-start p-17 lg-p-15 box-shadow-quadruple-large box-shadow-quadruple-large-hover border-radius-5px">
                            <div class="feature-box-icon feature-box-icon-rounded mx-auto rounded-circle h-90px w-90px fs-24 text-dark-gray border border-2 border-color-extra-medium-gray mb-25px fw-500">0<?php echo $i ?></div>
                            <div class="feature-box-content">
                                <span class="d-inline-block alt-font text-dark-gray fw-500 mb-5px fs-22"><?php echo $card_title; ?></span>
                                <p class="mb-15px"><?php echo $card_description; ?></p>
                                <span class="fs-18 lh-26 text-base-color text-uppercase text-decoration-line-bottom fw-500"><a role="button" tabindex="0" class="text-decoration-none cursor-pointer" href="<?php echo esc_url($card_link['url']); ?>"><?php echo $card_link['title']; ?></a></span>
                            </div>
                            <div class="feature-box-overlay bg-white border-radius-6px"></div>
                        </div>
                    </div>
                    <!-- end features box item -->
            <?php $i++;
                endwhile;
            endif; ?>
        </div>
        <!-- start ABOUT SECTION -->
        <?php
        $about_section_heading = get_field('about_section_heading') ? get_field('about_section_heading') : '';
        $cta_button = get_field('cta_button') ? get_field('cta_button') : '';
        $cta_button_2 = get_field('cta_button_2') ? get_field('cta_button_2') : '';
    
        $background_image = get_field('about_section_background_image') ? get_field('about_section_background_image') : '';
      

        ?>

<div class="container">
        <div class=" row align-items-center py-75 g-4">
            <div class="image-container col-8 mx-auto col-md-5 col-lg-4 d-flex justify-content-center">
                <img class="m-3" width="100%" src="<?php echo esc_url($background_image); ?>" alt="Amy, owner of Mediafast">
            </div>
            <div class="col-12 col-md-5 col-lg-7">
                <h2 class="about-section-h2 text-center text-lg-start alt-font fw-600 ls-minus-2px text-dark-gray pb-4"><?php echo $about_section_heading; ?></h2>
                <div class="mb-7">
                    <?php if (have_rows('list_items')) :
                        while (have_rows('list_items')) : the_row();
                            $list_item_heading = get_sub_field('list_item_heading');
                            $list_item_description = get_sub_field('list_item_description');
                    ?>
                            <!-- start features box item -->
                            <div class="col icon-with-text-style-08 mb-25px">
                                <div class="feature-box feature-box-left-icon-middle overflow-hidden">
                                    <div class="feature-box-icon feature-box-icon-rounded w-50px h-50px rounded-circle border border-2 border-color-base-color me-20px">
                                        <i class="fa-solid fa-check icon-small text-base-color"></i>
                                    </div>
                                    <div class="feature-box-content">
                                        <h3 class="w-75 d-block lh-3"><?php echo $list_item_heading; ?></h3>
                                        <p><?php echo $list_item_description; ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- end features box item -->
                    <?php endwhile;
                    endif; ?>
                </div>
                <div class="d-inline-block">
                    <?php if ($cta_button) : ?>
                        <a href="<?php echo esc_url($cta_button['url']); ?>" class="btn btn-primary me-2"><?php echo $cta_button['title']; ?></a>
                    <?php endif; ?>
                    <?php if ($cta_button_2) : ?>
                        <a href="<?php echo esc_url($cta_button_2['url']); ?>" class="btn btn-link btn-extra-large thin text-dark-gray xs-mt-15px xs-mb-15px"><?php echo $cta_button_2['title']; ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </div>
        <!-- end row -->
    </div>
</section>
<!-- end section -->