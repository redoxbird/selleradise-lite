<button x-on:click="$dispatch('start-search');" class="selleradiseHeader__trigger selleradiseHeader__trigger--search" x-tooltip="triggerSearchTooltip">
  <span id="triggerSearchTooltip" role="tooltip" class="selleradise_tooltip">
    <?php esc_html_e('Search', 'selleradise-lite'); ?>
  </span>
  <?php echo selleradise_svg('tabler-icons/search') ?>
</button>