<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if (!isset($product->id)) {
    global $product;
}

if (!$product) {
    return;
}

if(!$product->is_on_sale()) {
    return;
}

if (!$product->get_date_on_sale_to() || !$product->get_date_on_sale_from() || $product->get_type() !== 'simple') {
    return;
}

?>


<div
    x-data="saleTimer({
        saleFrom: '<?php echo esc_attr($product->get_date_on_sale_from()) ?>',
        saleTo: '<?php echo esc_attr($product->get_date_on_sale_to()) ?>'
    })"
    class="flex justify-start items-center text-sm flex-wrap w-full my-4 max-w-xs border-1 border-dashed border-red-600 text-red-600 rounded-xl py-2 px-4">

    <div class="flex justify-start items-center gap-2 w-full">
        <template x-for="label in ['days', 'hours', 'minutes', 'seconds']">
            <div class="flex-grow flex flex-col text-center">
                <span class="font-semibold" x-text="getDurationByLabel(label)"></span>
                <span class="text-xs capitalize" x-text="label"></span>
            </div>
        </template>
    </div>
  </div>