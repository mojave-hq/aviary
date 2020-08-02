<?php
/**
 * Template part for displaying posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
        if (is_singular()) {
            the_title('<h1 class="entry-title">', '</h1>');
        } else {
            the_title('<h2 class="entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">', '</a></h2>');
        }

        if ('post' === get_post_type()) {
            ?>
			<div class="entry-meta">
				<?php
                aviary_posted_on();
            aviary_posted_by(); ?>
			</div><!-- .entry-meta -->
		<?php
        } ?>
	</header><!-- .entry-header -->

	<?php aviary_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
        the_content(
                sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'aviary'),
                    [
                        'span' => [
                            'class' => [],
                        ],
                    ]
                ),
                wp_kses_post(get_the_title())
            )
            );

        wp_link_pages(
            [
                'before' => '<div class="page-links">'.esc_html__('Pages:', 'aviary'),
                'after'  => '</div>',
            ]
        );
        ?>
        <div id="react__votes"></div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php aviary_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
