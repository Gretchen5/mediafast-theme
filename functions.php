<?php

/**
 * Include Theme Customizer.
 *
 * @since v1.0
 */

function mediafast_enqueue_scripts()
{
	wp_enqueue_script('jquery');
	wp_add_inline_script('jquery', 'var $ = jQuery;', 'after');
}
add_action('wp_enqueue_scripts', 'mediafast_enqueue_scripts');

// Inside template-parts/functions/enqueue.php
/**
 * Include Enqueue Assets.
 *
 */
$enqueue_assets = __DIR__ . '/template-parts/functions/enqueue.php';
if (is_readable($enqueue_assets)) {
	require_once $enqueue_assets;
}
$theme_customizer = __DIR__ . '/inc/customizer.php';
if (is_readable($theme_customizer)) {
	require_once $theme_customizer;
}


if (! function_exists('mediafast_setup_theme')) {
	/**
	 * General Theme Settings.
	 *
	 * @since v1.0
	 *
	 * @return void
	 */
	function mediafast_setup_theme()
	{
		// Make theme available for translation: Translations can be filed in the /languages/ directory.
		load_theme_textdomain('mediafast', __DIR__ . '/languages');

		/**
		 * Set the content width based on the theme's design and stylesheet.
		 *
		 * @since v1.0
		 */
		global $content_width;
		if (! isset($content_width)) {
			$content_width = 800;
		}

		// Theme Support.
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		// Add support for Block Styles.
		add_theme_support('wp-block-styles');
		// Add support for full and wide alignment.
		add_theme_support('align-wide');
		// Add support for Editor Styles.
		add_theme_support('editor-styles');
		// Enqueue Editor Styles.
		add_editor_style('style-editor.css');

		// Default attachment display settings.
		update_option('image_default_align', 'none');
		update_option('image_default_link_type', 'none');
		update_option('image_default_size', 'large');

		// Custom CSS styles of WorPress gallery.
		add_filter('use_default_gallery_style', '__return_false');
	}
	add_action('after_setup_theme', 'mediafast_setup_theme');

	/**
	 * Enqueue editor stylesheet (for iframed Post Editor):
	 * https://make.wordpress.org/core/2023/07/18/miscellaneous-editor-changes-in-wordpress-6-3/#post-editor-iframed
	 *
	 * @since v3.5.1
	 *
	 * @return void
	 */
	function mediafast_load_editor_styles()
	{
		if (is_admin()) {
			$theme_version = wp_get_theme()->get('Version');
			wp_enqueue_style('editor-style', get_theme_file_uri('style-editor.css'), array(), $theme_version);
		}
	}
	add_action('enqueue_block_assets', 'mediafast_load_editor_styles');

	// Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
	remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
	remove_action('enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory');
}

if (! function_exists('wp_body_open')) {
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 *
	 * @since v2.2
	 *
	 * @return void
	 */
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
}

if (! function_exists('mediafast_add_user_fields')) {
	/**
	 * Add new User fields to Userprofile:
	 * get_user_meta( $user->ID, 'facebook_profile', true );
	 *
	 * @since v1.0
	 *
	 * @param array $fields User fields.
	 *
	 * @return array
	 */
	function mediafast_add_user_fields($fields)
	{
		// Add new fields.
		$fields['facebook_profile'] = 'Facebook URL';
		$fields['twitter_profile']  = 'Twitter URL';
		$fields['linkedin_profile'] = 'LinkedIn URL';
		$fields['xing_profile']     = 'Xing URL';
		$fields['github_profile']   = 'GitHub URL';

		return $fields;
	}
	add_filter('user_contactmethods', 'mediafast_add_user_fields');
}

/**
 * Test if a page is a blog page.
 * if ( is_blog() ) { ... }
 *
 * @since v1.0
 *
 * @global WP_Post $post Global post object.
 *
 * @return bool
 */
function is_blog()
{
	global $post;
	$posttype = get_post_type($post);

	return ((is_archive() || is_author() || is_category() || is_home() || is_single() || (is_tag() && ('post' === $posttype))) ? true : false);
}

