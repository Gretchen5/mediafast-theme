<!-- start section -->
<section class="component--contact-us">
    <div class="container pt-5 pb-75">
        <div class="row">
            <div class="col-12">
                <?php
                $office_name = get_field('office_name');
                $office_image = get_field('office_image');
                $office_info = get_field('office_info');
                $map_link = get_field('map_link');
                ?>
                
                <?php if ($office_name || $office_image || $office_info) : ?>
                    <div class="row align-items-center justify-content-center">
                        <?php if ($office_image) : ?>
                            <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                                <img src="<?php echo esc_url($office_image['url']); ?>" 
                                     alt="<?php echo esc_attr($office_name ?: 'Office location'); ?>" 
                                     class="w-100" />
                            </div>
                        <?php endif; ?>

                        <div class="col-lg-4 col-md-5 text-center text-md-start">
                            <?php if ($office_name) : ?>
                                <h2 class="fs-22 fw-500 text-secondary mb-3">
                                    <?php echo esc_html($office_name); ?>
                                </h2>
                            <?php endif; ?>
                            
                            <?php if ($office_info) : ?>
                                <div class="office-info mb-3">
                                    <?php echo wp_kses_post($office_info); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($map_link) : ?>
                                <a href="<?php echo esc_url($map_link); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="google-map-link">
                                    View on Google Maps
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
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
<section class="component--contact-form-section" style="<?php echo $background_image; ?>">
    <div class="contact-form-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10 contact-form-wrapper position-relative">
                <div class="contact-form-container">
                    <?php if ($contact_form_superheading) : ?>
                        <div class="contact-form-superheading"><?php echo esc_html($contact_form_superheading); ?></div>
                    <?php endif; ?>
                    <?php if ($contact_form_heading) : ?>
                        <h2 class="contact-form-heading"><?php echo esc_html($contact_form_heading); ?></h2>
                    <?php endif; ?>
                    <!-- start contact form -->
                    <?php echo $contact_form; ?>
                    <!-- end contact form -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->