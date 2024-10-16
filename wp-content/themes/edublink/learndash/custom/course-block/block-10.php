<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="edublink-single-course course-style-' . esc_attr( $args['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $args['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            echo '<div class="course-price price-round">';
                echo wp_kses_post( EduBlink_LD_Helper::course_price() );
            echo '</div>';
        echo '</div>';

        echo '<div class="content">';
            if ( $args['cat_item'] ) :
                echo '<span class="course-level">' . wp_kses_post( $args['cat_item'] ) . '</span>';
            endif;

            echo edublink_get_title();

            echo '<ul class="course-meta">';
                echo '<li class="course-meta-lesson">';
                    echo '<i class="icon-24"></i>';
                    echo esc_html( $args['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';

                if ( $args['enrolled'] ) :
                    echo '<li class="course-meta-student">';
                        echo '<i class="icon-25"></i>';
                        echo esc_html( $args['enrolled'] );
                        _e( ' Students', 'edublink' );
                    echo '</li>';
                endif;
            echo '</ul>';
        echo '</div>';
    echo '</div>';
echo '</div>';