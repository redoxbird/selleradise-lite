<?php

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
global $wp_query;

$shop_page_display = get_option('woocommerce_shop_page_display', false);
$category_archive_display = get_option('woocommerce_category_archive_display', false);
$search_params = array();

parse_str($_SERVER['QUERY_STRING'], $search_params);


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

$categories = selleradise_get_product_categories_tree();

$min_price = isset($search_params['min_price']) && $search_params['min_price'] ? $search_params['min_price'] : 0;
$max_price = isset($search_params['max_price']) && $search_params['max_price'] ? $search_params['max_price'] : 0;
$location = get_theme_mod('filters_location', 'sidebar');
?>

<div x-data="shopFilters({
        highestPrice: <?php echo esc_attr(selleradise_get_shop_max_price()); ?>,
        min_price: <?php echo esc_attr($min_price); ?>,
        max_price: <?php echo esc_attr($max_price); ?>,
        searchParams: '<?php echo esc_attr($_SERVER["QUERY_STRING"]) ?>',
        type: '<?php echo esc_attr($location); ?>'
    })">

    <div x-show="isSmall && show()" class="overlay" x-on:click="close()" x-transition.opacity></div>

    <div 
        x-on:open-shop-filters.window="open();" 
        x-on:click.outside="close()" 
        x-show="show()"  
        x-bind:class="['selleradise_shop__filters',className()]"
        x-transition:enter="transition ease-out-expo duration-400"
        x-transition:enter-start="opacity-0 translate-x-16"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-out-expo duration-500"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-16">

        <form method="get" x-ref="form" x-on:change="updateFormData();" action="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink('shop') : "") ?>">
            <div class="selleradise_shop__filters-actions" x-show="isChanged" x-transition x-cloak>
                <button type="submit" class="selleradise_shop__filters-action-apply">
                    <?php esc_html_e('Apply Filters', 'TEXT_DOMAIN') ?>
                </button>
                <a href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink('shop') : "") ?>" class="selleradise_shop__filters-action-clear">
                    <?php echo selleradise_svg('tabler-icons/x'); ?>
                    <?php esc_html_e('Clear', 'TEXT_DOMAIN') ?>
                </a>
            </div>


            <div class="selleradise_shop__filters-price">
                <div class="selleradise_shop__filters-price-head">
                    <h3 class="selleradise_shop__filters-title">
                        <?php esc_html_e('Price', 'TEXT_DOMAIN') ?>
                    </h3>
                    <div class="selleradise_shop__filters-price-values">
                        <span x-text="currencySymbol + fields.min_price"></span>
                        <span class="selleradise_shop__filters-price-values-divider"></span>
                        <span x-text="currencySymbol + fields.max_price"></span>
                    </div>
                </div>

                <div x-ref="priceSlider" class="selleradise_shop__filters-price-slider" id="selleradise_shop__filters-price-slider"></div>
            </div>

            <div class="categories" v-if="hasCategories" name="selleradise_shop__filters-categories-input">
                <h3 class="selleradise_shop__filters-title" key="selleradise_shop__filters-categories-title">
                    <?php esc_html_e('Categories', 'TEXT_DOMAIN') ?>
                </h3>

                <?php
                if ($categories && !empty($categories)) :
                    get_template_part(
                        "template-parts/pages/shop/partials/categories-checkbox-tree",
                        null,
                        ["items" => $categories, "level" => 1, "parent" => []]
                    );
                endif;
                ?>
            </div>

            <template x-for="attribute in data.attributes">
                <div class="attributes">
                    <h3 class="selleradise_shop__filters-title" x-text="attribute.attribute_label"></h3>

                    <template x-for="value in attribute.attribute_values">
                        <div class="inputWrap" x-bind:class="[value.color ? 'inputWrap--color' : undefined]" x-bind:style="{
                        '--swatch-color': value.color
                            ? value.color
                            : 'rgba(color(text-rgb), 0.05)',
                        }">
                            <input x-bind:checked="isAttributeChecked(attribute.attribute_name, value.slug)" x-on:change="handleAttributeChange($event, attribute, value)" type="checkbox" x-bind:id="value.slug" x-bind:value="value.slug" v-model="formRef.attributes[`filter_${attribute.attribute_name}`]" />
                            <label x-bind:class="[value.color ? 'color' : undefined]" x-bind:for="value.slug" x-text="value.name"></label>
                        </div>
                    </template>


                </div>
            </template>


            <div class="selleradise_shop__filters-actions" x-show="isChanged" x-transition x-cloak>
                <button type="submit" class="selleradise_shop__filters-action-apply">
                    <?php esc_html_e('Apply Filters', 'TEXT_DOMAIN') ?>
                </button>
                <a href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink('shop') : "") ?>" class="selleradise_shop__filters-action-clear">
                    <?php echo selleradise_svg('tabler-icons/x'); ?>
                    <?php esc_html_e('Clear', 'TEXT_DOMAIN') ?>
                </a>
            </div>

            <div>
                <input type="hidden" name="min_price" x-show="fields.min_price" x-bind:value="fields.min_price" value="<?php echo esc_attr($min_price); ?>" />
                <input type="hidden" name="max_price" x-show="fields.max_price" x-bind:value="fields.max_price" value="<?php echo esc_attr($max_price); ?>" />
                <input type="hidden" name="product_cat" x-show="fields.product_cat" x-bind:value="fields.product_cat" />

                <template x-for="(values, key) in fields.attributes">
                    <input type="hidden" x-show="values?.length > 0" x-bind:name="'filter_' + key" x-bind:value="values" />
                </template>
            </div>
        </form>
    </div>
</div>