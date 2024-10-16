<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
global $post;
$edublink_related_posts_to_show  = edublink_set_value( 'blog_single_number_of_related_posts', 4 );
$edublink_related_posts_terms    = get_the_terms( $post->ID, 'category' );
$edublink_related_posts_term_ids = array();

if ( $edublink_related_posts_terms ) :
    foreach( $edublink_related_posts_terms as $term ) :
        $edublink_related_posts_term_ids[] = $term->term_id;
    endforeach;
endif;

$edublink_related_posts_args = array(
    'post_type'      => 'post',
    'posts_per_page' => $edublink_related_posts_to_show,
    'post__not_in'   => array( $post->ID ),
    'tax_query'      => array(
        'relation'   => 'AND',
        array(
            'taxonomy' => 'category',
            'field'    => 'id',
            'terms'    => $edublink_related_posts_term_ids,
            'operator' => 'IN'
        )
    )
);

$edublink_related_posts = new WP_Query( $edublink_related_posts_args );
if ( $edublink_related_posts->have_posts() ) :
    echo '<div class="edublink-related-posts-wrapper edublink-blog-post-archive-style-1">';
        $related_products_heading = edublink_set_value( 'blog_single_related_posts_title', __( 'Related Posts', 'edublink' ) );
        if ( $related_products_heading ) :
            echo '<h3 class="edublink-related-product-title">' . esc_html( $related_products_heading ) . '</h2>';
        endif;

        echo '<div class="edublink-related-product-items eb-swiper-carousel-activator swiper swiper-container swiper-container-initialized" data-lg-items="3" data-md-items="3" data-sm-items="2" data-xs-items="2">';
            echo '<div class="swiper-wrapper">';
                while ( $edublink_related_posts->have_posts() ) : $edublink_related_posts->the_post();
                    $edublink_post_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'edublink-post-thumb' );
                    if ( isset( $edublink_post_thumb_src ) && ! empty( $edublink_post_thumb_src ) ) :
                        $edublink_post_thumb_url = $edublink_post_thumb_src[0];
                    else :
                        $edublink_post_thumb_url = '';
                    endif;

                    echo '<div class="swiper-slide">';
                        echo '<div class="edublink-single-blog" style="background-image: url(' . esc_url( $edublink_post_thumb_url ) . ')">';
                            echo '<div class="blog-content">';
                                echo '<ul class="blog-meta date">';
                                    echo '<li><i class="flaticon-hour"></i>' . esc_html( get_the_date( get_option( 'date_format' ) ) ) . '</li>';
                                echo '</ul>';
                                the_title( '<h4 class="title"><a href="' . esc_url( get_the_permalink() ) . '" class="post-link">', '</a></h4>' );
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                endwhile;
                wp_reset_postdata();
            echo '</div>';
        echo '</div>';
    echo '</div>';
endif;