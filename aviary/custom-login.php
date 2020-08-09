<?php

namespace Aviary;

/**
 * Load the CSS
 */
add_action('login_enqueue_scripts', function() {
	wp_enqueue_style('aviary-style-login', get_template_directory_uri().'/public/css/login.css', [], AVIARY_VERSION);
});

/**
 * Change header link to our site instead of wordpress.org
 */
add_filter('login_headerurl', function() {
	return get_bloginfo('url');
});

/**
 * Change logo title in from WordPress to our site name
 */
add_filter('login_headertext', function() {
	return get_bloginfo('name');
});