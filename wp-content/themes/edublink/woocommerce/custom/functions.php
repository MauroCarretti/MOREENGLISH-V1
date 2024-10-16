<?php

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

add_action( 'woocommerce_before_shop_loop', 'edublink_woocommerce_shop_top', 20 );

add_filter( 'woocommerce_product_single_add_to_cart_text', 'edublink_woocommerce_single_product_add_to_cart_text' );

add_filter( 'woocommerce_product_description_heading', '__return_null' );

add_filter( 'woocommerce_product_additional_information_heading', '__return_null' );

add_filter( 'woocommerce_review_gravatar_size', 'edublink_woocommerce_review_list_avatar_size' );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product_summary', 'edublink_woocommerce_output_related_products', 20 );


add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5 );

add_action( 'woocommerce_before_single_product_summary', 'edublink_woocommerce_single_product_summary_start', 5 );

add_action( 'woocommerce_after_single_product_summary', 'edublink_woocommerce_single_product_summary_end', 5 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 6 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 35 );

add_action( 'after_setup_theme', 'edublink_remove_image_zoom_support', 100 );

add_filter( 'formatted_woocommerce_price', 'edublink_woo_price_decimal_separator', 10, 5 );

// if ( edublink_set_value( 'woo_variable_products', true ) ) :
	// remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
// endif;

