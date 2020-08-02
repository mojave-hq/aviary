<?php

function aviary_assets()
{
    wp_enqueue_style('aviary-style', get_template_directory_uri().'/public/css/theme.css', [], AVIARY_VERSION);
    // wp_style_add_data('aviary-style', 'rtl', 'replace');

    wp_enqueue_script('aviary-script', get_stylesheet_directory_uri() . '/public/js/theme.js', ['wp-element'], AVIARY_VERSION, true);

    wp_enqueue_script('aviary-navigation', get_template_directory_uri().'/resources/js/navigation.js', [], AVIARY_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'aviary_assets');
