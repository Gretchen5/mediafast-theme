<?php

$cards = get_field('card_repeater');
$pdf_intro = get_field('pdf_intro') ? get_field('pdf_intro') : '';
$pdf_link = get_field('pdf_link') ? get_field('pdf_link') : '#';
$number_of_cards = get_field('number_of_cards') ? get_field('number_of_cards') : 'row-cols-lg-4';

?>

<!-- start section -->

<section class="component--cards-side-by-side bg-very-light-gray half-section ps-6 pe-6">
    <?php if (!empty($pdf_link) && is_array($pdf_link)): ?>
        <div class="container pdf-section">
            <div class="row bg-white box-shadow-extra-large border-radius-6px ps-lg-5 pe-lg-5 pt-3 pb-3 g-0 sm-p-6 sm-ps-19 align-items-center mb-8 overflow-hidden position-relative">
                <div class="col-lg-2 col-md-3 text-center p-3 pdf-image">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/rocket-icon.svg" alt="rocket icon">
                </div>
                <div class="col-md-6 text-center text-md-start sm-mb-25px">
                    <div class="fs-26 alt-font fw-500 text-dark-gray ls-minus-05px"><?php echo $pdf_intro; ?></div>
                </div>
                <div class="col-lg-4 col-md-3 text-center pb-4 pb-lg-0">

                    <a class="btn btn-primary" href="<?php echo esc_url($pdf_link['url']); ?>" target="<?php echo esc_attr($pdf_link['target']); ?>">
                        <?php echo esc_html($pdf_link['title']); ?>
                    </a>

                </div>
                <div class="vertical-title-center align-items-center position-absolute top-0px left-0px bg-base-color p-10px w-50px h-100 w-10px z-index-9">
                    <div class="title fs-15 ls-1px text-white fw-600 text-uppercase">PDF GUIDE</div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="container-fluid">
        <div class="row row-cols-1 <?php echo esc_attr($number_of_cards); ?> row-cols-md-2 justify-content-center" data-anime='{ "el": "childs", "translateX": [-15, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
            <?php
            if (have_rows('card_repeater')) :

                while (have_rows('card_repeater')) : the_row();
                    $icon = get_sub_field('icon') ? get_sub_field('icon') : '';
                    $heading = get_sub_field('heading');
                    $description = get_sub_field('description');

            ?>
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-10 border-end border-1 sm-border-end-0 border-color-transparent-base-color md-mb-50px">
                        <div class="feature-box ps-8 pe-8 xl-ps-5 xl-pe-5">
                            <div class="feature-box-icon feature-box-icon-rounded w-120px h-120px rounded-circle mb-20px">
                                <i class="<?php echo $icon; ?> icon-extra-large text-base-color"></i>
                            </div>
                            <div class="feature-box-content last-paragraph-no-margin">
                                <span class="alt-font text-dark-gray fs-22 ls-0px"><?php echo $heading; ?></span>
                                <p><?php echo $description; ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- end features box item -->

            <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>
<!-- end section -->