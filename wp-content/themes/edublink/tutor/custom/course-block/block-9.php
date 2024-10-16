<?php
use \EduBlink\Tutor\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

echo '<div class="edublink-single-course course-style-' . esc_attr( $block_data['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $block_data['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            echo '<div class="course-price">';
                echo wp_kses_post( $block_data['price'] );
            echo '</div>';
        echo '</div>';

        echo '<div class="content">';
            echo '<ul class="course-meta">';
                echo '<li>';
                    echo '<i class="icon-24 icon-course"></i>';
                    echo esc_html( $block_data['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';
                
                echo '<li>';
                    echo '<i class="icon-25 icon-course"></i>';
                    echo esc_html( $block_data['enrolled'] );
                    _e( ' Students', 'edublink' );
                echo '</li>';
            echo '</ul>';

            echo edublink_get_title();

            echo '<div class="course-rating">';
                Helper::rating();
            echo '</div>';

            echo '<div class="read-more-btn">';
                echo '<a class="edu-btn btn-medium" href="' . esc_url( get_the_permalink() ) . '">' . __( 'Read More', 'edublink' ) . '<i class="icon-4"></i></a>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';