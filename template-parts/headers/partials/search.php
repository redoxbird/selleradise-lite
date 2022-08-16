<form x-data="searchBar" role="search" action="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" method="get" x-ref="searchForm" class="selleradiseHeader__searchForm" x-show="isOpen()">
  <label>
    <span class="sr-only"><?php esc_html_e("Search for products here...", "selleradise-lite"); ?></span>
    <input type="text" x-bind:value="keyword" x-on:input="(e) => (keyword = e.target.value)" x-on:focus="startSearch()" x-on:keydown.tab.shift="stopSearch()" x-on:keydown.enter="handleEnterPress($event)" class="searchField" ref="searchField" name="s" autocomplete="off" maxlength="50" minlength="2" placeholder="<?php esc_attr_e("Search for products here...", "selleradise-lite"); ?>" />

    <button ref="searchClearButton" class="clear" x-show="keyword && keyword != ''" aria-label="'<?php esc_attr_e("Clear", "selleradise-lite"); ?>'" x-tippy="'<?php esc_attr_e("Clear", "selleradise-lite"); ?>'" x-on:click.prevent="clear()">
      <?php echo selleradise_svg('unicons-line/multiply'); ?>
    </button>
  </label>

  <button type="submit" x-ref="searchSubmitButton" x-on:blur="handleSubmitBlur()" v-on:keydown.tab.exact="send('STOP')" x-on:click="handleEnterPress($event)" aria-label="'<?php esc_attr_e("Submit", "selleradise-lite"); ?>'" x-tippy="'<?php esc_attr_e("Submit", "selleradise-lite"); ?>'">
    <span class="inlineSVGIcon" x-show="state === 'searching'">
      <?php echo selleradise_svg('unicons-line/multiply'); ?>
    </span>
    <span class="inlineSVGIcon" x-show="state !== 'searching'">
      <?php echo selleradise_svg('unicons-line/search'); ?>
    </span>
  </button>

  <!-- 
  <div class="selleradiseHeader__searchResults" ref="selleradiseHeader__searchResults" v-show="['found', 'not_found', 'searching'].some(state.matches)" v-cloak>
    <ul class="selleradiseHeader__searchResults-inner">
      <li v-show="foundSuggestions">
        <ul class="selleradiseHeader__searchResults-suggestions--categories">
          <li v-for="(category, i) in suggestions" :ref="
                  (el) => {
                    if (el) {
                      items['categories'][i] = el;
                    }
                  }
                ">
            <a :href="category.link" v-html="
                    category.is_duplicate_name && category.parent_term
                      ? `${category.name} (${category.parent_term.name})`
                      : category.name
                  "></a>
          </li>
        </ul>
      </li>

      <li v-show="foundProducts">
        <ul class="selleradiseHeader__searchResults-suggestions--products">
          <li class="selleradiseHeader__searchResults-title">
            <h2 v-text="trans('Products')"></h2>
          </li>

          <li v-for="(product, i) in products" :key="product.guid" class="productItem" :ref="
                  (el) => {
                    if (el) {
                      items['products'][i] = el;
                    }
                  }
                ">
            <a :href="product.guid">
              <div class="image" :style="{ backgroundImage: `url(${product.image_url})` }"></div>

              <div class="content">
                <h3 class="title" :href="product.guid" v-html="
                        highlightedSuggestion(product.post_title, keyword)
                      "></h3>
                <span class="price" v-html="product.price"></span>
              </div>
            </a>
          </li>
        </ul>
      </li>

      <li v-show="foundPosts">
        <ul class="selleradiseHeader__searchResults-suggestions--posts">
          <li class="selleradiseHeader__searchResults-title">
            <h2 v-text="trans('Other')"></h2>
          </li>
          <li v-for="(post, i) in posts" :key="post.link" :ref="
                  (el) => {
                    if (el) {
                      items['posts'][i] = el;
                    }
                  }
                ">
            <div class="content">
              <a class="title" :href="post.link" v-text="post.title"></a>
            </div>
          </li>
        </ul>
      </li>

      <div class="nothingFound" v-if="state.matches('not_found')">
        <span class="inlineSVGIcon" v-html="
                require(`!svg-inline-loader!../../../dist/svg/misc/empty-state.svg`)
              "></span>
        <p v-text="trans('Nothing Found')"></p>
      </div>
    </ul>
  </div> -->
</form>