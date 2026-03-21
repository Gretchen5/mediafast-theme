<?php
/**
 * Search Results Template
 */

get_header();

$search_query = get_search_query();
$result_count = $wp_query->found_posts;
?>

<section class="search-results-hero">
	<div class="container">
		<p class="search-results-hero__query">
			Results for <span>"<?php echo esc_html($search_query); ?>"</span>
		</p>
		<p class="search-results-hero__count">
			<?php
			if ($result_count === 1) {
				echo '1 result found';
			} elseif ($result_count > 1) {
				echo esc_html($result_count) . ' results found';
			} else {
				echo 'No results found';
			}
			?>
		</p>
		<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form search-results-hero__form">
			<div class="input-group">
				<input type="search" name="s" class="form-control"
					value="<?php echo esc_attr($search_query); ?>"
					placeholder="<?php esc_attr_e('Search again...', 'mediafast'); ?>"
					aria-label="<?php esc_attr_e('Search', 'mediafast'); ?>" />
				<button type="submit" class="btn btn-primary" aria-label="<?php esc_attr_e('Submit search', 'mediafast'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
						<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
					</svg>
				</button>
			</div>
		</form>
	</div>
</section>

<?php if (have_posts()) : ?>

<section class="search-results-grid">
	<div class="container">
		<div class="row g-4">
			<?php while (have_posts()) : the_post();

				$thumbnail_id = get_post_thumbnail_id();
				$post_type    = get_post_type();
				$excerpt      = get_the_excerpt();

				// Highlight search terms in excerpt
				if ($search_query && $excerpt) {
					$terms = preg_split('/\s+/', trim($search_query));
					foreach ($terms as $term) {
						if (strlen($term) > 2) {
							$excerpt = preg_replace(
								'/(' . preg_quote($term, '/') . ')/i',
								'<mark>$1</mark>',
								$excerpt
							);
						}
					}
				}

				// Human-readable post type label
				$type_labels = [
					'post'        => 'Blog',
					'page'        => 'Page',
					'case-study'  => 'Case Study',
					'testimonial' => 'Testimonial',
				];
				$type_label = $type_labels[$post_type] ?? ucwords(str_replace(['-', '_'], ' ', $post_type));
				?>

			<div class="col-12 col-md-6 col-lg-4">
				<article class="search-result-card">

					<div class="search-result-card__thumb <?php echo !$thumbnail_id ? 'search-result-card__thumb--placeholder' : ''; ?>">
						<?php if ($thumbnail_id) : ?>
							<?php echo wp_get_attachment_image($thumbnail_id, 'medium', false, ['loading' => 'lazy']); ?>
						<?php else : ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
							</svg>
						<?php endif; ?>
					</div>

					<div class="search-result-card__body">
						<span class="search-result-card__type"><?php echo esc_html($type_label); ?></span>
						<h2 class="search-result-card__title h6">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<?php if ($excerpt) : ?>
						<p class="search-result-card__excerpt"><?php echo $excerpt; ?></p>
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>" class="search-result-card__link">
							View <?php echo esc_html($type_label); ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<path d="M5 12h14M12 5l7 7-7 7"/>
							</svg>
						</a>
					</div>

				</article>
			</div>

			<?php endwhile; ?>
		</div>

		<?php
		// Pagination
		$big   = 999999999;
		$pages = paginate_links([
			'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format'    => '?paged=%#%',
			'current'   => max(1, get_query_var('paged')),
			'total'     => $wp_query->max_num_pages,
			'type'      => 'array',
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
		]);

		if (is_array($pages)) : ?>
		<nav class="custom-pagination pt-5" aria-label="<?php esc_attr_e('Search results pages', 'mediafast'); ?>">
			<ul class="pagination justify-content-center">
				<?php foreach ($pages as $page) : ?>
					<li class="page-item"><?php echo $page; ?></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php endif; ?>

	</div>
</section>

<?php else : ?>

<section class="search-no-results">
	<div class="container">
		<div class="search-no-results__icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><line x1="8" y1="11" x2="14" y2="11"/>
			</svg>
		</div>
		<h1 class="search-no-results__title h3">
			<?php printf(esc_html__('No results for "%s"', 'mediafast'), esc_html($search_query)); ?>
		</h1>
		<p class="search-no-results__text">
			<?php esc_html_e('Try different keywords, or explore our most popular products below.', 'mediafast'); ?>
		</p>
		<div class="d-flex flex-wrap gap-3 justify-content-center">
			<a href="<?php echo esc_url(home_url('/video-brochures/')); ?>" class="btn btn-primary">Video Brochures</a>
			<a href="<?php echo esc_url(home_url('/video-mailers/')); ?>" class="btn btn-primary">Video Mailers</a>
			<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-outline-secondary">Contact Us</a>
		</div>
	</div>
</section>

<?php endif;

wp_reset_postdata();
get_footer();
