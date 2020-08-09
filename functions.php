<?php

namespace Aviary;

/**
 * Aviary functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */
if (!defined('AVIARY_VERSION')) {
    define('AVIARY_VERSION', wp_get_theme()->version);
}

/**
 * 
 */
require get_template_directory().'/aviary/setup.php';

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */

add_action('after_setup_theme', function () {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('aviary_content_width', 640);
}, 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
require get_template_directory().'/aviary/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory().'/aviary/enqueue.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory().'/aviary/custom-header.php';

/**
 * Implement the Custom Login feature.
 */
require get_template_directory().'/aviary/custom-login.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory().'/aviary/support.php';

/**
 * Customizer additions.
 */
require get_template_directory().'/aviary/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory().'/aviary/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory().'/aviary/woocommerce.php';
}
