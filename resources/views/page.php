<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
Aviary\get_partial('header'); ?>

	<main id="primary" class="site-main">

		<?php
        while (have_posts()) {
            the_post();

            get_template_part('resources/views/partials/content', 'page');

            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
        } // End of the loop.
        ?>

	</main><!-- #main -->

<?php

Aviary\get_partial('sidebar');
Aviary\get_partial('footer');
