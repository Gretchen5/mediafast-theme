<?php

/**
 * The template for displaying content in the index.php template.
 */
?>

<?php
$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');

?>

<!-- start blog item -->
<li class="grid-item m-4 m-md-0">
	<article id="post-<?php the_ID(); ?>">
		<div class="blog-box d-md-flex d-block flex-row h-100 border-radius-6px overflow-hidden box-shadow-extra-large my-3">
			<div class="blog-image responsive-image-width contain-background" style="background-image: url('<?php echo esc_url($thumb_url ?: 'https://placehold.co/800x923'); ?>'); height:400px;">
				<a href="<?php the_permalink(); ?>" class="blog-post-image-overlay" aria-label="<?php echo esc_attr(sprintf(__('Read more about %s', 'mediafast'), get_the_title())); ?>"></a>
			</div>
			<div class="blog-content responsive-image-width pt-50px pb-40px ps-40px pe-40px xl-p-30px bg-white d-flex flex-column justify-content-center align-items-center align-items-md-start last-paragraph-no-margin text-center text-md-start">
				<?php
				$categories = get_the_category();
				if (! empty($categories)) :
					$cat     = $categories[0]; // first category
					$cat_url = get_category_link($cat->term_id);
					$cat_name = $cat->name;
				?>
					<a href="<?php echo esc_url($cat_url); ?>"
						class="categories-btn bg-success text-white text-uppercase fw-500 mb-30px text-decoration-none">
						<?php echo esc_html($cat_name); ?>
					</a>
				<?php endif; ?>
				<a href="<?php the_permalink(); ?>" class="card-title text-dark-gray text-underline-hover text-dark-gray-hover mb-5px fw-600 fs-18 lh-28"><?php the_title(); ?></a>
				<p>
					<?php
					if (has_excerpt()) {
						echo esc_html(get_the_excerpt());
					} else {
						$content = wp_strip_all_tags(get_the_content());
						echo esc_html(wp_trim_words($content, 20, '…'));
					}
					?>
				</p>
				<div class="mt-15px"><span class="separator bg-dark-gray"></span>
					<p class="text-dark-gray text-dark-gray-hover d-inline-block fs-15 fw-500 fw-500 text-center text-md-start"><?php the_author(); ?></p>
				</div>
			</div>
		</div>
	</article><!-- /#post-<?php the_ID(); ?> -->
</li>
<!-- end blog item -->