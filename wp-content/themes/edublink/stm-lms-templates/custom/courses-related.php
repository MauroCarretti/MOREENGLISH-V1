<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

global $post;
$courses_to_show = apply_filters( 'edublink_ms_related_course_count', -1 );
$terms           = get_the_terms( $post->ID, 'stm_lms_course_taxonomy' );
$term_ids        = array();

if ( $terms ) :
    foreach( $terms as $term ) :
        $term_ids[] = $term->term_id;
    endforeach;
endif;

$edublink_ms_params = array(
    'post_type'      => 'stm-courses',
    'posts_per_page' => $courses_to_show,
    'order'          => 'DESC',
    'post__not_in'   => array( $post->ID ),
    'tax_query'      => array(
        'relation'   => 'AND',
        array(
            'taxonomy' => 'stm_lms_course_taxonomy',
            'field'    => 'id',
            'terms'    => $term_ids,
            'operator' => 'IN'
        )
    )
);

$style = edublink_set_value( 'ms_related_course_style', 'default' );

if ( 'default' === $style ) :
    $style = edublink_set_value( 'ms_course_style', 1 );
endif;

$block_data = array(
    'style' => $style
);

$related = new WP_Query( $edublink_ms_params );
if ( $related->have_posts() ) :
    echo '<div class="edublink-related-course-content-wrapper edublink-container">';
        $heading = edublink_set_value( 'ms_related_course_title', __( 'Courses You May Like', 'edublink' ) );

        if ( $heading ) :
            echo '<div class="section-title">';
                echo '<h3 class="title related-course-title">' . esc_html( $heading ). '</h3>';
            echo '</div>';
        endif;
        
        // pass data-autoplay=true -> to start autoplay
        echo '<div class="edublink-related-course-items eb-swiper-carousel-activator swiper swiper-container swiper-container-initialized" data-lg-items="3" data-md-items="3" data-sm-items="2" data-xs-items="2">';
            echo '<div class="swiper-wrapper">';
                while ( $related->have_posts() ) : $related->the_post();
                    echo '<div class="swiper-slide">';
                        STM_LMS_Templates::show_lms_template( 'custom/course-block/blocks', compact( 'block_data' ) );
                    echo '</div>';
                endwhile;
                wp_reset_postdata();
            echo '</div>';
        echo '</div>';
    echo '</div>';
endif;