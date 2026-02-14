<?php

/**
 * The template for displaying content in the index-testimonial.php template.
 */
?>

<?php
$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
?>

<!-- start testimonial item -->
<div class="col-12 col-md-6 col-lg-4">
	<article id="post-<?php the_ID(); ?>" class="testimonial-archive__card">
		<?php if ($thumb_url) : ?>
			<div class="testimonial-archive__image">
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo esc_url($thumb_url); ?>" 
						 alt="<?php echo esc_attr(get_the_title()); ?>" 
						 loading="lazy">
				</a>
			</div>
		<?php endif; ?>
		
		<div class="testimonial-archive__content">
			<h3 class="testimonial-archive__heading">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			
			<div class="testimonial-archive__description">
				<?php
				if (has_excerpt()) {
					echo wp_kses_post(get_the_excerpt());
				} else {
					$content = wp_strip_all_tags(get_the_content());
					echo esc_html(wp_trim_words($content, 25, '…'));
				}
				?>
			</div>
			
			<div class="testimonial-archive__read-more">
				<a href="<?php the_permalink(); ?>" class="btn btn-primary">
					<?php esc_html_e('Read More', 'mediafast'); ?>
				</a>
			</div>
		</div>
	</article>
</div>
<!-- end testimonial item -->