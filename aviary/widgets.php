<?php

namespace Aviary;

/**
 * Register the sidebar widget area.
 */
add_action('widgets_init', function () {
    register_sidebar([
        'name' => esc_html__('Sidebar', 'aviary'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add sidebar widgets here.', 'aviary'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ]);
});
