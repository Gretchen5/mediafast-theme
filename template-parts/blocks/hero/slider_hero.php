

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

<section class="home-feature-cards">
    <div class="container">
        <div class="row d-flex align-items-stretch row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 home-feature-cards__row">
        <?php if (have_rows('home_hero_feature_cards')) : 
    $i = 0; // counter for AOS delays
    while (have_rows('home_hero_feature_cards')) : the_row();
        $i++;
        $delay = $i * 150; // 150ms stagger per card

        $card_title       = get_sub_field('card_title');
        $card_description = get_sub_field('card_description');
        $card_link        = get_sub_field('card_link');
?>
    <div class="col h-100">
        <div class="home-feature-card d-flex flex-column h-100" data-animate>

            <div class="home-feature-card__circle">
                <span class="home-feature-card__number">
                    <?php echo sprintf("%02d", $i); ?>
                </span>
            </div>

            <?php if ($card_title): ?>
                <h2 class="fs-22 home-feature-card__title">
                    <?php echo esc_html($card_title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($card_description): ?>
                <p class="home-feature-card__text">
                    <?php echo esc_html($card_description); ?>
                </p>
            <?php endif; ?>

            <?php if ($card_link): ?>
                <div class="home-feature-card__cta mt-auto">
                    <a href="<?php echo esc_url($card_link['url']); ?>"
                       class="home-feature-card__link">
                       <?php echo esc_html($card_link['title']); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

<?php endwhile;
endif; ?>

        </div>
    </div>
</section>
<!-- end FEATURE CARDS section -->




        <!-- start ABOUT SECTION -->
        <?php
        $about_section_heading = get_field('about_section_heading') ? get_field('about_section_heading') : '';
        $about_cta_button = get_field('about_cta_button') ? get_field('about_cta_button') : '';
        $about_cta_button_2 = get_field('about_cta_button_2') ? get_field('about_cta_button_2') : '';
    
        $about_image = get_field('about_image') ? get_field('about_image') : '';
      

        ?>

<section class="about-section py-75">
    <div class="container">

        <div class="row align-items-center g-4">

            <!-- IMAGE -->
            <div class="col-10 col-md-5 col-lg-4 mx-auto d-flex justify-content-center">
                <img 
                    src="<?php echo $about_image; ?>" 
                    class="img-fluid"
                    alt="About MediaFast"
                >
            </div>

            <!-- CONTENT COLUMN -->
            <div class="col-12 col-md-7 col-lg-8">

                <!-- Heading -->
                <h2 
                    class="about-section__title mb-4 text-center text-seconary text-md-start stagger-1" data-animate>
                    <?php echo $about_section_heading; ?>
                </h2>

                <!-- LIST -->
                <div class="mb-4">

                <?php if (have_rows('list_items')) : 
                    $i = 1; // start stagger at 1
                    while (have_rows('list_items')) : the_row(); 
                        $title = get_sub_field('list_item_heading');
                        $text  = get_sub_field('list_item_description');

                        // each item increases delay by 120ms
                        $delay = $i * 120;
                ?>

                <div 
                    class="about-section__item d-flex mb-3"
                    data-animate
                    data-delay="<?php echo $delay; ?>"
                >
                    <div class="about-section__icon me-3 d-flex align-items-centerjustify-content-center">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <div>
                        <h3 class="about-section__item-title"><?php echo $title; ?></h3>
                        <p class="about-section__item-text"><?php echo $text; ?></p>
                    </div>
                </div>

                <?php 
                    $i++;
                    endwhile;
                endif; 
                ?>

                </div>


                <!-- CTA -->
                <div class="about-section__cta-block stagger-cta mt-3 text-center text-md-start" data-animate>
                    
                    <?php if ($about_cta_button): ?>
                        <a href="<?php echo $about_cta_button['url']; ?>" class="btn btn-primary btn-box-shadow btn-round-edge me-2">
                            <?php echo $about_cta_button['title']; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($about_cta_button_2): ?>
                        <a href="<?php echo $about_cta_button_2['url']; ?>" class="btn btn-link btn-extra-large thin text-dark-gray">
                            <?php echo $about_cta_button_2['title']; ?>
                        </a>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</section>