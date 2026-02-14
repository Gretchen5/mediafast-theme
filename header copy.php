<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<?php
$navbar_scheme   = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled  = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
?>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'mediafast'); ?></a>

	<div id="wrapper">
		<header>
			<nav id="header" class="navbar navbar-expand-xl header-dark
    			<?php
				echo esc_attr($navbar_scheme);

				if (isset($navbar_position) && 'fixed_top' === $navbar_position) {
					echo ' fixed-top';
				} elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) {
					echo ' fixed-bottom';
				}

				// Add border classes only if NOT home/front page
				if (!is_front_page()) {
					echo ' border-bottom border-color-gray border-4';
				} else {
					echo ' home';
				}
				?>">
				<div class="container-fluid px-0 margin-top-logged-in">
					<div class="col-auto">
						<a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<?php
							$header_logo = get_theme_mod('header_logo'); // default logo

							// Hard-coded front-page logo
							$front_logo = get_stylesheet_directory_uri() . '/assets/images/mediafast_logo_white.svg';

							if ( is_front_page() ) {
								// Use custom front-page logo
								$logo_to_use = $front_logo;
							} else {
								// Use regular logo from Customizer
								$logo_to_use = $header_logo;
							}

							if ( ! empty( $logo_to_use ) ) :
							?>
								<img src="<?php echo esc_url($logo_to_use); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
							<?php
							else :
								echo esc_attr(get_bloginfo('name', 'display'));
							endif;
							?>

						</a>
					</div>
					<div class="col-auto menu-order position-static xs-ps-0 align-self-center">
						<button class="navbar-toggler float-start align-self-center <?php echo is_front_page() ? 'toggler-white' : 'toggler-dark'; ?>"
							type="button"
							data-bs-toggle="offcanvas"
							data-bs-target="#mobileMenu"
							aria-controls="mobileMenu"
							aria-label="Toggle navigation">
							<span class="navbar-toggler-line"></span>
							<span class="navbar-toggler-line"></span>
							<span class="navbar-toggler-line"></span>
							<span class="navbar-toggler-line"></span>
						</button>


						<div class="offcanvas offcanvas-end bg-secondary" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
							<div class="offcanvas-header pt-75">
								<h5 id="mobileMenuLabel"><?php bloginfo('name'); ?></h5>
								<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
							</div>

							<div class="offcanvas-body">
								<?php
								wp_nav_menu(array(
									'menu_class'     => 'navbar-nav',
									'container'      => '',
									'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
									'walker'         => new WP_Bootstrap_Navwalker(),
									'theme_location' => 'main-menu',
								));
								?>
							</div>
						</div>

					</div><!-- /.navbar-collapse -->
				</div><!-- /.container -->
			</nav><!-- /#header -->
		</header>

		<main id="main" <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' style="padding-top: 100px;"';
						elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' style="padding-bottom: 100px;"';
						endif; ?>>
			<?php
			// If Single or Archive (Category, Tag, Author or a Date based page).
			if (is_single() || is_archive()) :
			?>
				<div class="row">
					<div class="col-12">
					<?php
				endif;
					?>