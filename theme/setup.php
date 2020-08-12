<?php

namespace MojaveHQ\Aviary\Theme;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
add_action('after_setup_theme', function () {
    /**
     * Make theme available for translation.
     * Translations can be filed in the /resources/lang/ directory.
     * If you're building a theme based on Aviary, use a find and replace
     * to change 'aviary' to the name of your theme in all the template files.
     */
    load_theme_textdomain('aviary', get_template_directory().'/resources/lang');

    /**
     * Add default posts and comments RSS feed links to head.
     */
    add_theme_support('automatic-feed-links');

    /**
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /**
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus([
        'primary' => esc_html__('Primary', 'aviary'),
    ]);

    /**
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters('aviary_custom_background_args', [
            'default-color' => 'ffffff',
            'default-image' => '',
        ])
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support('custom-logo', [
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
});

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

array_map(function ($type) {
    add_filter("{$type}_template_hierarchy", function (array $templates) {
        return call_user_func_array(
            'array_merge',
            array_map(function ($template) {
                return ["resources/views/{$template}", $template];
            }, $templates)
        );
    });
}, [
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed',
]);
