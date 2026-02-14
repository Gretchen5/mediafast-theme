<?php

/**
 * The template for displaying the archive loop.
 */

if (have_posts()) :
?>

	<?php
	$background_image = get_field('background_image', 'option') ? 'background-image: url(' . get_field('background_image', 'option') . ');' : '';
	$background_position = get_field('background_position', 'option') ? 'background-position: ' . get_field('background_position', 'option') . ';' : '';
	$overlay_selection = get_field('overlay_selection', 'option');
	$heading = get_field('heading', 'option');
	$description = get_field('description', 'option');
	$cta_button_1 = get_field('cta_button_1', 'option');
	$cta_button_2 = get_field('cta_button_2', 'option');
	$cta_1_type    = get_field('cta_button_1_type', 'option') ?: 'link';
	$cta_2_type    = get_field('cta_button_2_type', 'option') ?: 'link';

	$form_content_1 = get_field('cta_button_1_form', 'option');
	$form_id = uniqid('sharedFormBlock_');
	$form_content_2 = get_field('cta_button_2_form', 'option');
	$unique_id_1 = uniqid('formModal1_');
	$unique_id_2 = uniqid('formModal2_');

	$calendly_url = 'https://calendly.com/mediafast-team/30min?embed_domain=mediafast.com&embed_type=PopupText';
	?>

	<section class="component--hero archive-loop">
		<div class="background-image py-75" style="<?php echo $background_image . '' . $background_position; ?>">
			<div class="overlay" style="--overlay-opacity: <?php echo esc_attr($overlay_selection); ?>"></div>
			<div class="content-container container position-relative z-2 pt-150">
				<div class="row">
					<div class="col-12 col-md-8">
						<div class="masthead-content container text-white">
							<h1><?php echo $heading; ?></h1>
							<p class="text-large"><?php echo $description; ?></p>
							<?php if ($cta_button_1 || $cta_button_2) : ?>
								<div class="cta-button-container d-flex flex-column flex-md-row align-items-center gap-2 pt-4">

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
											<button href="<?php echo esc_url($cta_button_1['url']); ?>"
												class="btn btn-primary d-inline-block me-2"
												target="<?php echo esc_attr($cta_button_1['target']); ?>">
												<?php echo $cta_button_1['title']; ?>
											</button>
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
											<a type="button"
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
		</div>

	</section>

	<div class="container py-5">
		<div class="row g-5">
			<?php
			while (have_posts()) :
				the_post();


				/**
				 * Include the Post-Format-specific template for the content.
				 * If you want to overload this in a child theme then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part('content', 'index'); // Post format: content-index.php
			endwhile;
			?>
		</div>
	</div>
<?php
endif;

wp_reset_postdata();

$big = 999999999; // need an unlikely integer

$pages = paginate_links(array(
	'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
	'format'    => '?paged=%#%',
	'current'   => max(1, get_query_var('paged')),
	'total'     => $wp_query->max_num_pages,
	'type'      => 'array',
	'prev_text' => '&larr;', // simple left arrow
	'next_text' => '&rarr;', // simple right arrow
));

if (is_array($pages)) :
?>
	<nav class="custom-pagination pt-5" style="border-bottom: 1px solid #757575; padding-bottom: 2rem;">
		<ul class="pagination justify-content-center">
			<?php foreach ($pages as $page) : ?>
				<li class="page-item"><?php echo $page; ?></li>
			<?php endforeach; ?>
		</ul>
	</nav>
<?php endif; ?>