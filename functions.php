<?php

namespace MojaveHQ\Aviary;

/**
 * Aviary functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 */
if (!defined('AVIARY_VERSION')) {
    define('AVIARY_VERSION', wp_get_theme()->version);
}

/**
 * Set up the theme.
 */
require get_template_directory().'/theme/setup.php';

/**
 * Register widget areas.
 */
require get_template_directory().'/theme/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory().'/theme/enqueue.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory().'/theme/custom-header.php';

/**
 * Implement the Custom Login feature.
 */
require get_template_directory().'/theme/custom-login.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory().'/theme/support.php';

/**
 * Customizer additions.
 */
require get_template_directory().'/theme/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory().'/theme/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory().'/theme/woocommerce.php';
}
