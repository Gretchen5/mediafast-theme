<?php

$image = get_field('image') ? get_field('image') : '';
$heading = get_field('heading') ? get_field('heading') : '';
$vertical_padding = get_field('vertical_padding') ? get_field('vertical_padding') : '';
$background_url = $image['url'] ? $image['url'] : '/wp-content/uploads/2025/08/video_brochure_pricing.jpg';
$accordion_id = 'accordion-' . uniqid();
$background_color = get_field('background_color') ? get_field('background_color') : 'bg-secondary';
?>

<!-- start section -->
<section class="<?php echo esc_attr($background_color . ' ' . $vertical_padding); ?>">
    <div class="container-fluid p-0">
        <div class="row justify-content-center g-0">
            <div class="col-lg-6 col-md-10 ps-10 pe-10 pt-7 pb-7 xxl-p-6" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 100, "easing": "easeOutQuad" }'>
                <h2 class="h2 fw-500 text-white lh-1"><?php echo $heading; ?></h2>
                <div class="accordion accordion-style-02" id="<?php echo esc_attr($accordion_id); ?>" data-active-icon="fa-angle-down" data-inactive-icon="fa-angle-right">
                    <?php if (have_rows('accordion_repeater')) : $i = 1;
                        while (have_rows('accordion_repeater')) :
                            the_row();

                            $accordion_heading = get_sub_field('accordion_heading');
                            $accordion_body = get_sub_field('accordion_body');

                    ?>
                            <!-- start accordion item -->
                            <div class="accordion-item accordion-item-dark <?php if ($i === 1) : echo 'active-accordion';
                                                                            endif; ?>">
                                <div class="accordion-header border-bottom border-color-transparent-white-light">
                                    <h3><a href="#" class="text-decoration-none" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr($accordion_id); ?><?php echo $i; ?>" aria-expanded="true" data-bs-parent="#<?php echo esc_attr($accordion_id); ?>">
                                            <div class="accordion-title mb-0 position-relative text-white">
                                                <i class="fa-solid fa-angle-down icon-small"></i><span class="fw-400 alt-font fs-20"><?php echo $accordion_heading; ?></span>
                                            </div>
                                        </a>
                                    </h3>
                                </div>
                                <div id="<?php echo esc_attr($accordion_id); ?><?php echo $i; ?>" class="accordion-collapse collapse <?php echo ($i === 1) ? 'show' : ''; ?>" data-bs-parent="#<?php echo esc_attr($accordion_id); ?>">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent-white-light text-extra-medium-gray">
                                        <p><?php echo $accordion_body; ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- end accordion item -->
                    <?php $i++;
                        endwhile;
                    endif; ?>
                </div>
            </div>
            <div class="col-lg-6 md-h-550px xs-h-400px" data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay": 100, "staggervalue": 100, "easing": "easeOutQuad" }'>
                <div class="h-100 cover-background" style="background-image: url(<?php echo $background_url; ?>)"></div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->