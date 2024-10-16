<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="edublink-single-course course-style-' . esc_attr( $block_data['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $block_data['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            echo '<div class="course-price price-round">';
                EduBlink_MS_Helper::course_price();
            echo '</div>';
        echo '</div>';

        echo '<div class="content">';
            if ( $block_data['cat_item'] ) :
                echo '<span class="course-level">' . wp_kses_post( $block_data['cat_item'] ) . '</span>';
            endif;

            echo edublink_get_title();

            echo '<ul class="course-meta">';
                echo '<li class="course-meta-lesson">';
                    echo '<i class="icon-24"></i>';
                    echo esc_html( $block_data['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';

                if ( $block_data['enrolled'] ) :
                    echo '<li class="course-meta-student">';
                        echo '<i class="icon-25"></i>';
                        echo esc_html( $block_data['enrolled'] );
                        _e( ' Students', 'edublink' );
                    echo '</li>';
                endif;
            echo '</ul>';
        echo '</div>';
    echo '</div>';
echo '</div>';