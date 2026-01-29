<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
	<noscript><link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet"></noscript>

	<?php wp_head(); ?>
</head>

<?php
$navbar_scheme   = get_theme_mod('navbar_scheme'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled  = get_theme_mod('search_enabled', '1'); // Get custom meta-value.

?>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'mediafast'); ?></a>

	<div id="wrapper">
	<header>
			<nav id="header" class="navbar navbar-expand-xl py-3 border-bottom border-color-gold border-4 <?php
				echo esc_attr($navbar_scheme);

				if (isset($navbar_position) && 'fixed_top' === $navbar_position) {
					echo ' fixed-top';
				} elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) {
					echo ' fixed-bottom';
				}
				?>">
				<div class="container-fluid">
					<a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
					<?php
							$header_logo = get_theme_mod('header_logo');

							if ( ! empty( $header_logo ) ) :
								echo mediafast_get_optimized_image_from_url($header_logo, 'acf-small', array(
									'alt' => esc_attr(get_bloginfo('name', 'display')),
									'loading' => 'eager',
									'class' => 'img-fluid'
								));
							else :
								echo esc_attr(get_bloginfo('name', 'display'));
							endif;
							?>
					</a>

					<button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="<?php esc_attr_e('Toggle navigation menu', 'mediafast'); ?>">
						<span class="navbar-toggler-icon" aria-hidden="true"></span>
					</button>

					<!-- <div id="navbar" class="collapse navbar-collapse">
						<?php
						// Loading WordPress Custom Menu (theme_location).
						wp_nav_menu(
							array(
								'menu_class'     => 'navbar-nav ms-auto text-end',
								'container'      => '',
								'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
								'walker'         => new WP_Bootstrap_Navwalker(),
								'theme_location' => 'main-menu',
							)
						);

						if ('1' === $search_enabled) :
						?>
							<form class="search-form my-2 my-lg-0" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
								<div class="input-group">
									<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e('Search', 'thethirdspaceartcenter'); ?>" title="<?php esc_attr_e('Search', 'thethirdspaceartcenter'); ?>" />
									<button type="submit" name="submit" class="btn btn-outline-secondary"><?php esc_html_e('Search', 'thethirdspaceartcenter'); ?></button>
								</div>
							</form>
						<?php
						endif;
						?>
						<?php if (is_active_sidebar('secondary_widget_area')) : ?>
							<div class="navbar-extra">
								<?php dynamic_sidebar('secondary_widget_area'); ?>
							</div>
						<?php endif; ?>

					</div>/.navbar-collapse -->
					<div class="offcanvas offcanvas-start bg-secondary" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
						<div class="offcanvas-header">
							<h2 class="offcanvas-title text-white" id="mobileMenuLabel">Menu</h2>
							<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
						</div>
						<div class="offcanvas-body">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'main-menu',
									'menu_class'     => 'navbar-nav ms-auto text-lg-end',
									'container'      => '',
									'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
									'walker'         => new WP_Bootstrap_Navwalker(),
									'items_wrap'     => '<ul role="menubar" class="%2$s">%3$s</ul>',
								)
							);

							if ('1' === $search_enabled) :
							?>
								<form class="search-form my-2 my-lg-0" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
									<div class="input-group">
										<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e('Search', 'thethirdspaceartcenter'); ?>" title="<?php esc_attr_e('Search', 'thethirdspaceartcenter'); ?>" />
										<button type="submit" name="submit" class="btn btn-outline-secondary"><?php esc_html_e('Search', 'thethirdspaceartcenter'); ?></button>
									</div>
								</form>
							<?php
							endif;
							?>
							<?php if (is_active_sidebar('secondary_widget_area')) : ?>
								<div class="navbar-extra pt-3 pt-md-0">
									<?php dynamic_sidebar('secondary_widget_area'); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
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