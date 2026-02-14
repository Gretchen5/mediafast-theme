<?php

/**
 * The Template for displaying Archive pages.
 */

get_header();

if (have_posts()) :
?>
	<?php
	$term       = get_queried_object();
	$term_id    = $term->term_id;
	$taxonomy   = $term->taxonomy;

	// ACF key for this taxonomy term
	$acf_key = $taxonomy . '_' . $term_id;

	// Get ACF fields for this term
	$heading           = get_field('heading', $acf_key);
	$description       = get_field('description', $acf_key);
	$background_image = get_field('background_image', $acf_key) ? 'background-image: url(' . get_field('background_image', $acf_key) . ');' : '';
	$background_position = get_field('background_position', $acf_key) ? 'background-position: ' . get_field('background_position', $acf_key) . ';' : '';
	$overlay_selection = get_field('overlay_selection', $acf_key);

	$cta_button_1      = get_field('cta_button_1', $acf_key);
	$cta_button_2      = get_field('cta_button_2', $acf_key);
	$cta_1_type        = get_field('cta_button_1_type', $acf_key);
	$cta_2_type        = get_field('cta_button_2_type', $acf_key);

	$form_content_1    = get_field('cta_button_1_form', $acf_key);
	$form_content_2    = get_field('cta_button_2_form', $acf_key);

	// Fallback if no heading provided
	if (empty($heading)) {
		$heading = $term->name . ' Gallery';
	}

	// Unique IDs (taxonomy + term based to avoid duplication)
	$form_id      = 'sharedFormBlock_' . $taxonomy . '_' . $term_id;
	$unique_id_1  = 'formModal1_' . $taxonomy . '_' . $term_id;
	$unique_id_2  = 'formModal2_' . $taxonomy . '_' . $term_id;

	$calendly_url = 'https://calendly.com/mediafast-team/30min?embed_domain=mediafast.com&embed_type=PopupText';
	?>


	<section class="component--hero position-relative pb-5">
		<div class="background-image py-75" style="<?php echo $background_image . '' . $background_position; ?>">
			<div class="overlay" style="--overlay-opacity: <?php echo esc_attr($overlay_selection); ?>"></div>
			<div class="content-container position-relative z-2 pt-175">
				<div class="row">
					<div class="container px-3 mx-0 px-md-5 mx-md-5">
						<div class="col-12">
							<div class="masthead-content container text-white text-center text-md-start">
								<h1><?php echo $heading; ?></h1>
								<p class="text-large"><?php echo $description; ?></p>
								<?php if (!empty($cta_button_1['url']) || !empty($cta_button_2['url'])) : ?>
									<div class="cta-button-container d-flex flex-column flex-md-row align-items-center gap-2 pt-4">

										<?php
										// First button logic (CF7 modal OR normal link)
										$is_form_modal = strpos($cta_button_1['url'], '#contact-form') !== false; // Adjust this to your own indicator

										if (!empty($cta_button_1['url']) && !empty($cta_button_1['title'])) :
											if ($cta_1_type === 'form' && !empty($form_content_1)) : ?>
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


										if (!empty($cta_button_2['url']) && !empty($cta_button_2['title'])) :
											if ($cta_2_type === 'form' && !empty($form_content_2)) : ?>
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
												<button href="<?php echo esc_url($cta_button_2['url']); ?>"
													class="btn btn-primary d-inline-block me-2"
													target="<?php echo esc_attr($cta_button_2['target']); ?>">
													<?php echo $cta_button_2['title']; ?>
												</button>
										<?php endif;
										endif; ?>

									</div>
								<?php endif; ?>

							</div>

						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
<?php
	get_template_part('archive', 'loop-gallery');
else :
	// 404.
	get_template_part('content', 'none');
endif;

wp_reset_postdata(); // End of the loop.

get_footer();
