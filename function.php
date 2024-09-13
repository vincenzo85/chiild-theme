<?php 
	add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
	function my_theme_enqueue_styles() {
		wp_enqueue_style( 'listingpr-parent-style', get_template_directory_uri() . '/style.css' );
                    // Enqueue Child Style
    wp_enqueue_style(
        'child_style_lp',
        get_stylesheet_directory_uri() . '/assets/css/child_style.css',
        array('listingpr-parent-style'), // Set the parent style as a dependency
        wp_get_theme()->get('Version') // Version number for cache busting
    );
	}

add_action('wp_enqueue_scripts', 'LP_dynamic_php_css_enqueue', 20);
if (!function_exists('LP_dynamic_php_css_enqueue')) {
	function LP_dynamic_php_css_enqueue()
	{
		//wp_enqueue_style('LP_dynamic_php_css', get_template_directory_uri() . '/assets/css/dynamic-css.css', '');
	}
}

// Add dynamic inline CSS to the <head> section
function output_dynamic_css() {
    // Retrieve your theme options
    $listingpro_options = get_option('listingpro_options'); // Adjust this option name if necessary

    // Safely retrieve and escape the theme option values
    $top_bar_background_color = esc_attr($listingpro_options['top_bar_bg_inner']);
    $top_bar_opacity = $listingpro_options['top_bar_opacity'];
    $header_background_color = esc_attr($listingpro_options['header_bgcolor_inner_pages']);
    $home_header_background_color = esc_attr($listingpro_options['header_bgcolor']);
    $theme_color = esc_attr($listingpro_options['theme_color']);
    $header_text_color = esc_attr($listingpro_options['header_textcolor']);
    $h4_font_family = esc_attr($listingpro_options['h4_typo']['font-family']);
    $body_font_family = esc_attr($listingpro_options['typography-body']['font-family']);
    $banner_height = intval($listingpro_options['banner_height']); // Cast to integer for security
    $home_banner_image = esc_url($listingpro_options['home_banner']['url']);
    $lp_page_banner = esc_url($listingpro_options['page_header']['url']);
    
    // Output the CSS in the <head> section
    ?>
    <style type="text/css">
        :root {
            --top-bar-background-color: <?php echo $top_bar_background_color; ?>;
            --top-bar-opacity: <?php echo $top_bar_opacity; ?>;
            --header-background-color: <?php echo $header_background_color; ?>;
            --home-header-background-color: <?php echo $home_header_background_color; ?>;
            --theme-color: <?php echo $theme_color; ?>;
            --header-text-color: <?php echo $header_text_color; ?>;
            --h4-font-family: '<?php echo $h4_font_family; ?>';
            --body-font-family: '<?php echo $body_font_family; ?>';
            --banner-height: <?php echo $banner_height; ?>px;
            --home-banner-image: url('<?php echo $home_banner_image; ?>');
            --page-banner-image: url('<?php echo $lp_page_banner; ?>');
        }
        .lp-header-search-wrap {
    background-image: var(--home-banner-image) !important;
}
   
    </style>
    <?php
}

// Hook the function to wp_head to output the inline CSS
add_action('wp_head', 'output_dynamic_css', 1);
