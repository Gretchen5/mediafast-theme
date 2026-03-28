<?php

/**
 * The template for displaying the team archive loop.
 */


if (have_posts()) :
?>

	<section class="team-archive py-75">
		<div class="container">

			<div class="row justify-content-center mb-5">
				<div class="col-12 col-lg-8 text-center">
					<h1 class="text-secondary"><?php post_type_archive_title(); ?></h1>
				</div>
			</div>

			<div class="row g-4">
				<?php while (have_posts()) : the_post();
					get_template_part('content', 'index-team');
				endwhile; ?>
			</div><!-- /.row -->

			<?php
			global $wp_query;
			if ($wp_query->max_num_pages > 1) :
				$big = 999999999;

				$pages = paginate_links(array(
					'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'format'    => '?paged=%#%',
					'current'   => max(1, get_query_var('paged')),
					'total'     => $wp_query->max_num_pages,
					'type'      => 'array',
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
				));

				if (is_array($pages)) :
			?>
				<nav class="custom-pagination pt-5" style="border-bottom: 1px solid #757575; padding-bottom: 2rem;">
					<ul class="pagination justify-content-center">
						<?php foreach ($pages as $page) : ?>
							<li class="page-item"><?php echo $page; ?></li>
						<?php endforeach; ?>
					</ul>
				</nav>
			<?php
				endif;
			endif;
			?>

		</div><!-- /.container -->
	</section>

<?php
endif;
