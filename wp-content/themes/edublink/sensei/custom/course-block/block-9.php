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
        echo '</div>';

        echo '<div class="content">';
            echo '<ul class="course-meta">';
                echo '<li class="course-meta-lesson">';
                    echo '<i class="icon-24 icon-course"></i>';
                    echo esc_html( $args['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';

                if ( $args['enrolled'] ) :
                    echo '<li class="course-meta-student">';
                        echo '<i class="icon-25 icon-course"></i>';
                        echo esc_html( $args['enrolled'] );
                        _e( ' Students', 'edublink' );
                    echo '</li>';
                endif;
            echo '</ul>';

            echo edublink_get_title();

            EduBlink_SS_Course_Review::display_review( $args['rating'], 'text' );

            if ( $args['button_text'] ) :
                echo '<div class="read-more-btn">';
                    echo '<a class="edu-btn btn-medium" href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $args['button_text'] ) . '<i class="icon-4"></i></a>';
                echo '</div>';
            endif;
        echo '</div>';
    echo '</div>';
echo '</div>';