/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package EduBlink
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function edublink_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
}
add_action( 'after_setup_theme', 'edublink_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 * 
 * @since 1.0.0
 */
function edublink_woocommerce_scripts() {
	wp_enqueue_style( 'edublink-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', array( 'woocommerce-general' ), EDUBLINK_THEME_VERSION );
	$image_lightbox_only = apply_filters( 'edublink_woo_single_product_zoom_enable', true );
	if ( is_product() && ! $image_lightbox_only ) :
		wp_enqueue_style( 'jquery-fancybox' );
		wp_enqueue_script( 'jquery-fancybox' );
	endif;

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'edublink-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'edublink_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function edublink_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'edublink_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function edublink_woocommerce_products_per_page() {
	$cols = edublink_set_value( 'woo_number_of_products', '12' );
  	return $cols;
}
add_filter( 'loop_shop_per_page', 'edublink_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function edublink_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'edublink_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function edublink_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'edublink_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function edublink_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'edublink_woocommerce_related_products_args' );

if ( ! function_exists( 'edublink_woocommerce_product_columns_wrapper' ) ) :
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function edublink_woocommerce_product_columns_wrapper() {
		$columns = edublink_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
endif;
// add_action( 'woocommerce_before_shop_loop', 'edublink_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'edublink_woocommerce_product_columns_wrapper_close' ) ) :
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function edublink_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
endif;
// add_action( 'woocommerce_after_shop_loop', 'edublink_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'edublink_woocommerce_wrapper_before' ) ) :
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function edublink_woocommerce_wrapper_before() {
			echo '<div id="primary" class="' . esc_attr( apply_filters( 'edublink_woo_content_area_class', 'content-area' ) ) . '">';
				echo '<main id="main" class="site-main" role="main">';
	}
endif;
add_action( 'woocommerce_before_main_content', 'edublink_woocommerce_wrapper_before' );

if ( ! function_exists( 'edublink_woocommerce_wrapper_after' ) ) :
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function edublink_woocommerce_wrapper_after() {
			echo '</main>';
		echo '</div>';
	}
endif;
add_action( 'woocommerce_after_main_content', 'edublink_woocommerce_wrapper_after' );

if ( ! function_exists( 'edublink_woo_single_content_class' ) ) :
	function edublink_woo_single_content_class( $args ) {
		if ( is_singular( 'product' ) ) :
			return 'content-area edublink-main-content-inner edublink-container';
		else :
			return $args;
		endif;
	}
endif;
add_filter( 'edublink_woo_content_area_class', 'edublink_woo_single_content_class' );

if ( ! function_exists( 'edublink_woocommerce_cart_link_fragment' ) ) :
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function edublink_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		edublink_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
endif;

add_filter( 'woocommerce_add_to_cart_fragments', 'edublink_woocommerce_cart_link_fragment' );

/**
 * Cart Fragments for Elementor Woo Mini Cart Widget
 *
 * Displayed a link to the cart including the number of items present and the cart total.
 *
 * @param array $fragments Fragments to refresh via AJAX.
 * @return array Fragments to refresh via AJAX.
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'edublink_mini_cart_fragment' ) ) :
	function edublink_mini_cart_fragment( $fragments ) {
		$fragments['span.edublink-woo-mini-cart-total-item'] = '<span class="edublink-woo-mini-cart-total-item">' . WC()->cart->get_cart_contents_count() . '</span>';
		$fragments['span.edublink-woo-mini-cart-total-price'] = '<span class="edublink-woo-mini-cart-total-price">' . WC()->cart->get_cart_subtotal() . '</span>';
		return $fragments;
	}
endif;
add_filter( 'woocommerce_add_to_cart_fragments', 'edublink_mini_cart_fragment' );


if ( ! function_exists( 'edublink_woocommerce_cart_link' ) ) :
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function edublink_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'edublink' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'edublink' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
endif;

if ( ! function_exists( 'edublink_woocommerce_header_cart' ) ) :
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function edublink_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php edublink_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
endif;

/**
 * To change add to cart text on single product page
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_woocommerce_single_product_add_to_cart_text' ) ) :
	function edublink_woocommerce_single_product_add_to_cart_text() {
	    return __( 'Add to cart', 'edublink' ); 
	}
endif;

/**
 * To change add to cart text on shop page
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_woocommerce_replace_add_to_cart_text' ) ) :
	function edublink_woocommerce_replace_add_to_cart_text() {
	    return __( 'Buy Now', 'edublink' ); 
	}
endif;

/**
 * Single Product shop top
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_woocommerce_shop_top' ) ) :
	function edublink_woocommerce_shop_top() {
	    wc_get_template( 'custom/template-parts/shop-top.php' );
	}
endif;

/**
 * Single product wrapper start
 * 
 * @since 1.0.0
 */

if ( ! function_exists( 'edublink_woocommerce_single_product_summary_start' ) ) :
	function edublink_woocommerce_single_product_summary_start() {
		echo '<div class="edublink-single-product-main-content-wrapper">';
	}
endif;

/**
 * Single product wrapper end
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_woocommerce_single_product_summary_end' ) ) :
	function edublink_woocommerce_single_product_summary_end() {
		echo '</div>';
	}
endif;

/**
 * Before Course Content Area
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_woocommerce_output_related_products' ) ) :
	function edublink_woocommerce_output_related_products() {
		$show = edublink_set_value( 'woo_related_products', false );
		if ( $show ) :
			echo '<div class="edublink-related-product-content-wrapper">';
				wc_get_template( 'custom/products-related.php' );
			echo '</div>';
		endif;
	}
endif;

/**
 * product review submit button content change
 * 
 * @since 1.0.0
 */ 
if ( ! function_exists( 'edublink_woocommerce_product_review_submit_button' ) ) :
	function edublink_woocommerce_product_review_submit_button( $comment_form ){
		$comment_form['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">%4$s</button>';
		return $comment_form;
	}
endif;
add_filter( 'woocommerce_product_review_comment_form_args', 'edublink_woocommerce_product_review_submit_button' );

/**
 * product review user thumb size
 * 
 * @since 1.0.0
 */ 
if ( ! function_exists( 'edublink_woocommerce_review_list_avatar_size' ) ) :
	function edublink_woocommerce_review_list_avatar_size(){
		return 80;
	}
endif;

/**
 * remove zoom hover effect on WooCommerce Product Details Page
 * 
 * @since 1.0.0
 */ 
if ( ! function_exists( 'edublink_remove_image_zoom_support' ) ) :
	function edublink_remove_image_zoom_support() {
		remove_theme_support( 'wc-product-gallery-zoom' );
		remove_theme_support( 'wc-product-gallery-lightbox' );
	}
endif;

/**
 * Add Decimal Separator in Price
 * 
 * @since 1.0.0
 */ 
if ( ! function_exists( 'edublink_woo_price_decimal_separator' ) ) :
	function edublink_woo_price_decimal_separator( $formatted_price, $price, $decimal_number, $decimal_separator, $thousand_separator ) {
		if ( $decimal_number > 0 && ! empty( $decimal_separator ) ) :
			$origin_price = str_replace( $decimal_separator, '<span class="decimal-separator">' . $decimal_separator, $formatted_price );
			$origin_price .= '</span>';

			return $origin_price;
		endif;

		return $formatted_price;
	}
endif;

/**
 * return product offer in percentage
 * 
 * @since 1.0.0
 */ 
if ( ! function_exists( 'edublink_woo_product_price_offer_percentage' ) ) :
	function edublink_woo_product_price_offer_percentage() {
		global $product;
		if( $product->is_on_sale() && $product->is_in_stock() && ! $product->is_type( 'variable' ) ) :
			$regular_price = $product->get_regular_price();
			if ( $regular_price ) :
				$sale_price = $product->get_price();
				$percentage = round( 100 - ( $sale_price / $regular_price * 100 ) ) . '%';
				$percentage = apply_filters( 'edublink_woo_product_price_percent', $percentage );
				$prefix = apply_filters( 'edublink_woo_product_percent_prefix', '-' );
				return '<span class="eb-product-offer-percent">' . esc_html( $prefix ) . esc_html( $percentage ) . '</span>';
			endif;
		endif;
		return;
	}
endif;

/**
 * return featured product tag text
 * 
 * @since 1.0.0
 */ 
if ( ! function_exists( 'edublink_woo_featured_product_tag' ) ) :
	function edublink_woo_featured_product_tag() {
		global $product;
		if ( $product->is_featured() && $product->is_in_stock() ) :
			$tag = apply_filters( 'edublink_featured_product_tag_text', __( 'Hot', 'edublink' ) );
			return '<span class="eb-featured-product-tag">' . esc_html( $tag ) . '</span>';
		endif;
		return;
	}
endif;

/**
 * print single product top content
 * 
 * @since 1.0.0
 */ 
if ( ! function_exists( 'edublink_woo_single_product_top_content' ) ) :
	function edublink_woo_single_product_top_content() {
		if ( edublink_woo_featured_product_tag() || edublink_woo_product_price_offer_percentage() ) :
			echo '<div class="eb-product-image-top-content">';
				echo edublink_woo_featured_product_tag();
				echo edublink_woo_product_price_offer_percentage();
			echo '</div>';
		endif;
	}
endif;

/**
 * Product Rating
 * 
 * @since 1.0.0
 */ 
if ( ! function_exists( 'edublink_woo_single_product_rating' ) ) :
	function edublink_woo_single_product_rating( $rating_only = false ) {
		global $product;
		$rating_count = $product->get_rating_count();
		$count_total_rating = $product->get_review_count();
		$average      = $product->get_average_rating();
		if ( $count_total_rating && wc_review_ratings_enabled() ) :
			echo '<div class="edublink-product-rating-wrapper">';
				echo wc_get_rating_html( $average, $rating_count );
				if ( $rating_only ) :
					echo '<div class="edublink-yith-wcqv-rating-number">';
						$reviews_title = sprintf( esc_html( _n( '(%1$s Review)', '(%1$s Reviews)', $count_total_rating, 'edublink' ) ), esc_html( $count_total_rating ) );
						echo wp_kses_post( $reviews_title );
					echo '</div>';
				else :
					echo '(' . esc_html($average ) . ')';
				endif;
			echo '</div>';
		endif;
	}
endif;