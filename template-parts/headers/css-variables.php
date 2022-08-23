<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


$fonts = selleradise_get_fonts();

$header_heights = [
    'default' => '6rem',
    'simple'  => '6rem',
    'common'  => '6rem',
    'minimal' => '6rem',
    'robust' => '10.5rem',
    'robust-alt' => '10.5rem',
    'robust-centered' => '10.5rem',
    'centered' => '6rem',
    'custom' => get_theme_mod('header_custom_height', '6rem'),
];

$header_height = $header_heights[get_theme_mod('header_type', 'default')] ?? '6rem';

$color_variables = [
    'main', 'main_text', 'background', 'text', 'accent_light', 'accent_light_text'
];

?>

<style>
   
    :root {
        <?php 
            foreach($color_variables as $name) {
                $css_property = sprintf('color-%s', str_replace('_', '-', $name));
                $color_value = get_theme_mod('color_'.$name, selleradise_get_default_color($name));
                $color_value_rgb = get_theme_mod('color_'.$name.'_rgb', selleradise_get_default_color($name.'_rgb'));

                echo esc_html(sprintf('--light-theme_%s:%s;', $css_property, $color_value));
                echo esc_html(sprintf('--light-theme_%s-rgb:%s;', $css_property, $color_value_rgb));
            };
       
            foreach($color_variables as $name) {
                $css_property = sprintf('color-%s', str_replace('_', '-', $name));
                $color_value = get_theme_mod('dark_mode_color_'.$name, selleradise_get_default_color('dark-theme_'.$name));
                $color_value_rgb = get_theme_mod('dark_mode_color_'.$name.'_rgb', selleradise_get_default_color('dark-theme_'.$name).'_rgb');
                
                echo esc_html(sprintf('--dark-theme_%s:%s;', $css_property, $color_value));
                echo esc_html(sprintf('--dark-theme_%s-rgb:%s;', $css_property, $color_value_rgb));
            };
        ?>

        --selleradise-color-shadow: rgba(0,0,0,0.1);

        <?php 
            foreach($fonts as $key => $font) {
                if(!isset($font['font-weight'])) {
                    $font['font-weight'] = selleradise_get_font_weight($font['variant']);
                }
                
                foreach ($font as $property => $value) {
                    echo esc_html(sprintf('--selleradise-font-%s-%s: %s;', $key, $property, $value));
                }
            };
        ?>

        --border-radius-base: 1.5em;
        --border-radius-half: calc(var(--border-radius-base) / 2);
        --border-radius-fourth: calc(var(--border-radius-base) / 4);
        --border-radius-x2: calc(var(--border-radius-base) * 2);
        --page-padding: 5vw;
        --header-height: <?php echo esc_html( $header_height ); ?>;
        --hero-height: calc(100vh - var(--header-height));
        --product-image-ratio: <?php echo esc_html(selleradise_get_product_image_ratio()); ?>;

        --swiper-preloader-color: var(--selleradise-color-main);
        --swiper-theme-color: var(--selleradise-color-main);
    }

    :root[data-selleradise-theme-type="light"] {
        <?php 
            foreach($color_variables as $css_property => $theme_mod_name) {
                echo esc_html(sprintf('--selleradise-color-%s: var(--light-theme_color-%s);', str_replace('_', '-', $theme_mod_name), str_replace('_', '-', $theme_mod_name)));
                echo esc_html(sprintf('--selleradise-color-%s-rgb: var(--light-theme_color-%s-rgb);', str_replace('_', '-', $theme_mod_name), str_replace('_', '-', $theme_mod_name)));
            };
        ?>

        --selleradise-color-light: var(--light-theme_color-background);
        --selleradise-color-dark: var(--light-theme_color-text);
    }
    
</style>

