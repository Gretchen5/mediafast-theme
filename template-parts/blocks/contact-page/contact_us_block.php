<!-- start section -->
<section class="component--contact-us">
    <div class="container pt-5 pb-75">
        <div class="row">
            <div class="col-12 tab-style-04"
                data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

                <?php if (have_rows('office_repeater')): ?>
                    <!-- start nav tabs -->
                    <ul class="nav nav-tabs border-0 justify-content-center mb-6 alt-font fs-22">
                        <?php
                        $tab_index = 0;
                        while (have_rows('office_repeater')): the_row();
                            $office_name = get_sub_field('office_name');
                            $tab_id = 'tab_office_' . $tab_index;
                        ?>
                            <li class="nav-item">
                                <a
                                    class="nav-link text-dark-gray <?php echo $tab_index === 0 ? 'active' : ''; ?>"
                                    data-bs-toggle="tab"
                                    href="#<?php echo esc_attr($tab_id); ?>">
                                    <?php echo $office_name; ?>
                                    <span class="tab-border bg-base-color"></span>
                                </a>
                            </li>
                        <?php $tab_index++;
                        endwhile; ?>
                    </ul>
                    <!-- end nav tabs -->

                    <!-- start tab content -->
                    <div class="tab-content">
                        <?php
                        $content_index = 0;
                        rewind_posts(); // reset loop
                        while (have_rows('office_repeater')): the_row();
                            $office_name = get_sub_field('office_name');
                            $office_image = get_sub_field('office_image');
                            $office_info  = get_sub_field('office_info');
                            $map_link     = get_sub_field('map_link');
                            $tab_id       = 'tab_office_' . $content_index;
                        ?>

                            <div class="tab-pane fade <?php echo $content_index === 0 ? 'in active show' : 'in'; ?>" id="<?php echo esc_attr($tab_id); ?>">
                                <div class="row align-items-center justify-content-center">
                                    <?php if ($office_image) : ?>
                                        <div class="col-lg-5 col-md-6 sm-mb-30px">
                                            <img src="<?php echo esc_url($office_image['url']); ?>" alt="<?php echo esc_attr($office_name); ?>" class="w-100" />
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-lg-4 col-md-5 offset-md-1 text-center text-md-start">
                                        <span class="alt-font text-dark-gray fs-22 fw-500 mb-5px d-inline-block">
                                            <?php echo $office_name; ?>
                                        </span>
                                        <?php echo $office_info; // WYSIWYG allows full HTML 
                                        ?>
                                        <?php if ($map_link) : ?>
                                            <a href="<?php echo esc_url($map_link); ?>"
                                                target="_blank"
                                                class="btn btn-link text-dark-gray thin btn-large">
                                                View on google map
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php $content_index++;
                        endwhile; ?>
                    </div>
                    <!-- end tab content -->

                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
<!-- end section -->
<?php
$contact_form_superheading = get_field('contact_form_superheading');
$contact_form_heading = get_field('contact_form_heading');
$background_image = get_field('cntct_frm_bg_image') ? 'background-image: url(' . get_field('cntct_frm_bg_image') . ');' : '';
$contact_form = get_field('contact_form');
?>

<!-- start section -->
<section class="cover-background big-section" style="<?php echo $background_image; ?>" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
    <div class="opacity-extra-medium bg-dark-gray"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10 contact-form-style-03 position-relative">
                <div class="p-14 md-p-10 bg-white border-radius-6px text-center box-shadow-extra-large">
                    <div class="d-inline-block fw-500 text-uppercase text-base-color ls-1px mb-5px"><?php echo $contact_form_superheading; ?></div>
                    <h2 class="fw-600 ls-minus-1px text-dark-gray mb-8"><?php echo $contact_form_heading; ?></h2>
                    <!-- start contact form -->
                    <?php echo $contact_form; ?>
                    <!-- end contact form -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->