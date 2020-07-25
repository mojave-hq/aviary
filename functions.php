<?php

namespace Theme;

/**
 * Aviary functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Aviary
 */

define( 'THEME_TEMPLATE_DIRECTORY', 'resources/views' );

array_map(function ($type) {
	add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\views');
}, [
	'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
]);

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(views($templates));
}

function views( $templates = [] ) {
	if( empty( $templates ) || ! is_array( $templates ) ){
        return $templates;
	}

	if (count($templates) < 3 && $templates[0] !== 'archive.php' && $templates[1] !== 'archive.php') {
		return $templates;
	}
	
    $page_template_id = 0;
    $count = count( $templates );
    if( $templates[0] === get_page_template_slug() ) {
        $page_template_id = 1;
    }

    for( $i = $page_template_id; $i < $count ; $i++ ) {  
		$templates[$i] = THEME_TEMPLATE_DIRECTORY . '/' . $templates[$i];
    }

    return $templates;
}

if ( ! defined( 'AVIARY_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'AVIARY_VERSION', '1.0.0' );
}

if ( ! function_exists( 'aviary_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function aviary_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /resources/lang/ directory.
		 * If you're building a theme based on Aviary, use a find and replace
		 * to change 'aviary' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'aviary', get_template_directory() . '/resources/lang' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'aviary' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'aviary_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', __NAMESPACE__.'\\aviary_setup' );

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
	$GLOBALS['content_width'] = apply_filters( 'aviary_content_width', 640 );
}
add_action( 'after_setup_theme', __NAMESPACE__.'\\aviary_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function aviary_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'aviary' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'aviary' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', __NAMESPACE__.'\\aviary_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function aviary_scripts() {
	wp_enqueue_style( 'aviary-style', get_template_directory_uri() . '/public/css/theme.css', array(), AVIARY_VERSION );
	wp_style_add_data( 'aviary-style', 'rtl', 'replace' );

	wp_enqueue_script( 'aviary-navigation', get_template_directory_uri() . '/resources/js/navigation.js', array(), AVIARY_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__.'\\aviary_scripts' );

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
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/theme/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/theme/woocommerce.php';
}
