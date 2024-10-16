<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
global $post;

$edublink_related_products_to_show  = apply_filters( 'edublink_woo_related_product_count', 5 );
$edublink_related_products_terms    = get_the_terms( $post->ID, 'product_cat' );
$edublink_related_products_term_ids = array();

if ( $edublink_related_products_terms ) :
    foreach( $edublink_related_products_terms as $term ) :
        $edublink_related_products_term_ids[] = $term->term_id;
    endforeach;
endif;

$edublink_related_products_args = array(
    'post_type'      => 'product',
    'posts_per_page' => $edublink_related_products_to_show,
    'post__not_in'   => array( $post->ID ),
    'tax_query'      => array(
        'relation'   => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'id',
            'terms'    => $edublink_related_products_term_ids,
            'operator' => 'IN'
        )
    )
);

$edublink_related_products = new WP_Query( $edublink_related_products_args );
if ( $edublink_related_products->have_posts() ) :
    $subtitle = edublink_set_value( 'woo_related_products_subtitle', __( 'SIMILAR ITEMS', 'edublink' ) );
    $title = edublink_set_value( 'woo_related_products_title', __( 'Related Products', 'edublink' ) );

    if ( $title || $subtitle ) :
        echo '<div class="section-title text-center edublink-mb--50">';
            if ( $subtitle ) :
                echo '<span class="pre-title">' . esc_html( $subtitle ) . '</span>';
            endif;
            if ( $title ) :
                echo '<h3 class="title">' . esc_html( $title ) . '</h3>';
            endif;
        echo '</div>';
    endif;

    echo '<div class="edublink-related-product-items eb-swiper-carousel-activator swiper swiper-container swiper-container-initialized" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2">';
        echo '<div class="swiper-wrapper">';
            while ( $edublink_related_products->have_posts() ) : $edublink_related_products->the_post();
                echo '<div class="swiper-slide">';
                    echo '<div class="edublink-single-product-item">';
                        wc_get_template( 'custom/product-block/block.php' );
                    echo '</div>';
                echo '</div>';
            endwhile;
            wp_reset_postdata();
        echo '</div>';
    echo '</div>';
endif;