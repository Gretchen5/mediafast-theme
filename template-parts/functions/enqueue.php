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
        $theme_version = wp_get_theme()->get('Version');
        
        // Base styles
        wp_enqueue_style(
            'icon-style',
            get_template_directory_uri() . '/assets/vendor-theme/css/icon.css',
            [],
            $theme_version
        );

        // Responsive styles
        wp_enqueue_style(
            'theme-responsive',
            get_template_directory_uri() . '/assets/vendor-theme/css/responsive.css',
            ['theme-style'], // depends on base
            $theme_version
        );

        // Finance styles
        wp_enqueue_style(
            'finance',
            get_template_directory_uri() . '/assets/vendor-theme/finance/finance.css',
            ['theme-style'],
            $theme_version
        );

        // Vendor Theme JS

        // Note: jQuery is already enqueued in functions.php (mediafast_enqueue_scripts)
        // Don't duplicate jQuery here.

        // template-tiles.js: Load only on pages that use the template block.
        // Template Block adds inline data via wp_add_inline_script when that block renders.
        if (is_page(array('templates-and-graphic-design', 'cd-and-dvd-templates'))) {
            wp_enqueue_script(
                'custom-template-tiles',
                get_template_directory_uri() . '/assets/template-tiles.js',
                array(),
                $theme_version,
                true
            );
        }

    }
    add_action('wp_enqueue_scripts', 'mediafast_enqueue_assets');
}
