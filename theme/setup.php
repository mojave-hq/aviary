<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function aviary_setup()
{
    /**
     * Make theme available for translation.
     * Translations can be filed in the /resources/lang/ directory.
     * If you're building a theme based on Aviary, use a find and replace
     * to change 'aviary' to the name of your theme in all the template files.
     */
    load_theme_textdomain('aviary', get_template_directory().'/resources/lang');

    // Add default posts and comments RSS feed links to head.
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
    register_nav_menus(
        [
            'menu-1' => esc_html__('Primary', 'aviary'),
        ]
    );

    /**
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'aviary_custom_background_args',
            [
                'default-color' => 'ffffff',
                'default-image' => '',
            ]
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        [
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ]
    );
}

/**
 * Undocumented function.
 */
function aviary_add_templates_directory_to_hierarchy(array $templates)
{
    return call_user_func_array(
        'array_merge',
        array_map(function ($template) {
            return ["resources/views/{$template}", $template];
        }, $templates)
    );
}

array_map(function ($type) {
    add_filter("{$type}_template_hierarchy", 'aviary_add_templates_directory_to_hierarchy');
}, [
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed',
]);

function aviary_get_partial($type, $name = null)
{
    $templates = [];

    if (null !== $name) {
        $templates[] = "templates/{$type}-{$name}.php";
        $templates[] = "{$type}-{$name}.php";
    }

    $templates[] = "templates/{$type}.php";
    $templates[] = "{$type}.php";

    locate_template($templates, true, false);
}

function aviary_get_header($name = null)
{
    do_action('get_header', $name);

    aviary_get_partial('header', $name);
}

function aviary_get_footer($name = null)
{
    do_action('get_footer', $name);

    aviary_get_partial('footer', $name);
}

function aviary_get_sidebar($name = null)
{
    do_action('get_sidebar', $name);

    aviary_get_partial('sidebar', $name);
}
