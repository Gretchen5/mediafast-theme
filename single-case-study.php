<?php

/**
 * The Template for displaying all single case study posts.
 */

get_header();

if (have_posts()) :
	while (have_posts()) :
		the_post();

		get_template_part('content', 'single');

	endwhile;
endif;

global $post;
if (empty($post)) {
	$post = get_queried_object();
}

// Get previous and next case studies across ALL categories (not filtered by taxonomy)
// Use a direct WP_Query with explicit parameters to bypass any taxonomy filters

global $wpdb;
$current_post_id = $post->ID;
$current_date = get_the_date('Y-m-d H:i:s', $post->ID);

// Get previous case study (newer date) - using direct query to bypass all filters
$prev_post_id = $wpdb->get_var($wpdb->prepare(
	"SELECT ID FROM {$wpdb->posts} 
	WHERE post_type = 'case-study' 
	AND post_status = 'publish' 
	AND post_date > %s 
	ORDER BY post_date ASC 
	LIMIT 1",
	$current_date
));

// Get next case study (older date) - using direct query to bypass all filters
$next_post_id = $wpdb->get_var($wpdb->prepare(
	"SELECT ID FROM {$wpdb->posts} 
	WHERE post_type = 'case-study' 
	AND post_status = 'publish' 
	AND post_date < %s 
	ORDER BY post_date DESC 
	LIMIT 1",
	$current_date
));

$prev_post = $prev_post_id ? get_post($prev_post_id) : null;
$next_post = $next_post_id ? get_post($next_post_id) : null;
?>

<nav class="custom-pagination case-studies pt-5" style="border-bottom: 1px solid #757575; padding-bottom: 2rem;">
	<ul class="pagination justify-content-center">
		<?php if ($prev_post) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" aria-label="Previous case study">
					&larr;
				</a>
			</li>
		<?php endif; ?>

		<?php if ($next_post) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" aria-label="Next case study">
					&rarr;
				</a>
			</li>
		<?php endif; ?>
	</ul>
</nav>

			</div><!-- /.col-12 -->
		</div><!-- /.row -->
<?php
get_footer();
