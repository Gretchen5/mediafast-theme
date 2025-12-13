<?php

/**
 * The template for displaying content in the index.php template.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-12 col-md-4 col-lg-3'); ?>>
	<div class="card h-100 border-0 shadow">
		<?php if (has_post_thumbnail()) {
			echo '<div class="post-thumbnail gallery-thumbnails">' . get_the_post_thumbnail(get_the_ID(), 'large') . '</div>';
		}
		?>
		<div class="card-body text-center d-flex flex-column justify-content-between">
			<h2 class="text-large-15"><?php the_title(); ?></h2>

			<?php

			if (is_search()) {
				the_excerpt();
			} else {
				the_content();
			}
			?>
		</div><!-- /.card-body -->
	</div><!-- /.col -->
</article><!-- /#post-<?php the_ID(); ?> -->