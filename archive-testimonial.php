<?php

/**
 * The Template for displaying Archive pages.
 */

get_header();


if (have_posts()) :

	
?>
	
<?php
	get_template_part('archive', 'loop-testimonial');
else :
	// 404.
	get_template_part('content', 'none');
endif;

wp_reset_postdata(); // End of the loop.

get_footer();
