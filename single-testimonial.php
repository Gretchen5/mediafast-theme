<?php

/**
 * The Template for displaying all single testimonial posts.
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

// Get previous and next testimonials across ALL categories (not filtered by taxonomy)
// Use a direct database query to bypass any taxonomy filters

// Get previous and next testimonials across ALL categories (not filtered by taxonomy)
// Get all testimonials and find adjacent posts by position

global $wpdb;
$current_post_id = $post->ID;

// Get all published testimonials ordered by date (newest first)
$all_testimonials = $wpdb->get_results($wpdb->prepare(
	"SELECT ID, post_date FROM {$wpdb->posts} 
	WHERE post_type = 'testimonial' 
	AND post_status = 'publish' 
	ORDER BY post_date DESC, ID DESC"
));

// Find current post's position
$current_index = false;
foreach ($all_testimonials as $index => $testimonial) {
	if ($testimonial->ID == $current_post_id) {
		$current_index = $index;
		break;
	}
}

// Get previous (newer) and next (older) posts
$prev_post = null;
$next_post = null;

if ($current_index !== false) {
	// Previous post (newer date) - index - 1
	if (isset($all_testimonials[$current_index - 1])) {
		$prev_post = get_post($all_testimonials[$current_index - 1]->ID);
	}
	
	// Next post (older date) - index + 1
	if (isset($all_testimonials[$current_index + 1])) {
		$next_post = get_post($all_testimonials[$current_index + 1]->ID);
	}
}
?>

<nav class="custom-pagination testimonials pt-5" style="border-bottom: 1px solid #757575; padding-bottom: 2rem;">
	<ul class="pagination justify-content-center">
		<?php if ($prev_post) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" aria-label="Previous testimonial">
					&larr;
				</a>
			</li>
		<?php endif; ?>

		<?php if ($next_post) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" aria-label="Next testimonial">
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
