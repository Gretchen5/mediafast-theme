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

// Previous testimonial (newer date)
$prev_post = get_posts([
	'post_type'      => 'testimonial',
	'posts_per_page' => 1,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish',
	'date_query'     => [
		['after' => get_the_date('Y-m-d H:i:s', $post)],
	],
]);

// Next testimonial (older date)
$next_post = get_posts([
	'post_type'      => 'testimonial',
	'posts_per_page' => 1,
	'orderby'        => 'date',
	'order'          => 'ASC',
	'post_status'    => 'publish',
	'date_query'     => [
		['before' => get_the_date('Y-m-d H:i:s', $post)],
	],
]);

$prev_post = ! empty($prev_post) ? $prev_post[0] : null;
$next_post = ! empty($next_post) ? $next_post[0] : null;
?>

<nav class="custom-pagination testimonials pt-5">
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

<?php
get_footer();
