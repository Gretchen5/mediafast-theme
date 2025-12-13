<?php
$heading = get_field('heading');
$description = get_field('description');
$background_color = get_field('background_color');
$padding = get_field('padding');
$searchbar = get_field('searchbar');

?>

<!-- start section -->
<section class="big-section pb-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-lg-5 position-relative md-mb-25px" data-anime='{ "el": "childs", "translateX": [-50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <h2 class="fw-700 alt-font text-dark-gray ls-minus-2px"><?php echo $heading; ?></h2>
                <p><?php echo $description; ?></p>
                <div class="pt-5"><span class="text-dark-gray fs-30 me-5px align-middle fancy-text-style-4 ls-minus-1px"><i class="fa-solid fa-chart-line pe-3"></i> <span class="fw-600" data-fancy-text='{ "effect": "rotate", "string": ["66% higher response rate with video brochures", "1,243+ customers served", "655,083 video brochures shipped", "23,537 video boxes delivered", "278,710 mailer boxes sent"] }'></span></span></div>
            </div>
            <div class="col-xxl-7 col-lg-7 offset-xxl-1">
                <div class="accordion accordion-style-02" id="accordion-style-02" data-active-icon="icon-feather-chevron-up" data-inactive-icon="icon-feather-chevron-down" data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <!-- start accordion item -->
                    <?php if (have_rows('accordion_repeater')) : $i = 1;
                        while (have_rows('accordion_repeater')) :
                            the_row();

                            $accordion_heading = get_sub_field('accordion_heading');
                            $accordion_body = get_sub_field('accordion_body');

                            // Determine active class and collapse state for the first item only
                            $active_class   = ($i === 1) ? 'active-accordion' : '';
                            $collapse_class = ($i === 1) ? 'accordion-collapse collapse show' : 'accordion-collapse collapse';
                            $aria_expanded  = ($i === 1) ? 'true' : 'false';

                    ?>
                            <div class="accordion-item <?php echo esc_attr($active_class); ?>">
                                <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-0<?php echo $i; ?>" aria-expanded="<?php echo $aria_expanded; ?>" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray pe-30px">
                                            <i class="feather icon-feather-chevron-up icon-extra-medium"></i><span class="fw-600 fs-18"><?php echo $accordion_heading; ?></span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-0<?php echo $i; ?>" class="<?php echo esc_attr($collapse_class); ?>" data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-light-medium-gray">
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
        </div>
        <div class="row justify-content-start justify-content-md-center mt-5">
            <div class="col-auto icon-with-text-style-08 sm-mb-10px" data-anime='{ "translateX": [-50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="feature-box feature-box-left-icon-middle">
                    <div class="feature-box-icon me-10px">
                        <i class="bi bi-phone icon-small text-dark-gray"></i>
                    </div>
                    <div class="feature-box-content text-start">
                        <span class="alt-font text-dark-gray fw-500 fs-18">If you can't find the answers you're looking for, <a href="tel:18888375233" class="text-decoration-line-bottom text-primary fw-600">use our live chat or give us a call 1-888-837-5233.</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->