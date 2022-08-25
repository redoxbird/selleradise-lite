<main id="main" class="site-main w-full flex-grow self-stretch lg:w-2/3" role="main">

  <?php if ( have_posts() ) : ?>
    <div class="posts grid md:grid-cols-2 gap-8 mt-8" data-selleradise-post-card-type="default">

      <?php 
        global $wp_query;

        while (have_posts()): the_post();

          if($wp_query->current_post == 0 && !is_paged() && !is_singular()) {
            get_template_part('template-parts/post/card','default-sticky');
          } else {
            get_template_part('template-parts/post/card', "default");
          }

        endwhile;
      ?>
    </div>
    
    <?php if($wp_query->max_num_pages > 1): ?>
      <div class="selleradise_pagination">
        <?php
          $args = [
            'base'		=> str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'		=> $wp_query->max_num_pages,
            'current'	=> max( 1, get_query_var( 'paged' ) ),
            'format'	=> '?paged=%#%',
            'show_all'	=> false,
            'type'		=> 'list',
            'end_size'	=> 0,
            'mid_size'	=> 2,
            'prev_next'	=> true,
            'prev_text' => sprintf('<span class="sr-only">%s</span>', __('Previous', 'TEXT_DOMAIN')).selleradise_svg('tabler-icons/chevron-left'),
            'next_text' => sprintf('<span class="sr-only">%s</span>', __('Next', 'TEXT_DOMAIN')).selleradise_svg('tabler-icons/chevron-right'),
            'add_args'	=> false,
            'add_fragment' => '',
            'aria_current' => "page",
          ];

          echo paginate_links($args);
        ?>
      </div>
    <?php endif; ?> 

    <?php else:
      get_template_part( 'template-parts/content', 'none' );
    endif;
  ?>

</main><!-- #main -->