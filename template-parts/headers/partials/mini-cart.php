<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if (!class_exists('WooCommerce')) {
  return;
}

if ($args) {
  extract($args);
}

?>

<div x-cloak x-data class="selleradise_MiniCart" x-on:updated_wc_div.document="$store.miniCart.fetch()">
  <div x-cloak class="selleradise_MiniCart__inner transition ease-out duration-300" x-show="
      selleradiseData.isWooCommerce &&
      $store.miniCart.state != 'hidden'
    " x-transition.scale.opacity>
    <div class="selleradise_MiniCart__head">
      <p class="selleradise_MiniCart__headCount" x-show="$store.miniCart.isNotEmpty()" x-html="$store.miniCart.title"></p>
      <button class="button--close buttonIcon--secondary-outline" x-on:click="$store.miniCart.close()" x-ref="closeBtn">
        <?php echo selleradise_svg('unicons-line/multiply') ?>
      </button>
    </div>

    <template x-if="$store.miniCart.isNotEmpty()">
      <ul class="selleradise_MiniCart__items">
        <template x-for="(item, index) in $store.miniCart.items" x-bind:key="item.key">
          <li class="selleradise_MiniCart__item">
            <a x-bind:href="item.product.link" class="selleradise_MiniCart__itemImage" x-html="item.product.image ? item.product.image : false"></a>

            <div class="selleradise_MiniCart__itemContent">
              <p class="selleradise_MiniCart__itemName">
                <a x-bind:href="item.product.link" x-html="item.product.name">
                </a>
              </p>

              <p class="selleradise_MiniCart__itemPrice" x-html="item.product.price"></p>

              <div class="selleradise_MiniCart__itemQuantity">
                <button x-bind:class="
                    item.quantity > 1
                      ? 'selleradise_MiniCart__decreaseQuantity'
                      : 'selleradise_MiniCart__removeItem'
                  " x-on:click.prevent="$store.miniCart.decreaseQuantity(index)">
                  <span x-show="item.quantity > 1"><?php echo selleradise_svg('unicons-line/minus') ?></span>
                  <span x-show="item.quantity <= 1"><?php echo selleradise_svg('unicons-line/trash') ?></span>
                </button>

                <span class="selleradise_MiniCart__itemQuantityCount" x-text="item.quantity"></span>

                <button class="selleradise_MiniCart__increaseQuantity" x-on:click.prevent="$store.miniCart.increaseQuantity(index)">
                  <?php echo selleradise_svg('unicons-line/plus') ?>
                </button>
              </div>
            </div>
          </li>
        </template>
      </ul>
    </template>

    <div class="selleradise_MiniCart__foot" x-show="$store.miniCart.isNotEmpty()">
      <div class="selleradise_MiniCart__footActions">
        <a x-bind:href="selleradiseData.cartURL" class="selleradise_button--secondary-outline">
          <?php esc_attr_e('Edit Cart', 'selleradise-lite'); ?>
        </a>
        <a x-bind:href="selleradiseData.checkoutURL" class="selleradise_button--primary">
          <?php esc_attr_e('Checkout', 'selleradise-lite'); ?>
          <span class="selleradise_MiniCart__footCartTotal" x-html="$store.miniCart.total"></span>
        </a>
      </div>
    </div>

    <div class="selleradise_MiniCart__loader" x-show="$store.miniCart.state == 'updating'">
      <?php echo selleradise_svg('loader/simple') ?>
    </div>

    <template x-if="$store.miniCart.isEmpty()">
      <div class="flex justify-center items-center flex-col text-center">
        <div class="children:w-20 children:h-auto mb-5">
          <?php echo selleradise_svg('misc/empty-state') ?>
        </div>
        <h2 class="text-xl mb-2">
          <?php echo esc_html__('Your cart is empty.', 'selleradise-lite'); ?>
        </h2>
        <p class="text-sm text-gray-600">
          <?php echo esc_html__('Looks like you have not added any product to your cart yet.', 'selleradise-lite'); ?>
        </p>
      </div>
    </template>


  </div>

  <div class="overlay" x-show="$store.miniCart.state != 'hidden'" x-on:click="$store.miniCart.close()" x-transition.opacity></div>
</div>