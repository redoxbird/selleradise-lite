<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

?>

<form action="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" method="get" x-data="searchBar({type: '<?php echo esc_attr(isset($type) && $type ? $type : 'native') ?>'})" x-on:start-search.window="start()" x-on:click.outside="!['idle', 'initiated'].includes(state) && stop()" x-bind:data-state="state" role="search" x-ref="searchForm" class="selleradiseHeader__searchForm">
  <label>
    <span class="sr-only"><?php esc_html_e("Search for products here...", "selleradise-lite"); ?></span>
    <input type="text" x-bind:value="keyword" x-on:input="handleInputChange($event)" x-on:focus="startSearch()" x-on:keydown.tab.shift="stopSearch()" x-on:keydown.enter="handleEnterPress($event)" class="searchField" ref="searchField" name="s" autocomplete="off" maxlength="50" minlength="2" placeholder="<?php esc_attr_e("Search for products here...", "selleradise-lite"); ?>" />

    <button x-ref="searchClearButton" class="clear" x-show="keyword && keyword != ''" x-tooltip="headerSearchBarClearButtonTooltip" x-on:click.prevent="clear()">
      <span id="headerSearchBarClearButtonTooltip" role="tooltip" class="selleradise_tooltip">
        <?php esc_html_e('Clear', 'selleradise-lite'); ?>
      </span>
      <?php echo selleradise_svg('unicons-line/multiply'); ?>
    </button>
  </label>

  <button type="submit" x-ref="searchSubmitButton" x-on:blur="handleSubmitBlur()" v-on:keydown.tab.exact="send('STOP')" x-on:click="handleEnterPress($event)" x-tooltip="headerSearchBarSubmitButtonTooltip">
    <span id="headerSearchBarSubmitButtonTooltip" role="tooltip" class="selleradise_tooltip">
      <?php esc_attr_e("Submit", "selleradise-lite"); ?>
    </span>
    <span class="inlineSVGIcon" x-show="state === 'searching'">
      <?php echo selleradise_svg('loader/simple'); ?>
    </span>
    <span class="inlineSVGIcon" x-show="state !== 'searching'">
      <?php echo selleradise_svg('unicons-line/search'); ?>
    </span>
  </button>

  <div x-show="state === 'found'" x-transition class="selleradiseHeader__searchResults mt-4 rounded-lg" ref="selleradiseHeader__searchResults" x-cloak>
    <ul class="selleradiseHeader__searchResults-inner">
      <li x-show="terms && terms.length > 0">
        <ul class="selleradiseHeader__searchResults-suggestions--categories">
          <template x-for="term in terms">
            <li>
              <a x-bind:href="getLink(term, 'term')" x-text="getName(term, 'term')"></a>
            </li>
          </template>
        </ul>
      </li>

      <li x-show="products && products.length > 0">
        <ul class="selleradiseHeader__searchResults-suggestions--products">
          <template x-for="product in products">
            <li>
              <a x-bind:href="getLink(product, 'product')" x-text="getName(product, 'product')"></a>
            </li>
          </template>
        </ul>
      </li>
    </ul>
  </div>
</form>