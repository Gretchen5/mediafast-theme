<?php
// Video Hero Fields
$video_mp4      = get_field('video_mp4');
$poster_image   = get_field('poster_image');
$heading        = get_field('heading');
$subheading     = get_field('subheading');

// CTA fields (same logic as masthead)
$cta_button_1 = get_field('cta_button_1');
$cta_button_2 = get_field('cta_button_2');

$cta_1_type = get_field('cta_button_1_type') ?: 'link';
$cta_2_type = get_field('cta_button_2_type') ?: 'link';

$form_content_1 = get_field('cta_button_1_form');
$unique_id_1 = uniqid('formModal1_');

$form_content_2 = get_field('cta_button_2_form');
$unique_id_2 = uniqid('formModal2_');

$calendly_url = 'https://calendly.com/mediafast-team/30min?embed_domain=mediafast.com&embed_type=PopupText';
?>

<section class="video-hero position-relative overflow-hidden">

    <!-- Background Video -->
    <?php if ($video_mp4) : ?>
        <video 
            class="video-hero-bg position-absolute w-100 h-100 top-0 start-0 object-fit-cover"
            autoplay 
            muted 
            loop 
            playsinline 
            preload="auto"
            <?php if ($poster_image) : ?>
                poster="<?php echo esc_url($poster_image); ?>"
            <?php endif; ?>
        >
            <source src="<?php echo esc_url($video_mp4); ?>" type="video/mp4">
        </video>
    <?php endif; ?>

    <!-- Overlay -->
    <div class="video-hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

    <!-- Content -->
    <div class="container position-relative z-2 pt-150">
        <div class="row">
            <div class="col-12 col-lg-8 text-white">

                <?php if ($heading) : ?>
                    <h1 class="video-hero-headline mb-3 text-center text-md-start">
                        <?php echo $heading; ?>
                    </h1>
                <?php endif; ?>

                <?php if ($subheading) : ?>
                    <p class="video-hero-subheadline mb-4 text-center text-md-start">
                        <?php echo $subheading; ?>
                    </p>
                <?php endif; ?>


                <?php if ($cta_button_1 || $cta_button_2) : ?>
                    <div class="cta-button-container d-flex flex-column flex-md-row align-items-center gap-2 pt-4 mb-5">

                        <!-- CTA BUTTON 1 -->
                        <?php
                        if ($cta_button_1) :
                            if ($cta_1_type === 'form' && $form_content_1) : ?>
                                <button type="button"
                                    class="btn btn-primary d-inline-block me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#mediaModal"
                                    data-type="form"
                                    data-form-id="<?php echo esc_attr($unique_id_1); ?>"
                                    data-title="<?php echo esc_attr($cta_button_1['title']); ?>"
                                    data-description="">
                                    <?php echo $cta_button_1['title']; ?>
                                </button>

                                <div id="<?php echo esc_attr($unique_id_1); ?>" class="d-none">
                                    <?php echo $form_content_1; ?>
                                </div>

                            <?php elseif ($cta_1_type === 'calendly') : ?>
                                <button type="button"
                                    class="btn btn-primary d-inline-block me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#mediaModal"
                                    data-type="calendly"
                                    data-calendly-url="<?php echo esc_url($calendly_url); ?>"
                                    data-title="Schedule a Free Consultation"
                                    data-description="Get one-on-one guidance from a MediaFast expert. No obligation, just answers.">
                                    <?php echo $cta_button_1['title']; ?>
                                </button>

                            <?php else : ?>
                                <a href="<?php echo esc_url($cta_button_1['url']); ?>"
                                    class="btn btn-primary d-inline-block me-2"
                                    target="<?php echo esc_attr($cta_button_1['target']); ?>">
                                    <?php echo $cta_button_1['title']; ?>
                                </a>
                        <?php endif;
                        endif; ?>


                        <!-- CTA BUTTON 2 -->
                        <?php
                        if ($cta_button_2) :
                            if ($cta_2_type === 'form' && $form_content_2) : ?>
                                <button type="button"
                                    class="btn btn-primary d-inline-block me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#mediaModal"
                                    data-type="form"
                                    data-form-id="<?php echo esc_attr($unique_id_2); ?>"
                                    data-title="<?php echo esc_attr($cta_button_2['title']); ?>"
                                    data-description="">
                                    <?php echo $cta_button_2['title']; ?>
                                </button>

                                <div id="<?php echo esc_attr($unique_id_2); ?>" class="d-none">
                                    <?php echo $form_content_2; ?>
                                </div>

                            <?php elseif ($cta_2_type === 'calendly') : ?>
                                <button type="button"
                                    class="btn btn-primary d-inline-block me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#mediaModal"
                                    data-type="calendly"
                                    data-calendly-url="<?php echo esc_url($calendly_url); ?>"
                                    data-title="Schedule a Free Consultation"
                                    data-description="Get one-on-one guidance from a MediaFast expert. No obligation, just answers.">
                                    <?php echo $cta_button_2['title']; ?>
                                </button>

                            <?php else : ?>
                                <a href="<?php echo esc_url($cta_button_2['url']); ?>"
                                    class="btn btn-primary d-inline-block me-2"
                                    target="<?php echo esc_attr($cta_button_2['target']); ?>">
                                    <?php echo $cta_button_2['title']; ?>
                                </a>
                        <?php endif;
                        endif; ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

</section>

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
        $cta_button = get_field('cta_button') ? get_field('cta_button') : '';
        $cta_button_2 = get_field('cta_button_2') ? get_field('cta_button_2') : '';
    
        $background_image = get_field('about_section_background_image') ? get_field('about_section_background_image') : '';
      

        ?>

<section class="about-section py-75">
    <div class="container">

        <div class="row align-items-center g-4">

            <!-- IMAGE -->
            <div class="col-10 col-md-5 col-lg-4 mx-auto d-flex justify-content-center">
                <img 
                    src="<?php echo $background_image; ?>" 
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
                    
                    <?php if ($cta_button): ?>
                        <a href="<?php echo $cta_button['url']; ?>" class="btn btn-primary btn-box-shadow btn-round-edge me-2">
                            <?php echo $cta_button['title']; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($cta_button_2): ?>
                        <a href="<?php echo $cta_button_2['url']; ?>" class="btn btn-link btn-extra-large thin text-dark-gray">
                            <?php echo $cta_button_2['title']; ?>
                        </a>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</section>