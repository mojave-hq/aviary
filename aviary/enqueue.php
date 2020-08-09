<?php

namespace Aviary;

add_action('wp_enqueue_scripts', function () {
    // JS
    wp_enqueue_script('aviary-script', get_stylesheet_directory_uri().'/public/js/theme.js', ['wp-element'], AVIARY_VERSION, true);

    // CSS
    wp_enqueue_style('aviary-style', get_template_directory_uri().'/public/css/theme.css', ['google-fonts'], AVIARY_VERSION);
    // wp_style_add_data('aviary-style', 'rtl', 'replace');

    wp_enqueue_style('google-fonts', '');

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
});
