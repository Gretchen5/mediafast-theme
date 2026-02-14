			<?php
			// If Single or Archive (Category, Tag, Author or a Date based page).
			if (is_single() || is_archive()) :
			?>
				</div><!-- /.col -->

				<?php
				get_sidebar();
				?>

				</div><!-- /.row -->
			<?php
			endif;
			?>
			</main><!-- /#main -->
			<?php

			$wysiwyg = get_field('wysiwyg', 'option') ? get_field('wysiwyg', 'option') : '';
			$vertical_padding = get_field('vertical_padding', 'option') ? get_field('vertical_padding', 'option') : '';

			$calendly_url = 'https://calendly.com/mediafast-team/30min?embed_domain=mediafast.com&embed_type=PopupText';

			?>

			<section class="cta_button-block <?php echo esc_attr($vertical_padding); ?>">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<?php if ($wysiwyg) : ?>
								<div class="wysiwyg-content">
									<?php echo $wysiwyg; ?>
								</div>
							<?php endif; ?>
							<?php if (have_rows('cta_button_repeater', 'option')) : ?>
								<div class="button-cta-container d-flex flex-wrap justify-content-center">
									<?php while (have_rows('cta_button_repeater', 'option')) : the_row();
										$cta_button = get_sub_field('cta_button') ? get_sub_field('cta_button') : '';
										// Check for button type field (if it exists), otherwise detect from URL or default to 'link'
										$cta_button_type = get_sub_field('cta_button_type');
										if (empty($cta_button_type) && !empty($cta_button['url'])) {
											// Auto-detect Calendly URLs if type field doesn't exist
											$cta_button_type = (strpos($cta_button['url'], 'calendly.com') !== false) ? 'calendly' : 'link';
										}
										$cta_button_type = $cta_button_type ?: 'link';
									?>
										<?php if ($cta_button) : ?>
											<?php if ($cta_button_type === 'calendly') : ?>
												<button type="button"
													class="btn btn-primary m-2"
													data-bs-toggle="modal"
													data-bs-target="#mediaModal"
													data-type="calendly"
													data-calendly-url="<?php echo esc_url($calendly_url); ?>"
													data-title="Schedule a Free Consultation"
													data-description="Get one-on-one guidance from a MediaFast expert. No obligation, just answers.">
													<?php echo $cta_button['title']; ?>
												</button>
											<?php else : ?>
												<a class="btn btn-primary m-2" href="<?php echo esc_url($cta_button['url']); ?>" target="<?php echo esc_attr($cta_button['target']); ?>">
													<?php echo $cta_button['title']; ?>
												</a>
											<?php endif; ?>
										<?php endif; ?>
									<?php endwhile; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</section>

			<?php
			$footer_logo_woman = get_field('footer_logo_woman', 'option') ? get_field('footer_logo_woman', 'option') : '';
			$footer_logo = get_field('footer_logo', 'option') ? get_field('footer_logo', 'option') : '';
			?>
			<footer class="bg-secondary py-0" id="footer">
				<div class="container py-5">
					<div class="row flex-column flex-sm-row gap-4 justify-content-center justify-content-sm-start">
						<div class="col footer-col footer-col-1 text-center text-sm-start">
							<h2 class="h3 text-light-blue mb-3">About MediaFast</h2>
							<?php
							if (has_nav_menu('footer-menu-1')) : // See function register_nav_menus() in functions.php
								/*
								Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
								Menu name taken from functions.php!!! ... register_nav_menu( 'footer-menu', 'Footer Menu' );
								!!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Footer menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
							*/
								wp_nav_menu(
									array(
										'container'       => 'nav',
										'container_class' => 'col-12',
										//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
										'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
										'theme_location'  => 'footer-menu-1',
										'items_wrap'      => '<ul class="menu nav">%3$s</ul>',
									)
								);
							endif; ?>
							<?php if ($footer_logo_woman) : ?>
								<div class="logo-container col-md-6 col-12 pt-4">
									<?php echo mediafast_get_optimized_image($footer_logo_woman, 'acf-small', array('style' => 'max-width: 150px;', 'loading' => 'lazy')); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="col footer-col footer-col-2 text-center text-sm-start">
							<h2 class="h3 text-light-blue mb-3">Products</h2>
							<?php if (has_nav_menu('footer-menu-2')) : // See function register_nav_menus() in functions.php
								/*
								Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
								Menu name taken from functions.php!!! ... register_nav_menu( 'footer-menu', 'Footer Menu' );
								!!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Footer menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
								*/
								wp_nav_menu(
									array(
										'container'       => 'nav',
										'container_class' => 'col-12',
										//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
										'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
										'theme_location'  => 'footer-menu-2',
										'items_wrap'      => '<ul class="menu nav">%3$s</ul>',
									)
								);
							endif; ?>
						</div>

						<div class="col footer-col footer-col-3 text-center text-sm-start">
							<h2 class="h3 text-light-blue mb-3">Resources</h2>
							<?php
							if (has_nav_menu('footer-menu-3')) : // See function register_nav_menus() in functions.php
								/*
								Loading WordPress Custom Menu (theme_location) ... remove <div> <ul> containers and show only <li> items!!!
								Menu name taken from functions.php!!! ... register_nav_menu( 'footer-menu', 'Footer Menu' );
								!!! IMPORTANT: After adding all pages to the menu, don't forget to assign this menu to the Footer menu of "Theme locations" /wp-admin/nav-menus.php (on left side) ... Otherwise the themes will not know, which menu to use!!!
							*/
								wp_nav_menu(
									array(
										'container'       => 'nav',
										'container_class' => 'col-12',
										//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
										'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
										'theme_location'  => 'footer-menu-3',
										'items_wrap'      => '<ul class="menu nav">%3$s</ul>',
									)
								);
							endif; ?>
						</div>
					</div><!-- /.row -->
				</div><!-- /.container -->
				<div class="row flex-column flex-md-row subfooter bg-lt-gray pt-4 pb-3 justify-content-center justify-content-sm-start">
					<div class="col subfooter-col-1 d-flex align-items-center text-center text-sm-start"><?php
																				if (is_active_sidebar('third_widget_area')) :
																					?>
								<div class="col-12 d-flex flex-column align-items-center justify-content-center">
								<?php
									dynamic_sidebar('third_widget_area');

									if (current_user_can('manage_options')) :
								?>
									<span class="edit-link"><a href="<?php echo esc_url(admin_url('widgets.php')); ?>" class="badge bg-secondary"><?php esc_html_e('Edit', 'mediafast'); ?></a></span>
									<!-- Show Edit Widget link -->
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>

					<div class="col subfooter-col-2 d-flex flex-column align-items-center justify-content-center bg-lt-gray py-3 py-md-2">
						<small class="text-secondary text-center text-lg-start m-0"><?php printf(esc_html__('&copy; %1$s %2$s. All rights reserved.', 'MediaFast'), wp_date('Y'), get_bloginfo('name', 'display')); ?></small>
						<?php
						$footer_link_1 = get_field('footer_link_1', 'option');
						$footer_link_2 = get_field('footer_link_2', 'option');
						?>
						<?php if ($footer_link_1 || $footer_link_2) : ?>
							<div class="footer-links d-flex flex-wrap align-items-center justify-content-center mt-2">
								<?php if ($footer_link_1) : ?>
									<a href="<?php echo esc_url($footer_link_1['url']); ?>" 
									   target="<?php echo esc_attr($footer_link_1['target'] ?: '_self'); ?>"
									   class="text-secondary text-decoration-none footer-link">
										<?php echo esc_html($footer_link_1['title']); ?>
									</a>
								<?php endif; ?>
								<?php if ($footer_link_1 && $footer_link_2) : ?>
									<span class="text-secondary">|</span>
								<?php endif; ?>
								<?php if ($footer_link_2) : ?>
									<a href="<?php echo esc_url($footer_link_2['url']); ?>" 
									   target="<?php echo esc_attr($footer_link_2['target'] ?: '_self'); ?>"
									   class="text-secondary text-decoration-none footer-link">
										<?php echo esc_html($footer_link_2['title']); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="col subfooter-col-3 d-flex align-items-center justify-content-center text-center text-sm-start">
						<?php if ($footer_logo) : ?>
							<div class="logo-container px-4">
								<img width="100%" src="<?php echo esc_url($footer_logo['url']); ?>" alt="<?php echo esc_attr($footer_logo['alt']); ?>" loading="lazy" />
							</div>
						<?php endif; ?>
					</div>

				</div>
				
				
			</footer><!-- /#footer -->
			</div><!-- /#wrapper -->
			<?php
			wp_footer();
			?>

		</body>

	</html>