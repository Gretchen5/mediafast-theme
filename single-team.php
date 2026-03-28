<?php

/**
 * The Template for displaying all single team member posts.
 */

get_header();

if (have_posts()) :
	while (have_posts()) :
		the_post();

		$headshot  = get_field('team_headshot');
		$job_title = get_field('team_job_title');
		$bio       = get_field('team_bio');
		$email     = get_field('team_email');
		$linkedin  = get_field('team_linkedin_url');
		?>

<article id="post-<?php the_ID(); ?>" <?php post_class('team-member-single'); ?>>
	<div class="container pt-5 pb-5">
		<div class="row g-5 align-items-start">

			<!-- Content: left column -->
			<div class="col-12 order-2 order-md-1 <?php echo $headshot ? 'col-md-7 col-lg-8' : ''; ?>">

				<h1 class="text-cyan mb-1"><?php the_title(); ?></h1>

				<?php if ($job_title) : ?>
					<p class="fw-bold text-secondary fs-5 mb-2"><?php echo esc_html($job_title); ?></p>
				<?php endif; ?>

				<?php if ($linkedin) : ?>
					<div class="team-member-single__linkedin mb-4">
						<a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center gap-2 text-decoration-none text-secondary" aria-label="<?php echo esc_attr(get_the_title()); ?> on LinkedIn">
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
								<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
							</svg>
						</a>
					</div>
				<?php endif; ?>

				<?php if ($bio) : ?>
					<div class="team-member-single__bio entry-content">
						<?php echo wp_kses_post($bio); ?>
					</div>
				<?php endif; ?>

				<?php
				$additional_content = get_the_content();
				if ($additional_content) :
				?>
					<div class="team-member-single__content entry-content mt-4">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

				<?php if ($email) : ?>
					<div class="team-member-single__email mt-4">
						<a href="mailto:<?php echo esc_attr($email); ?>" class="btn btn-outline-secondary btn-sm">
							Email <?php echo esc_html(get_the_title()); ?>
						</a>
					</div>
				<?php endif; ?>

			</div><!-- /.col content -->

			<!-- Headshot: right column -->
			<?php if ($headshot) : ?>
				<div class="col-12 order-1 order-md-2 col-md-5 col-lg-4">
					<div class="team-member-single__headshot">
						<?php echo mediafast_get_optimized_image($headshot, 'acf-medium', array(
							'class' => 'img-fluid',
							'alt'   => $headshot['alt'] ?: get_the_title(),
						)); ?>
					</div>
				</div>
			<?php endif; ?>

		</div><!-- /.row -->

		<?php edit_post_link(__('Edit', 'mediafast'), '<span class="edit-link">', '</span>'); ?>

	</div><!-- /.container -->
</article><!-- /#post-<?php the_ID(); ?> -->

		<?php
	endwhile;
endif;

global $post;
if (empty($post)) {
	$post = get_queried_object();
}

global $wpdb;
$current_post_id = $post->ID;
$current_date    = get_the_date('Y-m-d H:i:s', $post->ID);

$prev_post_id = $wpdb->get_var($wpdb->prepare(
	"SELECT ID FROM {$wpdb->posts}
	WHERE post_type = 'team'
	AND post_status = 'publish'
	AND post_date > %s
	ORDER BY post_date ASC
	LIMIT 1",
	$current_date
));

$next_post_id = $wpdb->get_var($wpdb->prepare(
	"SELECT ID FROM {$wpdb->posts}
	WHERE post_type = 'team'
	AND post_status = 'publish'
	AND post_date < %s
	ORDER BY post_date DESC
	LIMIT 1",
	$current_date
));

$prev_post = $prev_post_id ? get_post($prev_post_id) : null;
$next_post = $next_post_id ? get_post($next_post_id) : null;
?>

<nav class="custom-pagination team pt-5" style="border-bottom: 1px solid #757575; padding-bottom: 2rem;">
	<ul class="pagination justify-content-center">
		<?php if ($prev_post) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" aria-label="Previous team member">
					&larr;
				</a>
			</li>
		<?php endif; ?>

		<?php if ($next_post) : ?>
			<li class="page-item">
				<a class="page-link" href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" aria-label="Next team member">
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
