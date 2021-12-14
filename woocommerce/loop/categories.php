<?php

defined('ABSPATH') || exit;


do_action('selleradise_before_shop_categories');

?>

<div class="selleradise_shop__categories">
    <?php
      /**
       * Hook: woocommerce_after_main_content.
       *
       * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
       */
      do_action( 'woocommerce_after_main_content' );
    ?>

</div>


<?php

do_action('selleradise_after_shop_categories');
