<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="edublink-single-course course-style-' . esc_attr( $args['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $args['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            echo '<div class="course-price">';
                echo wp_kses_post( EduBlink_SS_Helper::course_price() );
            echo '</div>';

            echo '<div class="read-more-btn">';
                echo '<a class="btn-icon-round" href="' . esc_url( get_the_permalink() ) . '"><i class="icon-4"></i></a>';
            echo '</div>';
        echo '</div>';

        echo '<div class="content-inner">';
            echo '<div class="instructor">';
                EduBlink_SS_Helper::instructor();
            echo '</div>';

            echo '<div class="content">';
                echo edublink_get_title();

                if ( true === $args['enable_excerpt'] ) :
                    echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $args['excerpt_length'] ), esc_html( $args['excerpt_end'] ) ) );
                endif;
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';