<?php
/**
 * Quick view content.
 *
 * @author  YITH
 * @package YITH WooCommerce Quick View
 * @version 1.0.0
 */

defined( 'YITH_WCQV' ) || exit; // Exit if accessed directly.

while ( have_posts() ) :
	the_post();
	?>

	<div class="product">

		<div id="product-<?php the_ID(); ?>" <?php post_class( 'product' ); ?>>

			<?php do_action( 'yith_wcqv_product_image' );

			echo '<div class="edublink-yith-wcqv-wrapper summary entry-summary">';
				echo '<div class="summary-content">';
					woocommerce_template_single_title();
					edublink_woo_single_product_rating( true );

					echo '<div class="product-pricing">';
						woocommerce_template_single_price();
					echo '</div>';

					echo '<div class="product-description">';
						woocommerce_template_single_excerpt();
					echo '</div>';

					echo '<div class="product-cart-wrapper">';
						woocommerce_template_single_add_to_cart();
					echo '</div>';

					echo '<div class="product-meta">';
						woocommerce_template_single_meta();
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
endwhile; // end of the loop.
