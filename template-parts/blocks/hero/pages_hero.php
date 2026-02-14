<?php
$background_image = get_field('background_image') ? 'background-image: url(' . get_field('background_image') . ');' : '';
$background_position = get_field('background_position') ? 'background-position: ' . get_field('background_position') . ';' : '';
$heading = get_field('heading');
$description = get_field('description');
$cta_button_1 = get_field('cta_button_1');
$cta_button_2 = get_field('cta_button_2');
$cta_1_type    = get_field('cta_button_1_type') ?: 'link';
$cta_2_type    = get_field('cta_button_2_type') ?: 'link';

$form_content_1 = get_field('cta_button_1_form');
$form_id = uniqid('sharedFormBlock_');
$form_content_2 = get_field('cta_button_2_form');
$unique_id_1 = uniqid('formModal1_');
$unique_id_2 = uniqid('formModal2_');

$calendly_url = 'https://calendly.com/mediafast-team/30min?embed_domain=mediafast.com&embed_type=PopupText';
?>

<section class="component--hero">
    <div class="background-image py-75" style="<?php echo $background_image . '' . $background_position; ?>">
        <div class="overlay"></div>
        <div class="content-container container position-relative z-2 pt-150">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="masthead-content container text-white">
                        <h1 class="text-center text-md-start"><?php echo $heading; ?></h1>
                        <p class="text-large text-center text-md-start"><?php echo $description; ?></p>
                        <?php if ($cta_button_1 || $cta_button_2) : ?>
                            <div class="cta-button-container d-flex flex-column flex-md-row align-items-center gap-2 pt-4 mb-5">

                                <?php
                                // First button logic (CF7 modal OR normal link)
                                $is_form_modal = strpos($cta_button_1['url'], '#contact-form') !== false; // Adjust this to your own indicator

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

                                <?php
                                // Second button logic (Calendly modal OR normal link)

                                $is_calendly = !empty($cta_button_2['url']) && strpos($cta_button_2['url'], 'calendly.com/mediafast-team') !== false;


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

        </div>
</section>