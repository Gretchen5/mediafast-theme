<?php

/**
 * The template for displaying content in the archive-team.php template.
 */

$headshot  = get_field('team_headshot');
$job_title = get_field('team_job_title');
$bio       = get_field('team_bio');
?>

<!-- start team member item -->
<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
	<article id="post-<?php the_ID(); ?>" class="team-archive__card text-center" data-animate>

		<?php if ($headshot) : ?>
			<div class="team-archive__image mb-3">
				<a href="<?php the_permalink(); ?>">
					<?php echo mediafast_get_optimized_image($headshot, 'acf-medium', array(
						'class' => 'img-fluid rounded',
						'alt'   => $headshot['alt'] ?: get_the_title(),
					)); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="team-archive__content pt-2">
			<h3 class="team-archive__name h5 fw-600 mb-1">
				<a href="<?php the_permalink(); ?>" class="text-secondary text-decoration-none">
					<?php the_title(); ?>
				</a>
			</h3>

			<?php if ($job_title) : ?>
				<p class="team-archive__role mb-2 text-secondary"><?php echo esc_html($job_title); ?></p>
			<?php endif; ?>

			<?php if ($bio) : ?>
				<p class="team-archive__excerpt mb-3 text-muted">
					<?php echo esc_html(wp_trim_words(wp_strip_all_tags($bio), 20, '&hellip;')); ?>
				</p>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
				<?php esc_html_e('Read Bio', 'mediafast'); ?>
			</a>
		</div>

	</article>
</div>
<!-- end team member item -->
