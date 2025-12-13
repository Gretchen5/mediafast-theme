<?php

/**
 * Enqueue styles and scripts
 *
 * @package mediafast
 */


if (! function_exists('mediafast_enqueue_assets')) {
    /**
     * Enqueue theme styles and scripts
     *
     * @return void
     */
    function mediafast_enqueue_assets()
    {
        // Vendor Theme CSS
        // Base styles
        // wp_enqueue_style(
        //     'theme-style',
        //     get_template_directory_uri() . '/assets/vendor-theme/css/style.css',
        //     [],
        //     null
        // );
        // Base styles
        wp_enqueue_style(
            'icon-style',
            get_template_directory_uri() . '/assets/vendor-theme/css/icon.css',
            [],
            null
        );

        // Responsive styles
        wp_enqueue_style(
            'theme-responsive',
            get_template_directory_uri() . '/assets/vendor-theme/css/responsive.css',
            ['theme-style'], // depends on base
            null
        );

        // Vendor styles (carousels, popups, animations, etc.)
        // wp_enqueue_style(
        //     'theme-vendors',
        //     get_template_directory_uri() . '/assets/vendor-theme/css/vendors.css',
        //     ['theme-style'],
        //     null
        // );

        // Finance styles
        wp_enqueue_style(
            'finance',
            get_template_directory_uri() . '/assets/vendor-theme/finance/finance.css',
            ['theme-style'],
            null
        );




        // Vendor Theme JS

        // Load vendor bundle (includes Swiper, Magnific Popup, GSAP, etc.)

        wp_enqueue_script('jquery');

        // wp_enqueue_script(
        //     'vendor-theme-vendors',
        //     get_template_directory_uri() . '/assets/vendor-theme/js/vendors.js',
        //     array('jquery'),
        //     null,
        //     true
        // );

        // Load Swiper (if not already in vendor bundle)
        // wp_enqueue_script(
        //     'vendor-theme-swiper',
        //     get_template_directory_uri() . '/assets/vendor-theme/js/vendors/swiper-bundle.js',
        //     array('jquery'),
        //     null,
        //     true
        // );

        // Load the main theme JS (initializes animations, sliders, etc.)
        // wp_enqueue_script(
        //     'vendor-theme-main',
        //     get_template_directory_uri() . '/assets/vendor-theme/js/main.js',
        //     array('jquery', 'vendor-theme-vendors'),
        //     null,
        //     true
        // );

        // Load the main theme JS (initializes template_block js)
        wp_enqueue_script(
            'custom-template-tiles',
            get_template_directory_uri() . '/assets/template-tiles.js',
            array(),
            null,
            true
        );


    }
    add_action('wp_enqueue_scripts', 'mediafast_enqueue_assets');
}
