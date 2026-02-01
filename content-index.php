<?php

/**
 * The template for displaying content in the index.php template.
 */
?>

<?php
$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
$categories = get_the_category();
$cat_name = !empty($categories) ? $categories[0]->name : '';
$cat_url = !empty($categories) ? get_category_link($categories[0]->term_id) : '';
$post_date = get_the_date('j F Y');
?>

<!-- start blog item -->
<div class="col-12 col-md-6 col-lg-4">
	<article id="post-<?php the_ID(); ?>" class="h-100">
		<div class="card h-100 border-0">
			<a href="<?php the_permalink(); ?>" class="position-relative d-block overflow-hidden blog-card-image" aria-label="<?php echo esc_attr(sprintf(__('Read more about %s', 'mediafast'), get_the_title())); ?>">
				<?php if ($thumb_url) : ?>
					<?php the_post_thumbnail('large', array('class' => 'card-img-top w-100 blog-post-thumbnail', 'loading' => 'lazy')); ?>
				<?php else : ?>
					<?php
					// Featured image dimensions: 1800px × 938px (ratio: 1.92:1)
					// Using aspect-ratio to maintain proper proportions
					?>
					<img src="https://placehold.co/1800x938/6c757d/ffffff?text=No+Image" alt="<?php echo esc_attr(get_the_title()); ?>" class="card-img-top w-100 blog-post-thumbnail" loading="lazy" />
				<?php endif; ?>
			</a>
			
			<div class="card-body bg-white d-flex flex-column">
				<?php if ($cat_name || $post_date) : ?>
					<div class="mb-2">
						<?php if ($cat_name && $cat_url) : ?>
							<a href="<?php echo esc_url($cat_url); ?>" class="text-decoration-none text-uppercase fw-bold" style="color: #6c757d; font-size: 0.75rem; letter-spacing: 0.5px;">
								<?php echo esc_html($cat_name); ?>
							</a>
						<?php elseif ($cat_name) : ?>
							<span class="text-uppercase fw-bold" style="color: #6c757d; font-size: 0.75rem; letter-spacing: 0.5px;">
								<?php echo esc_html($cat_name); ?>
							</span>
						<?php endif; ?>
						<?php if ($cat_name && $post_date) : ?>
							<span class="mx-1" style="color: #6c757d;">•</span>
						<?php endif; ?>
						<?php if ($post_date) : ?>
							<span style="color: #6c757d; font-size: 0.75rem;"><?php echo esc_html(strtoupper($post_date)); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				
				<h3 class="card-title mb-3">
					<a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark fw-bold" style="font-size: 1.25rem; line-height: 1.4;">
						<?php the_title(); ?>
					</a>
				</h3>
				
				<p class="card-text text-muted mb-3 flex-grow-1" style="font-size: 0.9rem; line-height: 1.6;">
					<?php
					if (has_excerpt()) {
						echo esc_html(get_the_excerpt());
					} else {
						$content = wp_strip_all_tags(get_the_content());
						echo esc_html(wp_trim_words($content, 20, '…'));
					}
					?>
				</p>
				<a href="<?php the_permalink(); ?>" class="btn btn-primary text-decoration-none mt-auto">
					<?php esc_html_e('Read More', 'mediafast'); ?>
				</a>
			</div>
		</div>
	</article><!-- /#post-<?php the_ID(); ?> -->
</div>
<!-- end blog item -->