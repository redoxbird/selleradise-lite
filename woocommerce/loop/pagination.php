<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
?>
<nav class="selleradise_pagination">
	<?php
		echo paginate_links(
			apply_filters(
				'woocommerce_pagination_args',
				array( // WPCS: XSS ok.
					'base'      => $base,
					'format'    => $format,
					'add_args'  => false,
					'current'   => max( 1, $current ),
					'total'     => $total,
					'prev_text' => sprintf('<span class="sr-only">%s</span>', __('Previous', 'selleradise-lite')).selleradise_svg('unicons-line/angle-left'),
					'next_text' => sprintf('<span class="sr-only">%s</span>', __('Next', 'selleradise-lite')).selleradise_svg('unicons-line/angle-right'),
					'type'      => 'list',
					'end_size'  => 2,
					'mid_size'  => 2,
				)
			)
		);
	?>
</nav>
