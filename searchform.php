<?php
/**
 * The template for displaying search forms.
 */
?>
<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="search" name="s" class="form-control"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Search MediaFast...', 'mediafast' ); ?>"
			aria-label="<?php esc_attr_e( 'Search', 'mediafast' ); ?>" />
		<button type="submit" class="btn btn-primary" aria-label="<?php esc_attr_e( 'Submit search', 'mediafast' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
				<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
			</svg>
		</button>
	</div>
</form>