/**
 * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
 *
 * @since v1.0
 *
 * @param bool $open    Comments open/closed.
 * @param int  $post_id Post ID.
 *
 * @return bool
 */
function mediafast_filter_media_comment_status($open, $post_id = null)
{
	$media_post = get_post($post_id);

	if ('attachment' === $media_post->post_type) {
		return false;
	}

	return $open;
}
add_filter('comments_open', 'mediafast_filter_media_comment_status', 10, 2);

/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 *
 * @param string $link Post Edit Link.
 *
 * @return string
 */
function mediafast_custom_edit_post_link($link)
{
	return str_replace('class="post-edit-link"', 'class="post-edit-link badge bg-secondary"', $link);
}
add_filter('edit_post_link', 'mediafast_custom_edit_post_link');

/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 *
 * @param string $link Comment Edit Link.
 */
function mediafast_custom_edit_comment_link($link)
{
	return str_replace('class="comment-edit-link"', 'class="comment-edit-link badge bg-secondary"', $link);
}
add_filter('edit_comment_link', 'mediafast_custom_edit_comment_link');

/**
 * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
 *
 * @since v1.0
 *
 * @param string $html Inner HTML.
 *
 * @return string
 */
function mediafast_oembed_filter($html)
{
	return '<div class="ratio ratio-16x9">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'mediafast_oembed_filter', 10);

if (! function_exists('mediafast_content_nav')) {
	/**
	 * Display a navigation to next/previous pages when applicable.
	 *
	 * @since v1.0
	 *
	 * @param string $nav_id Navigation ID.
	 */
	function mediafast_content_nav($nav_id)
	{
		global $wp_query;

		if ($wp_query->max_num_pages > 1) {
?>
			<div id="<?php echo esc_attr($nav_id); ?>" class="d-flex mb-4 justify-content-between">
				<div><?php next_posts_link('<span aria-hidden="true">&larr;</span> ' . esc_html__('Older posts', 'mediafast')); ?></div>
				<div><?php previous_posts_link(esc_html__('Newer posts', 'mediafast') . ' <span aria-hidden="true">&rarr;</span>'); ?></div>
			</div><!-- /.d-flex -->
			<?php
		} else {
			echo '<div class="clearfix"></div>';
		}
	}

	/**
	 * Add Class.
	 *
	 * @since v1.0
	 *
	 * @return string
	 */
	function posts_link_attributes()
	{
		return 'class="btn btn-secondary btn-lg"';
	}
	add_filter('next_posts_link_attributes', 'posts_link_attributes');
	add_filter('previous_posts_link_attributes', 'posts_link_attributes');
}

/**
 * Init Widget areas in Sidebar.
 *
 * @since v1.0
 *
 * @return void
 */
function mediafast_widgets_init()
{
	// Area 1.
	register_sidebar(
		array(
			'name'          => 'Primary Widget Area (Sidebar)',
			'id'            => 'primary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Area 2.
	register_sidebar(
		array(
			'name'          => 'Secondary Widget Area (Header Navigation)',
			'id'            => 'secondary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Area 3.
	register_sidebar(
		array(
			'name'          => 'Third Widget Area (Footer)',
			'id'            => 'third_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action('widgets_init', 'mediafast_widgets_init');

if (! function_exists('mediafast_article_posted_on')) {
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function mediafast_article_posted_on()
	{
		printf(
			wp_kses_post(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'mediafast')),
			esc_url(get_permalink()),
			esc_attr(get_the_date() . ' - ' . get_the_time()),
			esc_attr(get_the_date('c')),
			esc_html(get_the_date() . ' - ' . get_the_time()),
			esc_url(get_author_posts_url((int) get_the_author_meta('ID'))),
			sprintf(esc_attr__('View all posts by %s', 'mediafast'), get_the_author()),
			get_the_author()
		);
	}
}

/**
 * Template for Password protected post form.
 *
 * @since v1.0
 *
 * @global WP_Post $post Global post object.
 *
 * @return string
 */
function mediafast_password_form()
{
	global $post;
	$label = 'pwbox-' . (empty($post->ID) ? wp_rand() : $post->ID);

	$output                  = '<div class="row">';
	$output             .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">';
	$output             .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__('This content is password protected. To view it please enter your password below.', 'mediafast') . '</h4>';
	$output         .= '<div class="col-md-6">';
	$output     .= '<div class="input-group">';
	$output .= '<input type="password" name="post_password" id="' . esc_attr($label) . '" placeholder="' . esc_attr__('Password', 'mediafast') . '" class="form-control" />';
	$output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__('Submit', 'mediafast') . '" /></div>';
	$output     .= '</div><!-- /.input-group -->';
	$output         .= '</div><!-- /.col -->';
	$output             .= '</form>';
	$output                 .= '</div><!-- /.row -->';

	return $output;
}
add_filter('the_password_form', 'mediafast_password_form');


if (! function_exists('mediafast_comment')) {
	/**
	 * Style Reply link.
	 *
	 * @since v1.0
	 *
	 * @param string $link Link output.
	 *
	 * @return string
	 */
	function mediafast_replace_reply_link_class($link)
	{
		return str_replace("class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $link);
	}
	add_filter('comment_reply_link', 'mediafast_replace_reply_link_class');

	/**
	 * Template for comments and pingbacks:
	 * add function to comments.php ... wp_list_comments( array( 'callback' => 'mediafast_comment' ) );
	 *
	 * @since v1.0
	 *
	 * @param object $comment Comment object.
	 * @param array  $args    Comment args.
	 * @param int    $depth   Comment depth.
	 */
	function mediafast_comment($comment, $args, $depth)
	{
		$GLOBALS['comment'] = $comment;
		switch ($comment->comment_type):
			case 'pingback':
			case 'trackback':
			?>
				<li class="post pingback">
					<p>
						<?php
						esc_html_e('Pingback:', 'mediafast');
						comment_author_link();
						edit_comment_link(esc_html__('Edit', 'mediafast'), '<span class="edit-link">', '</span>');
						?>
					</p>
				<?php
				break;
			default:
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<footer class="comment-meta">
							<div class="comment-author vcard">
								<?php
								$avatar_size = ('0' !== $comment->comment_parent ? 68 : 136);
								echo get_avatar($comment, $avatar_size);

								/* Translators: 1: Comment author, 2: Date and time */
								printf(
									wp_kses_post(__('%1$s, %2$s', 'mediafast')),
									sprintf('<span class="fn">%s</span>', get_comment_author_link()),
									sprintf(
										'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
										esc_url(get_comment_link($comment->comment_ID)),
										get_comment_time('c'),
										/* Translators: 1: Date, 2: Time */
										sprintf(esc_html__('%1$s ago', 'mediafast'), human_time_diff((int) get_comment_time('U'), current_time('timestamp')))
									)
								);

								edit_comment_link(esc_html__('Edit', 'mediafast'), '<span class="edit-link">', '</span>');
								?>
							</div><!-- .comment-author .vcard -->

							<?php if ('0' === $comment->comment_approved) { ?>
								<em class="comment-awaiting-moderation">
									<?php esc_html_e('Your comment is awaiting moderation.', 'mediafast'); ?>
								</em>
								<br />
							<?php } ?>
						</footer>

						<div class="comment-content"><?php comment_text(); ?></div>

						<div class="reply">
							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'reply_text' => esc_html__('Reply', 'mediafast') . ' <span>&darr;</span>',
										'depth'      => $depth,
										'max_depth'  => $args['max_depth'],
									)
								)
							);
							?>
						</div><!-- /.reply -->
					</article><!-- /#comment-## -->
			<?php
				break;
		endswitch;
	}

	/**
	 * Custom Comment form.
	 *
	 * @since v1.0
	 * @since v1.1: Added 'submit_button' and 'submit_field'
	 * @since v2.0.2: Added '$consent' and 'cookies'
	 *
	 * @param array $args    Form args.
	 * @param int   $post_id Post ID.
	 *
	 * @return array
	 */
	function mediafast_custom_commentform($args = array(), $post_id = null)
	{
		if (null === $post_id) {
			$post_id = get_the_ID();
		}

		$commenter     = wp_get_current_commenter();
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = wp_parse_args($args);

		$req      = get_option('require_name_email');
		$aria_req = ($req ? " aria-required='true' required" : '');
		$consent  = (empty($commenter['comment_author_email']) ? '' : ' checked="checked"');
		$fields   = array(
			'author'  => '<div class="form-floating mb-3">
							<input type="text" id="author" name="author" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . esc_html__('Name', 'mediafast') . ($req ? '*' : '') . '"' . $aria_req . ' />
							<label for="author">' . esc_html__('Name', 'mediafast') . ($req ? '*' : '') . '</label>
						</div>',
			'email'   => '<div class="form-floating mb-3">
							<input type="email" id="email" name="email" class="form-control" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . esc_html__('Email', 'mediafast') . ($req ? '*' : '') . '"' . $aria_req . ' />
							<label for="email">' . esc_html__('Email', 'mediafast') . ($req ? '*' : '') . '</label>
						</div>',
			'url'     => '',
			'cookies' => '<p class="form-check mb-3 comment-form-cookies-consent">
							<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"' . $consent . ' />
							<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__('Save my name, email, and website in this browser for the next time I comment.', 'mediafast') . '</label>
						</p>',
		);

		$defaults = array(
			'fields'               => apply_filters('comment_form_default_fields', $fields),
			'comment_field'        => '<div class="form-floating mb-3">
											<textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . esc_attr__('Comment', 'mediafast') . ($req ? '*' : '') . '"></textarea>
											<label for="comment">' . esc_html__('Comment', 'mediafast') . '</label>
										</div>',
			/** This filter is documented in wp-includes/link-template.php */
			'must_log_in'          => '<p class="must-log-in">' . sprintf(wp_kses_post(__('You must be <a href="%s">logged in</a> to post a comment.', 'mediafast')), wp_login_url(esc_url(get_permalink(get_the_ID())))) . '</p>',
			/** This filter is documented in wp-includes/link-template.php */
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf(wp_kses_post(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'mediafast')), get_edit_user_link(), $user->display_name, wp_logout_url(apply_filters('the_permalink', esc_url(get_permalink(get_the_ID()))))) . '</p>',
			'comment_notes_before' => '<p class="small comment-notes">' . esc_html__('Your Email address will not be published.', 'mediafast') . '</p>',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_submit'         => 'btn btn-primary',
			'name_submit'          => 'submit',
			'title_reply'          => '',
			'title_reply_to'       => esc_html__('Leave a Reply to %s', 'mediafast'),
			'cancel_reply_link'    => esc_html__('Cancel reply', 'mediafast'),
			'label_submit'         => esc_html__('Post Comment', 'mediafast'),
			'submit_button'        => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
			'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
			'format'               => 'html5',
		);

		return $defaults;
	}
	add_filter('comment_form_defaults', 'mediafast_custom_commentform');
}

if (function_exists('register_nav_menus')) {
	/**
	 * Nav menus.
	 *
	 * @since v1.0
	 *
	 * @return void
	 */
	register_nav_menus(
		array(
			'main-menu'   => 'Main Navigation Menu',
			'footer-menu-1' => 'Footer Menu 1',
			'footer-menu-2' => 'Footer Menu 2',
			'footer-menu-3' => 'Footer Menu 3',
		)
	);
}

// Custom Nav Walker: wp_bootstrap_navwalker().
$custom_walker = __DIR__ . '/inc/wp-bootstrap-navwalker.php';
if (is_readable($custom_walker)) {
	require_once $custom_walker;
}

$custom_walker_footer = __DIR__ . '/inc/wp-bootstrap-navwalker-footer.php';
if (is_readable($custom_walker_footer)) {
	require_once $custom_walker_footer;
}

/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 *
 * @return void
 */
function mediafast_scripts_loader()
{
	$theme_version = wp_get_theme()->get('Version');

	// 1. Styles.
	wp_enqueue_style('style', get_theme_file_uri('style.css'), array(), $theme_version, 'all');
	wp_enqueue_style('main', get_theme_file_uri('build/main.css'), array(), $theme_version, 'all'); // main.scss: Compiled Framework source + custom styles.

	if (is_rtl()) {
		wp_enqueue_style('rtl', get_theme_file_uri('build/rtl.css'), array(), $theme_version, 'all');
	}

	// 2. Scripts.
	wp_enqueue_script('mainjs', get_theme_file_uri('build/main.js'), array(), $theme_version, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'mediafast_scripts_loader');

/**
 * Add page slug to body class for reliable targeting across environments.
 * Page IDs differ between local/staging/production; slug is consistent.
 *
 * @param array $classes Existing body classes.
 * @return array Modified body classes.
 */
function mediafast_body_class_page_slug($classes) {
	if (is_singular()) {
		$post = get_queried_object();
		if ($post && isset($post->post_name) && !empty($post->post_name)) {
			$slug = sanitize_html_class($post->post_name);
			$classes[] = 'page-slug-' . $slug;
		}
	}
	return $classes;
}
add_filter('body_class', 'mediafast_body_class_page_slug');


// Zade Balance Custom Functions

// Add ACF Blocks
require_once get_template_directory() . '/inc/acf-blocks.php';


// Ensure all blog images are rendered the same size 
add_action('after_setup_theme', function () {
	add_image_size('post-card-thumb', 600, 400, true);
	add_image_size('post-featured', 1200, 700, true);
	add_image_size('post-display-thumbnail', 400, 208, true); // 1.92:1 aspect ratio for post display cards
});

// Add Bootstrap Icons Inline to Card Components

function get_inline_icon($name)
{
	$file = get_template_directory() . "/assets/images/{$name}.svg";
	if (file_exists($file)) {
		return file_get_contents($file);
	}
	return '';
}

// Add ACF Select Field for Icons
add_filter('acf/load_field/name=card_icon', 'populate_icon_choices');
function populate_icon_choices($field)
{
	$icons_path = get_template_directory() . '/assets/images/';
	if (file_exists($icons_path)) {
		$icons = glob($icons_path . '*.svg');
		if ($icons) {
			foreach ($icons as $file) {
				$name = basename($file, '.svg'); // remove .svg extension
				$field['choices'][$name] = ucfirst(str_replace('-', ' ', $name)); // prettier label
			}
		}
	}
	return $field;
}



// Load Shared Modal Template Conditionally

add_action('wp_footer', 'load_shared_modal');
function load_shared_modal()
{
	get_template_part('template-parts/blocks/creative-content-blocks/shared_modal');
}


// Reverse Gallery CPT Order
add_action('pre_get_posts', 'reverse_gallery_order');
function reverse_gallery_order($query)
{
	if (!is_admin() && $query->is_main_query() && is_post_type_archive('gallery')) {
		$query->set('order', 'ASC'); // Change to DESC for reverse chronological
		$query->set('orderby', 'date'); // Or 'title' or 'menu_order'
	}
}

// Removed: custom_posts_per_page_for_cpt (redundant; custom_posts_per_page handles all CPTs)

// Add Gallery Type column to the Galleries CPT admin list
add_filter('manage_gallery_posts_columns', 'add_gallery_type_column');
function add_gallery_type_column($columns)
{
	$new_columns = [];

	foreach ($columns as $key => $value) {
		if ($key === 'date') {
			$new_columns['galleries'] = __('Gallery Type');
		}
		$new_columns[$key] = $value;
	}

	return $new_columns;
}
add_action('manage_gallery_posts_custom_column', 'show_gallery_type_column', 10, 2);
function show_gallery_type_column($column, $post_id)
{
	if ($column === 'galleries') {
		$terms = get_the_term_list($post_id, 'galleries', '', ', ', '');
		echo $terms ? $terms : '—';
	}
}

// Make Gallery Type column sortable
add_action('restrict_manage_posts', 'filter_galleries_by_gallery_type');
function filter_galleries_by_gallery_type()
{
	global $typenow;
	if ($typenow === 'gallery') {
		$taxonomy = 'galleries';
		$selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);

		wp_dropdown_categories([
			'show_option_all' => __("All {$info_taxonomy->label}"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		]);
	}
}

add_filter('parse_query', 'convert_gallery_type_filter_to_query');
function convert_gallery_type_filter_to_query($query)
{
	global $pagenow;
	$post_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';

	if ($pagenow === 'edit.php' && $post_type === 'gallery' && isset($_GET['galleries']) && is_numeric($_GET['galleries'])) {
		$term = get_term_by('id', $_GET['galleries'], 'galleries');
		if ($term) {
			$query->query_vars['galleries'] = $term->slug;
		}
	}
}

add_action('admin_footer-edit-tags.php', function () {
	if (isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'galleries') {
			?>
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const acfFields = document.querySelector('#acf-term-fields');
					if (acfFields) {
						acfFields.remove(); // Remove instead of hiding
					}
				});
			</script>
	<?php
	}
});

// Add theme colors to the Gutenberg Block Editor
add_action('after_setup_theme', function () {
	add_theme_support('editor-color-palette', [
		[
			'name'  => __('Dark Gray', 'mediafast'),
			'slug'  => 'dk-gray',
			'color' => '#757575',
		],
		[
			'name'  => __('Navy', 'mediafast'),
			'slug'  => 'secondary',
			'color' => '#1f355a',
		],
		[
			'name'  => __('Teal', 'mediafast'),
			'slug'  => 'teal',
			'color' => '#267798',
		],
		[
			'name'  => __('Cyan', 'mediafast'),
			'slug'  => 'cyan',
			'color' => '#027dad',
		],
		[
			'name'  => __('Gold', 'mediafast'),
			'slug'  => 'gold',
			'color' => '#bc9846',
		],
		[
			'name'  => __('Gold (Text)', 'mediafast'),
			'slug'  => 'gold-text',
			'color' => '#8B7032'
		],
		[
			'name'  => __('Gold (Background)', 'mediafast'),
			'slug'  => 'gold-background',
			'color' => '#bc9846',
		],
		[
			'name'  => __('Tan Background', 'mediafast'),
			'slug'  => 'tan-background',
			'color' => '#f4f1ed',
		],

	]);
});

// Format Navigation Menu for Gallery, Testimonials, and Blog Index page

add_filter('paginate_links_output', function ($output) {
	return preg_replace_callback('/>(\d+)</', function ($matches) {
		return '>' . str_pad($matches[1], 2, '0', STR_PAD_LEFT) . '<';
	}, $output);
});

// Set number of posts to be shown on blog index page and on archive pages
function custom_posts_per_page($query)
{
	if (is_admin() || ! $query->is_main_query()) {
		return;
	}

	if ($query->is_home() || $query->is_post_type_archive('post')) {
		$query->set('posts_per_page', 8);
		return;
	}

	if ($query->is_post_type_archive('gallery')) {
		$query->set('posts_per_page', 15);
		return;
	}

	if ($query->is_post_type_archive('testimonial')) {
		$query->set('posts_per_page', 15);
	}
}
add_action('pre_get_posts', 'custom_posts_per_page');

/**
 * Invalidate cached query transients when relevant posts are saved.
 * Ensures testimonial slider, case studies slider, and sidebar recent posts stay fresh.
 */
function mediafast_invalidate_query_transients($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	$post = get_post($post_id);
	if (! $post) {
		return;
	}
	switch ($post->post_type) {
		case 'testimonial':
			delete_transient('mediafast_testimonials_slider');
			break;
		case 'case-study':
			delete_transient('mediafast_case_studies_slider');
			break;
		case 'post':
			delete_transient('mediafast_sidebar_recent_posts');
			break;
	}
}
add_action('save_post', 'mediafast_invalidate_query_transients');

// Hide ACF "Pages Hero" on the taxonomy list page's Add form (keeps it visible on Edit Term)
add_action('acf/input/admin_head', function () {
    $screen = get_current_screen();
    if (!$screen || $screen->taxonomy !== 'industry' || $screen->base !== 'edit-tags') {
        return; // not the Industry list/add screen
    }

    // On the list page, the quick-add form is form#addtag; your ACF fields live in #acf-term-fields there.
    echo '<style>
        form#addtag #acf-term-fields { display: none !important; }
    </style>';
});



