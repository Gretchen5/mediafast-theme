<?php

/**
 * The template for displaying content in the single.php template.
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container pt-5">
		<div class="row flex-column align-items-center mb-4">
			<div class="image-container col-md-10 col-12 blog-post-single-image-container">
				<?php
				if (has_post_thumbnail()) {
					// Check if the new post-featured size (1800x938) exists, otherwise use 'full' size
					// This handles cases where thumbnails haven't been regenerated yet
					$post_featured = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-featured');
					$image_size = 'post-featured';
					
					// If the size doesn't exist or is the old 1200x700 size, use 'full' instead
					if (!$post_featured || ($post_featured[1] == 1200 && $post_featured[2] == 700)) {
						$image_size = 'full';
					}
					
					echo '<div class="post-thumbnail">' . get_the_post_thumbnail(get_the_ID(), $image_size, array('class' => 'img-fluid')) . '</div>';
				}

				?>
			</div>
			<header class="entry-header col-md-10 col-12">
				<h1 class="entry-title text-secondary text-capitalize pt-4"><?php the_title(); ?></h1>
				<?php
				if ('post' === get_post_type()) {
				?>
					<div class="entry-meta">
						<?php mediafast_article_posted_on(); ?>
					</div><!-- /.entry-meta -->
				<?php
				}
				?>
			</header><!-- /.entry-header -->
		</div>
		<div class="entry-content col-12 col-md-10 mx-auto pt-4">
			<?php

			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-link"><span>' . esc_html__('Pages:', 'mediafast') . '</span>',
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- /.entry-content -->

		<?php
		edit_post_link(__('Edit', 'mediafast'), '<span class="edit-link">', '</span>');
		?>


	</div>
</article><!-- /#post-<?php the_ID(); ?> -->