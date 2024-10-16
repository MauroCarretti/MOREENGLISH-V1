<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="edublink-single-course course-style-' . esc_attr( $block_data['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $block_data['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            if ( $block_data['duration'] ) :
                echo '<div class="time-top">';
                    echo '<span class="duration"><i class="icon-61"></i>' . esc_html( $block_data['duration'] ) . '</span>';
                echo '</div>';
            endif;
        echo '</div>';

        echo '<div class="content">';
            echo '<div class="course-price">';
                echo wp_kses_post( EduBlink_LL_Helper::course_price() );
            echo '</div>';

            echo edublink_get_title();

            echo '<ul class="course-meta">';
                echo '<li class="course-meta-lesson">';
                    echo '<i class="icon-24"></i>';
                    echo esc_html( $block_data['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';

                echo '<li class="course-meta-student">';
                    echo '<i class="icon-25 icon-course"></i>';
                    echo esc_html( $block_data['enrolled'] );
                    _e( ' Students', 'edublink' );
                echo '</li>';
            echo '</ul>';
        echo '</div>';
    echo '</div>';
echo '</div>';