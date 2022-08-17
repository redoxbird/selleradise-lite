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


$min_price = isset($search_params['min_price']) && $search_params['min_price'] ? $search_params['min_price'] : 0;
$max_price = isset($search_params['max_price']) && $search_params['max_price'] ? $search_params['max_price'] : 0;
$location = get_theme_mod('filters_location', 'sidebar');

?>

<div x-data="shopFilters({
        highestPrice: <?php echo esc_attr(selleradise_get_shop_max_price()); ?>,
        min_price: <?php echo esc_attr($min_price); ?>,
        max_price: <?php echo esc_attr($max_price); ?>
    })" v-show="show" x-bind:class="[
        'selleradise_shop__filters',
        '<?php echo esc_attr($location); ?>' == 'offscreen'
          ? 'selleradise_shop__filters--offscreen'
          : null,
    ]">

    <form method="get" x-ref="form" action="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink('shop') : "") ?>">
        <div class="selleradise_shop__filters-actions" v-if="formHaveSelectedValues" x-cloak>
            <button type="submit" class="selleradise_shop__filters-action-apply">
                <?php esc_html_e('Apply Filters', 'selleradise-lite') ?>
            </button>
            <a href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink('shop') : "") ?>" class="selleradise_shop__filters-action-clear">
                <?php echo selleradise_svg('unicons-line/multiply'); ?>
                <?php esc_html_e('Clear', 'selleradise-lite') ?>
            </a>
        </div>


        <div class="selleradise_shop__filters-price">
            <div class="selleradise_shop__filters-price-head">
                <h3 class="selleradise_shop__filters-title">
                    <?php esc_html_e('Price', 'selleradise-lite') ?>
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
                <?php esc_html_e('Categories', 'selleradise-lite') ?>
            </h3>

            <div class="inputWrap selleradise_shop__filters-categories-input" v-for="category in categories" :key="category.term_id" v-show="category.term_id != 0" :class="[
              formRef.categories_selected.includes(category.term_id) &&
                'highlight',
              category.parent != 0 && 'is-child',
            ]">
                <input type="checkbox" v-bind:id="category.slug" v-model="formRef.categories" v-bind:value="category.slug" v-on:change="
                insertChildCategories(category, $event.target.checked)
              " />
                <label :for="category.slug" v-html="category.name"></label>
            </div>
        </div>

        <div class="attributes" v-for="attribute in attributes" :key="attribute.attribute_id">
            <h3 class="selleradise_shop__filters-title">
                {{ attribute.attribute_label }}
            </h3>

            <div class="inputWrap" v-for="value in attribute.attribute_values" :class="[value.color ? 'inputWrap--color' : undefined]" :key="value.term_id" :style="{
              '--swatch-color': value.color
                ? value.color
                : 'rgba(color(text-rgb), 0.05)',
            }">
                <input type="checkbox" v-bind:id="value.slug" v-bind:value="value.slug" v-model="formRef.attributes[`filter_${attribute.attribute_name}`]" />
                <label :class="[value.color ? 'color' : undefined]" :for="value.slug">{{ value.name }}</label>
            </div>
        </div>

        <div class="tags" v-if="hasTags">
            <h3 class="selleradise_shop__filters-title">{{ trans("Tags") }}</h3>

            <div class="inputWrap" v-for="tag in tags" :key="tag.term_id">
                <input type="checkbox" v-bind:id="tag.slug" v-model="formRef.tags" v-bind:value="tag.slug" />
                <label :for="tag.slug" v-html="tag.name"></label>
            </div>

            <button class="button--showAll" v-on:click.prevent="showAllTags()" v-if="!isShowingAllTags">
                Show All {{ trans("Tags") }}
            </button>
        </div>

        <div class="selleradise_shop__filters-actions">
            <button type="submit" class="selleradise_shop__filters-action-apply" v-text="trans('shop-filter-apply')" v-if="formHaveSelectedValues" v-cloak></button>
            <a :href="selleradiseData.shopURL" class="selleradise_shop__filters-action-clear" v-if="formHaveSelectedValues" v-cloak>
                <slot name="icon-close"></slot>
                {{ trans("shop-filter-clear") }}
            </a>
        </div>

        <div>
            <input type="hidden" name="min_price" x-show="minPrice" x-bind:value="fields.min_price" />
            <input type="hidden" name="max_price" x-show="maxPrice" x-bind:value="fields.max_price" />

            <!-- <input type="hidden" name="product_cat" v-if="categoriesJoined" :value="categoriesJoined" />
            <input type="hidden" name="product_tag" v-if="tagsJoined" :value="tagsJoined" /> -->

            <!-- <input type="hidden" name="selleradise_product_cat" v-if="categoriesSelectedJoined" :value="categoriesSelectedJoined" />
            <div class="hiddenAttributeInput" v-for="(attribute, key) in formRef.attributes" :key="key">
                <input type="hidden" v-if="attribute.length > 0" :name="key" :value="attribute" />
            </div> -->
        </div>
    </form>
</div>

<shop-filters v-bind:current-category='<?php echo esc_attr(is_product_category() ? $wp_query->queried_object->term_id : 0); ?>' v-bind:product-tags='<?php echo esc_attr(wp_json_encode($product_tags)); ?>' v-bind:product-attributes='<?php echo esc_attr(wp_json_encode($attributes_with_values)); ?>' v-bind:product-attributes-keys='<?php echo esc_attr(wp_json_encode($attribute_filter_keys)); ?>' v-bind:highest-price="<?php echo esc_attr(selleradise_get_shop_max_price()); ?>" type="<?php echo esc_attr(get_theme_mod('filters_location', 'sidebar')); ?>">
    <template #icon-close>
        <?php echo selleradise_svg('unicons-line/multiply'); ?>
    </template>
</shop-filters>