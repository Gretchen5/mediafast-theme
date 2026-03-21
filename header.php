<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
	<noscript><link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet"></noscript>

	<meta name="google-site-verification" content="Xzj4dwT9gpuiESyf2pG3gkOJYdmBYd3eHjHyP2AckT8" />
	<meta name="facebook-domain-verification" content="rsmas89cpk5tspdenfdqqhkpbh09wi" />
	
	<script async>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-57G56Q2');
	</script>
	<?php wp_head(); ?>
</head>

<?php
$navbar_scheme   = get_theme_mod('navbar_scheme'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled  = get_theme_mod('search_enabled', '1'); // Get custom meta-value.

?>

<body <?php body_class(); ?>>
	<noscript>
	<iframe loading="lazy" src="https://www.googletagmanager.com/ns.html?id=GTM-57G56Q2"
	height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>

	<?php wp_body_open(); ?>

	<a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'mediafast'); ?></a>

	<div id="wrapper">
	<header>
			<nav id="header" class="navbar navbar-expand-xl py-3 border-bottom border-color-gray border-4 <?php
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
					?>
				<?php if (is_active_sidebar('secondary_widget_area')) : ?>
					<div class="navbar-extra pt-3 pt-md-0">
						<?php dynamic_sidebar('secondary_widget_area'); ?>
					</div>
				<?php endif; ?>
					<button type="button" class="btn search-toggle-btn align-self-center" id="searchToggle"
						aria-label="<?php esc_attr_e('Open search', 'mediafast'); ?>"
						aria-expanded="false" aria-controls="searchOverlay">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
						</svg>
					</button>
				</div>
			</div>
				</div><!-- /.container -->
			</nav><!-- /#header -->
		</header>

		<div id="searchOverlay" class="search-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Search', 'mediafast'); ?>" hidden>
		<div class="search-overlay__inner">
			<button type="button" class="search-overlay__close" id="searchOverlayClose" aria-label="<?php esc_attr_e('Close search', 'mediafast'); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
					<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
				</svg>
			</button>
			<p class="search-overlay__label"><?php esc_html_e('Search MediaFast', 'mediafast'); ?></p>
			<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-overlay__form search-form">
				<div class="search-overlay__input-wrap">
					<input type="search" name="s" id="searchOverlayInput" class="search-overlay__input"
						placeholder="<?php esc_attr_e('What are you looking for?', 'mediafast'); ?>"
						autocomplete="off"
						value="<?php echo esc_attr(get_search_query()); ?>" />
					<button type="submit" class="search-overlay__submit" aria-label="<?php esc_attr_e('Submit search', 'mediafast'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
							<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
						</svg>
					</button>
				</div>
			</form>
			<nav class="search-overlay__popular" aria-label="<?php esc_attr_e('Popular searches', 'mediafast'); ?>">
				<span><?php esc_html_e('Popular:', 'mediafast'); ?></span>
			<a href="<?php echo esc_url(home_url('/video-brochure/')); ?>">Video Brochures</a>
			<a href="<?php echo esc_url(home_url('/video-mailer/')); ?>">Video Mailers</a>
			<a href="<?php echo esc_url(home_url('/video-box/')); ?>">Video Boxes</a>
				<a href="<?php echo esc_url(home_url('/contact-us/')); ?>">Contact Us</a>
			</nav>
		</div>
	</div>

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