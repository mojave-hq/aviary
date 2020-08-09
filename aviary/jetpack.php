<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.com/
 */

namespace Aviary;

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
add_action('after_setup_theme', function () {
    // Add theme support for Infinite Scroll.
    add_theme_support('infinite-scroll', [
        'container' => 'main',
        'render'    => function () {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/content', is_search() ? 'search' : get_post_type());
            }
        },
        'footer' => 'page',
    ]);

    // Add theme support for Responsive Videos.
    add_theme_support('jetpack-responsive-videos');

    // Add theme support for Content Options.
    add_theme_support('jetpack-content-options', [
        'post-details' => [
            'stylesheet' => 'aviary-style',
            'date'       => '.posted-on',
            'categories' => '.cat-links',
            'tags'       => '.tags-links',
            'author'     => '.byline',
            'comment'    => '.comments-link',
        ],
        'featured-images' => [
            'archive' => true,
            'post'    => true,
            'page'    => true,
        ],
    ]);
});
