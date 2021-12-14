<?php

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
global $wp_query;

$shop_page_display = get_option('woocommerce_shop_page_display', false);
$category_archive_display = get_option('woocommerce_category_archive_display', false);

if (is_shop() && $shop_page_display === 'subcategories' && !selleradise_query_has_filters(array_keys($wp_query->query_vars))) {
    return;
}

if (is_product_category() && $category_archive_display === 'subcategories') {

    $child_categories = get_terms([
        'child_of' => $wp_query->queried_object->term_id,
        'type' => $wp_query->post->post_type,
        'taxonomy' => $wp_query->queried_object->taxonomy,
    ]);

    if (!empty($child_categories)) {
        return;
    }

}

$product_tags = selleradise_get_product_tags();
$attributes = wc_get_attribute_taxonomies();
$attributes_with_values = [];
$attribute_filter_keys = [];

foreach ($attributes as $key => $attribute) {

    $attribute_values = get_terms(wc_attribute_taxonomy_name($attribute->attribute_name), array(
        'hide_empty' => false,
        'orderby' => 'count',
        'order' => 'DESC',
        'number' => 100,
    ));

    foreach ($attribute_values as $key => $attribute_value) {
        $color = get_term_meta($attribute_value->term_id, 'product_attribute_color');

        if ($color) {
            $attribute_values[$key]->color = $color[0];
        }
    }

    $attribute->attribute_values = $attribute_values;

    if (!empty($attribute_values)) {
        $attributes_with_values[] = $attribute;
        $attribute_filter_keys['filter_' . $attribute->attribute_name] = [];
    }
}

?>

<shop-filters
	v-bind:current-category='<?php echo esc_attr(is_product_category() ? $wp_query->queried_object->term_id : 0); ?>'
	v-bind:product-tags='<?php echo esc_attr(wp_json_encode($product_tags)); ?>'
	v-bind:product-attributes='<?php echo esc_attr(wp_json_encode($attributes_with_values)); ?>'
	v-bind:product-attributes-keys='<?php echo esc_attr(wp_json_encode($attribute_filter_keys)); ?>'
	v-bind:highest-price="<?php echo esc_attr(selleradise_get_shop_max_price()); ?>"
	type="<?php echo esc_attr(get_theme_mod('filters_location', 'sidebar')); ?>">
    <template #icon-close>
      <?php echo selleradise_svg('unicons-line/multiply'); ?>
    </template>
</shop-filters>