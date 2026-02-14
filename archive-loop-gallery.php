<?php

/**
 * The template for displaying the archive loop.
 */


if (have_posts()) :
?>
	<div class="container pb-5">
		<div class="row align-items-stretch g-3">

			<?php
			while (have_posts()) :
				the_post();

				/**
				 * Include the Post-Format-specific template for the content.
				 * If you want to overload this in a child theme then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part('content', 'index-gallery'); // Post format: content-index.php
			endwhile;
			?>
		</div>
	</div>
<?php
endif;

wp_reset_postdata();

global $wp_query;

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