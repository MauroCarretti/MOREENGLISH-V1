<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class EduBlink_LL_Helper {

    public static function instructor( $tag = 'h6', $image_size = 40 ) {
		echo '<a class="author-name" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ) . '">';

        echo get_avatar( get_the_author_meta( 'ID' ), $image_size );

        echo '<' . esc_attr( $tag) . ' class="instructor-name">';
            the_author();
        echo '</' . esc_attr( $tag) . '>';
    }
    
    public static function course_price( &$product = null ) {
		if ( is_null( $product ) ) :
			$product = new LLMS_Product( get_the_ID() );
        endif;

		$purchaseable = $product->is_purchasable();
		$has_free     = $product->has_free_access_plan();
		$free_only    = ( $has_free && ! $purchaseable );
		$price_html   = '';

		if ( $free_only ) :
			$price_html .= __( 'Free', 'edublink' );
		elseif ( $purchaseable ) :
			$plans = $product->get_access_plans( $free_only );

			if ( $plans ) :
				$index   = 0;
				$is_free = false;
				foreach ( $plans as $plan ) :
					$price_key = $plan->is_on_sale() ? 'sale_price' : 'price';
					$price     = $plan->get_price( $price_key, [], 'float' );

					if ( 0.0 === $price ) :
						$min_price = $plan->get_free_pricing_text( 'html' );
						$min_key   = $index;
						$is_free   = true;
						break;
                    endif;

					if ( ! isset( $min_price ) ) :
						$min_price = $price;
						$min_key   = $index;
                    endif;

					if ( $price < $min_price ) :
						$min_price = $price;
						$min_key   = $index;
                    endif;
					$index ++;
				endforeach;
				if ( isset( $min_price ) ) :
					if ( $is_free ) :
						$price_html .= $min_price;
					else :
						if ( count( $plans ) > 1 ) :
							$price_html .= '<span class="course-price-prefix">' . esc_html_x( 'Starts', 'Course Staring Price', 'edublink' ) . '</span>';
                        endif;

						$price_html .= llms_price( $min_price, [] );
						$schedule = $plans[ $min_key ]->get_schedule_details();

						if ( ! empty( $schedule ) ) :
							$price_html .= sprintf( '<span class="course-price-schedule">%s</span>', $schedule );
                        endif;
					endif;
				endif;
			endif;
		endif;

		return $price_html;
    }
}