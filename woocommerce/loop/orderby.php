<?php
/**
 * Show options for ordering
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_get_template(
	'loop/orderby-default.php',
	array(
		'catalog_orderby_options' => $catalog_orderby_options,
		'orderby'                 => $orderby,
		'show_default_orderby'    => $show_default_orderby,
	)
);

wc_get_template(
    'loop/orderby-dropdown.php',
    array(
        'catalog_orderby_options' => $catalog_orderby_options,
        'orderby' => $orderby,
        'show_default_orderby' => $show_default_orderby,
    )
);


?>