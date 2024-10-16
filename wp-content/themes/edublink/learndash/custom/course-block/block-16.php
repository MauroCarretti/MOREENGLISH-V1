<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="edublink-single-course course-style-' . esc_attr( $args['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $args['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            if ( $args['duration'] ) :
                echo '<div class="time-top">';
                    echo '<span class="duration"><i class="icon-61"></i>' . esc_html( $args['duration'] ) . '</span>';
                echo '</div>';
            endif;
        echo '</div>';

        echo '<div class="content">';
            echo '<div class="course-price">';
                echo wp_kses_post( EduBlink_LD_Helper::course_price() );
            echo '</div>';

            echo edublink_get_title();

            if ( is_edublink_ld_rating_enable() ) :
                EduBlink_LD_Course_Review::display_review( $args['rating'], 'text' );
            endif;

            echo '<ul class="course-meta">';
                echo '<li class="course-meta-lesson">';
                    echo '<i class="icon-24"></i>';
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
        echo '</div>';
    echo '</div>';
echo '</div>';