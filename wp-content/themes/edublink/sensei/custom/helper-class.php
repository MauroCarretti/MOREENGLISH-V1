<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class EduBlink_SS_Helper {

    public static function instructor( $tag = 'h6', $image_size = 40 ) {
        echo get_avatar( get_the_author_meta( 'ID' ), $image_size );

        echo '<' . esc_attr( $tag) . ' class="instructor-name">';
            the_author();
        echo '</' . esc_attr( $tag) . '>';
    }
    
    public static function course_price() {
        $wooproductID = get_post_meta( get_the_ID(), '_course_woocommerce_product', true );
		if( $wooproductID != '-' && ! empty( $wooproductID ) ) :
			$regular_price = get_woocommerce_currency_symbol().get_post_meta( $wooproductID, '_regular_price', true );
			$sale_price = get_woocommerce_currency_symbol().get_post_meta( $wooproductID, '_sale_price', true );
            if ( get_post_meta( $wooproductID, '_sale_price', true ) ) :
			    return $sale_price . '<span class="regular-price">' . wp_kses_post( $regular_price ) . '</span>';
            else :
                return $regular_price;
            endif;
		else :
			return __( 'Free' , 'edublink' );
		endif;
    }
}