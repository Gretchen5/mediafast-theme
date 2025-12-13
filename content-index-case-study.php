<?php

/**
 * The template for displaying content in the index-testimonial.php template.
 */
?>

<?php
$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');

?>

<!-- start blog item -->
<li class="grid-item">
	<article id="post-<?php the_ID(); ?>">
		<div class="blog-box d-md-flex d-block flex-column h-100 border-radius-6px overflow-hidden box-shadow-extra-large">
			<div class="blog-image w-50 sm-w-100 contain-background mt-4" style="background-image: url('<?php echo esc_url($thumb_url ?: 'https://placehold.co/800x923'); ?>');">
			</div>
			<div class="blog-content w-100 sm-w-100 pt-50px pb-40px ps-40px pe-40px xl-p-30px bg-white d-flex flex-column justify-content-center align-items-start last-paragraph-no-margin">
				<?php
				$terms = get_the_terms(get_the_ID(), 'industry');
				if (! empty($terms) && ! is_wp_error($terms)) :
					$term = array_shift($terms); // get the first industry
					$term_url = get_term_link($term);
				?>
					<a href="<?php echo esc_url($term_url); ?>"
						class="categories-btn bg-success text-white text-uppercase fw-500 mb-30px text-decoration-none">
						<?php echo esc_html($term->name); ?>
					</a>
				<?php endif; ?>
				<a href="<?php the_permalink(); ?>" class="card-title text-dark-gray text-underline-hover text-dark-gray-hover mb-5px fw-600 fs-18 lh-28"><?php the_title(); ?></a>
				<p>
					<?php
					// if (has_excerpt()) {
					// 	echo esc_html(get_the_excerpt());
					// } else {
					// 	$content = wp_strip_all_tags(get_the_content());
					// 	echo esc_html(wp_trim_words($content, 20, '…'));
					// }
					the_content();
					?>
				</p>

			</div>
		</div>
	</article><!-- /#post-<?php the_ID(); ?> -->
</li>
<!-- end blog item -->