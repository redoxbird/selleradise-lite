<?php
/**
 * Single Product Categories
 *
 * 
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if (!$product) {
    return;
}

$categories = get_the_terms($product->get_ID(), 'product_cat');
?>

<ul class="selleradise_single_product__categories">
    <li class="selleradise_single_product__categories-icon">
        <?php echo selleradise_svg('tabler-icons/category-2'); ?>
    </li>

    <?php foreach ($categories as $key => $category): ?>
        <li>
            <a href="<?php echo esc_url(get_term_link($category)) ?>">
                <?php echo esc_html($category->name) ?>
            </a>
        </li>
    <?php endforeach;?>
</ul>
