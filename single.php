<?php

/**
 * The Template for displaying all single posts.
 */

get_header();

if (have_posts()) :
	while (have_posts()) :
		the_post();

		get_template_part('content', 'single');

	// If comments are open or we have at least one comment, load up the comment template.
	// if ( comments_open() || get_comments_number() ) :
	// 	comments_template();
	// endif;
	endwhile;
endif;

wp_reset_postdata();

$count_posts = wp_count_posts();

if ($count_posts->publish > 1) :
	$next_post = get_next_post();
	$prev_post = get_previous_post();
?>
	<nav class="custom-pagination pt-5" style="border-bottom: 1px solid #757575; padding-bottom: 2rem;">
		<ul class="pagination justify-content-center">
			<?php if ($prev_post) : ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" title="<?php echo esc_attr(get_the_title($prev_post->ID)); ?>">
						&larr;
					</a>
				</li>
			<?php endif; ?>

			<?php if ($next_post) : ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" title="<?php echo esc_attr(get_the_title($next_post->ID)); ?>">
						&rarr;
					</a>
				</li>
			<?php endif; ?>
		</ul>
	</nav>
<?php endif; ?>

			</div><!-- /.col-12 -->
		</div><!-- /.row -->
<?php
get_footer();
