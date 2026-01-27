<?php

/**
 * Sidebar Template.
 */

if (is_active_sidebar('primary_widget_area') && !is_archive() && !is_single()) :
?>
	<div id="sidebar" class="col-md-4 order-md-first col-sm-12 order-sm-last">
		<?php
		if (is_active_sidebar('primary_widget_area')) :
		?>
			<div id="widget-area" class="widget-area" role="complementary">
				<?php
				dynamic_sidebar('primary_widget_area');

				if (current_user_can('manage_options')) :
				?>
					<span class="edit-link"><a href="<?php echo esc_url(admin_url('widgets.php')); ?>" class="badge bg-secondary"><?php esc_html_e('Edit', 'mediafast'); ?></a></span><!-- Show Edit Widget link -->
				<?php
				endif;
				?>
			</div><!-- /.widget-area -->
		<?php
		endif;

		if (is_archive() || is_single()) :
		?>
			<div class="bg-faded sidebar-nav">
				<div id="primary-two" class="widget-area">
					<?php
					$transient_key = 'mediafast_sidebar_recent_posts';
					$recent_html   = get_transient($transient_key);

					if (false !== $recent_html) {
						echo $recent_html;
					} else {
						$output  = '<ul class="recentposts">';
						$query   = new WP_Query([
							'posts_per_page'         => 5,
							'post_type'              => 'post',
							'no_found_rows'          => true,
							'update_post_meta_cache' => false,
							'update_post_term_cache' => false,
						]);
						$month_check = null;
						if ($query->have_posts()) {
							$output .= '<li><h3>' . esc_html__('Recent Posts', 'mediafast') . '</h3></li>';
							while ($query->have_posts()) {
								$query->the_post();
								$output .= '<li>';
								$month = get_the_date('F, Y');
								if ($month !== $month_check) {
									$output .= '<a href="' . esc_url(get_month_link(get_the_date('Y'), get_the_date('m'))) . '" title="' . esc_attr(get_the_date('F, Y')) . '">' . esc_html($month) . '</a>';
								}
								$month_check = $month;
								$output .= '<h4><a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(sprintf(__('Permalink to %s', 'mediafast'), get_the_title())) . '" rel="bookmark">' . esc_html(get_the_title()) . '</a></h4>';
								$output .= '</li>';
							}
						}
						wp_reset_postdata();
						$output .= '</ul>';
						set_transient($transient_key, $output, 30 * MINUTE_IN_SECONDS);
						echo $output;
					}
					?>
					<br />
					<ul class="categories">
						<li>
							<h3><?php esc_html_e('Categories', 'mediafast'); ?></h3>
						</li>
						<?php
						wp_list_categories(array('title_li' => ''));

						if (! is_author()) :
						?>
							<li>&nbsp;</li>
							<li><a href="<?php the_permalink(get_option('page_for_posts')); ?>" class="btn btn-outline-secondary"><?php esc_html_e('more', 'mediafast'); ?></a></li>
						<?php
						endif;
						?>
					</ul>
				</div><!-- /#primary-two -->
			</div>
		<?php
		endif;
		?>
	</div><!-- /#sidebar -->
<?php
endif;
?>