<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 */
MojaveHQ\Aviary\Theme\get_partial('header'); ?>

	<main id="primary" class="site-main">

		<?php if (have_posts()) { ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
                    /* translators: %s: search query. */
                    printf(esc_html__('Search Results for: %s', 'aviary'), '<span>'.get_search_query().'</span>');
                    ?>
				</h1>
			</header><!-- .page-header -->

			<?php
            /* Start the Loop */
            while (have_posts()) {
                the_post();

                /**
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part('resources/views/partials/content', 'search');
            }

            the_posts_navigation();

        } else {
            get_template_part('resources/views/partials/content', 'none');
        }
        ?>

	</main><!-- #main -->

<?php

MojaveHQ\Aviary\Theme\get_partial('sidebar');
MojaveHQ\Aviary\Theme\get_partial('footer');
