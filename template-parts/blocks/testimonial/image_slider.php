<?php

$section_heading = get_field('section_heading');
$description = get_field('description');
$heading_color = get_field('heading_color') ?: 'text-seconary';
$text_color = get_field('text_color') ?: '#text-body';
$vertical_padding = get_field('vertical_padding') ?: '';
?>

<section class="component--image-slider-section bg-lt-gray pt-5">

    <div class="section-header container text-center pb-3">
        <h2 class="section-title pb-3 <?php echo esc_attr($heading_color); ?> mb-0 lh-1"><?php echo $section_heading; ?></h2>
        <?php if ($description) : ?>
            <p class="<?php echo esc_attr($text_color); ?>"><?php echo $description; ?></p>
        <?php endif; ?>
    </div>

</section>
<!-- start section -->
<section class="bg-very-light-gray pb-5">
    <div class="container-fluid">
        <div class="row overflow-hidden">
            <div class="col-12 col-md-12">
                <div class="outside-box-right-15 outside-box-left-15 sm-outside-box-left-40 sm-outside-box-right-40">
                    <div class="swiper" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loop": true, "autoplay": { "delay": 2000, "disableOnInteraction": false },  "pagination": { "el": ".swiper-line-pagination", "clickable": true }, "navigation": { "nextEl": ".slider-three-slide-next", "prevEl": ".slider-three-slide-prev" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "992": { "slidesPerView": 6 }, "768": { "slidesPerView": 3 }, "320": { "slidesPerView": 3 } }, "effect": "slide" }'>
                        <div class="swiper-wrapper align-items-center">
                            <!-- start slider item -->
                            <?php
                            $images = get_field('image_slider');
                            if ($images) :
                                foreach ($images as $index => $image) :
                                    $simulatedHeight = ($index % 2 === 0) ? 'auto' : '85%';
                            ?>
                                    <div class="swiper-slide bg-white shadow image-swiper-slide">
                                        <img src="<?php echo esc_url($image['url']); ?>"
                                            alt="<?php echo esc_attr($image['alt']); ?>"
                                            class="border-radius-6px"
                                            style="height: <?php echo $simulatedHeight; ?>; width: auto;" />
                                    </div>
                            <?php
                                endforeach;
                            endif; ?>
                            <!-- end slider item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->