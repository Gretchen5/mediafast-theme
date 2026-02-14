<?php

/**
 * The template for displaying the case study taxonomies.
 */


if (have_posts()) : ?>

	<ul class="blog-side-image testimonial-cpt blog-wrapper grid-loading grid md-grid-1col sm-grid-1col xs-grid-1col gutter-extra-large pt-5 grid-auto-rows-1">
		<li class="grid-sizer"></li>

		<?php
		while (have_posts()) :
			the_post();

			/**
			 * Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part('content', 'index-case-study'); // Post format: content-index.php
		endwhile;
		?>
	</ul>
<?php
endif;

wp_reset_postdata();

$big = 999999999; // need an unlikely integer

$pages = paginate_links(array(
	'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
	'format'    => '?paged=%#%',
	'current'   => max(1, get_query_var('paged')),
	'total'     => $wp_query->max_num_pages,
	'type'      => 'array',
	'prev_text' => '&larr;', // simple left arrow
	'next_text' => '&rarr;', // simple right arrow
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
<?php endif; ?>