 <button class="selleradiseHeader__trigger selleradiseHeader__trigger--mobileMenu" aria-label="<?php esc_attr_e('Menu', 'TEXT_DOMAIN'); ?>" x-tooltip="triggerMenuTooltip" x-on:click.prevent="$store.mobileMenu.open('menu')">
   <span id="triggerMenuTooltip" role="tooltip" class="selleradise_tooltip">
     <?php esc_html_e('Menu', 'TEXT_DOMAIN'); ?>
   </span>
   <?php echo selleradise_svg('tabler-icons/menu-2') ?>
 </button>