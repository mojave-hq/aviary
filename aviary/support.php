<?php
/**
 * Functions which enhance the theme.
 */

namespace Aviary;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
add_filter('body_class', function ($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
});

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
add_action('wp_head', function () {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
});

/**
 * Shim for sites older than 5.2.
 *
 * @link https://core.trac.wordpress.org/ticket/12563
 */
function wp_body_open()
{
    do_action('wp_body_open');
}

function get_partial($type, $name = null)
{
    do_action('get_'.$type, $name);

    $templates = [];

    if (null !== $name) {
        $templates[] = "resources/views/partials/{$type}-{$name}.php";
        $templates[] = "{$type}-{$name}.php";
    }

    $templates[] = "resources/views/partials/{$type}.php";
    $templates[] = "{$type}.php";

    locate_template($templates, true, false);
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
function posted_on()
{
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date()),
        esc_attr(get_the_modified_date(DATE_W3C)),
        esc_html(get_the_modified_date())
    );

    $posted_on = sprintf(
        /* translators: %s: post date. */
        esc_html_x('Posted on %s', 'post date', 'aviary'),
        '<a href="'.esc_url(get_permalink()).'" rel="bookmark">'.$time_string.'</a>'
    );

    echo '<span class="posted-on">'.$posted_on.'</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Prints HTML with meta information for the current author.
 */
function posted_by()
{
    $byline = sprintf(
        /* translators: %s: post author. */
        esc_html_x('by %s', 'post author', 'aviary'),
        '<span class="author vcard"><a class="url fn n" href="'.esc_url(get_author_posts_url(get_the_author_meta('ID'))).'">'.esc_html(get_the_author()).'</a></span>'
    );

    echo '<span class="byline"> '.$byline.'</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function entry_footer()
{
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__(', ', 'aviary'));
        if ($categories_list) {
            /* translators: 1: list of categories. */
            printf('<span class="cat-links">'.esc_html__('Posted in %1$s', 'aviary').'</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'aviary'));
        if ($tags_list) {
            /* translators: 1: list of tags. */
            printf('<span class="tags-links">'.esc_html__('Tagged %1$s', 'aviary').'</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'aviary'),
                    [
                        'span' => [
                            'class' => [],
                        ],
                    ]
                ),
                wp_kses_post(get_the_title())
            )
        );
        echo '</span>';
    }

    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __('Edit <span class="screen-reader-text">%s</span>', 'aviary'),
                [
                    'span' => [
                        'class' => [],
                    ],
                ]
            ),
            wp_kses_post(get_the_title())
        ),
        '<span class="edit-link">',
        '</span>'
    );
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function post_thumbnail()
{
    if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
        return;
    }

    if (is_singular()) {
        ?>

            <div class="post-thumbnail">
        <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php } else { ?>

        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
        <?php
            the_post_thumbnail('post-thumbnail', [
                'alt' => the_title_attribute([
                    'echo' => false,
                ]),
            ]);
        ?>
        </a>

        <?php
    } // End is_singular().
}
