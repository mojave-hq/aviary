<?php
/**
 * WooCommerce Compatibility File.
 *
 * @link https://woocommerce.com/
 */

namespace MojaveHQ\Aviary\Theme;

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    add_theme_support(
        'woocommerce',
        [
            'thumbnail_image_width' => 150,
            'single_image_width'    => 300,
            'product_grid'          => [
                'default_rows'    => 3,
                'min_rows'        => 1,
                'default_columns' => 4,
                'min_columns'     => 1,
                'max_columns'     => 6,
            ],
        ]
    );
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
});

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('aviary-woocommerce-style', get_template_directory_uri().'/public/css/woocommerce.css', [], AVIARY_VERSION);

    $font_path = WC()->plugin_url().'/assets/fonts/';
    $inline_font = '@font-face {
                        font-family: "star";
                        src: url("'.$font_path.'star.eot");
                        src: url("'.$font_path.'star.eot?#iefix") format("embedded-opentype"),
                            url("'.$font_path.'star.woff") format("woff"),
                            url("'.$font_path.'star.ttf") format("truetype"),
                            url("'.$font_path.'star.svg#star") format("svg");
                        font-weight: normal;
                        font-style: normal;
                    }';

    wp_add_inline_style('aviary-woocommerce-style', $inline_font);
});

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', function () {
    return [];
});

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param array $classes CSS classes applied to the body tag.
 *
 * @return array $classes modified to include 'woocommerce-active' class.
 */
add_filter('body_class', function ($classes) {
    $classes[] = 'woocommerce-active';

    return $classes;
});

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 *
 * @return array $args related products args.
 */
add_filter('woocommerce_output_related_products_args', function ($args) {
    $defaults = [
        'posts_per_page' => 3,
        'columns'        => 3,
    ];

    $args = wp_parse_args($defaults, $args);

    return $args;
});

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', '\\woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', '\\woocommerce_output_content_wrapper_end', 10);

/**
 * Before Content.
 *
 * Wraps all WooCommerce content in wrappers which match the theme markup.
 *
 * @return void
 */
add_action('woocommerce_before_main_content', function () {
    ?>
        <main id="primary" class="site-main">
    <?php
});

/**
 * After Content.
 *
 * Closes the wrapping divs.
 *
 * @return void
 */
add_action('woocommerce_after_main_content', function () {
    ?>
        </main><!-- #main -->
    <?php
});

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
 * <?php
 * if ( function_exists( 'aviary_woocommerce_header_cart' ) ) {
 * aviary_woocommerce_header_cart();
 * }
 * ?>
 */

/**
 * Cart Fragments.
 *
 * Ensure cart contents update when products are added to the cart via AJAX.
 *
 * @param array $fragments Fragments to refresh via AJAX.
 *
 * @return array Fragments to refresh via AJAX.
 */
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start();
    aviary_woocommerce_cart_link();
    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
});

if (!function_exists('aviary_woocommerce_cart_link')) {
    /**
     * Cart Link.
     *
     * Displayed a link to the cart including the number of items present and the cart total.
     *
     * @return void
     */
    function aviary_woocommerce_cart_link()
    {
        ?>
		<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'aviary'); ?>">
			<?php
            $item_count_text = sprintf(
                /* translators: number of items in the mini cart. */
                _n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'aviary'),
            WC()->cart->get_cart_contents_count()
        ); ?>
			<span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span class="count"><?php echo esc_html($item_count_text); ?></span>
		</a>
		<?php
    }
}

if (!function_exists('aviary_woocommerce_header_cart')) {
    /**
     * Display Header Cart.
     *
     * @return void
     */
    function aviary_woocommerce_header_cart()
    {
        if (is_cart()) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        } ?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr($class); ?>">
				<?php aviary_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
                $instance = [
                    'title' => '',
                ];

        the_widget('WC_Widget_Cart', $instance); ?>
			</li>
		</ul>
		<?php
    }
}
