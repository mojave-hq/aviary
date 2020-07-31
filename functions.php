<?php

/**
 * Aviary functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Aviary
 */

if (! defined('AVIARY_VERSION')) {
	// Replace the version number of the theme on each release.
	define('AVIARY_VERSION', '1.0.0');
}

if (! function_exists('aviary_setup')) :
	require get_template_directory() . '/theme/setup.php';
endif;
add_action('after_setup_theme', 'aviary_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function aviary_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters('aviary_content_width', 640);
}
add_action('after_setup_theme', 'aviary_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
require get_template_directory() . '/theme/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/theme/scripts.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/theme/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/theme/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/theme/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/theme/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/theme/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/theme/woocommerce.php';
}
