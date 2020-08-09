<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

Aviary\get_partial('header'); ?>

	<main id="primary" class="site-main">

		<?php
        while (have_posts()) {
            the_post();

            get_template_part('resources/views/partials/content', get_post_type());

            the_post_navigation(
                [
                    'prev_text' => '<span class="nav-subtitle">'.esc_html__('Previous:', 'aviary').'</span> <span class="nav-title">%title</span>',
                    'next_text' => '<span class="nav-subtitle">'.esc_html__('Next:', 'aviary').'</span> <span class="nav-title">%title</span>',
                ]
            );

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
