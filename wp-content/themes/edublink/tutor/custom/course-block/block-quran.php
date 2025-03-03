<?php
use \EduBlink\Tutor\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

echo '<div class="edublink-single-course course-style-' . esc_attr( $block_data['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $block_data['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';
        echo '</div>';

        echo '<div class="content">';
            echo '<span class="course-level">';
                echo '<img src="' . EDUBLINK_ASSETS_URL . 'images/quran-icon.png" alt="Quran Icon">';
            echo '</span>';

            echo edublink_get_title();

            echo '<div class="course-rating">';
                Helper::rating();
            echo '</div>';

            echo '<div class="content-wrap">';
                echo '<div class="course-price">';
                    echo wp_kses_post( $block_data['price'] );
                echo '</div>';

                if ( true === $block_data['enable_excerpt'] ) :
                    echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $block_data['excerpt_length'] ), esc_html( $block_data['excerpt_end'] ) ) );
                endif;

                echo '<div class="read-more-btn">';
                    echo '<a class="edu-btn btn-medium" href="' . esc_url( get_the_permalink() ) . '">' . __( 'Details', 'edublink' ) . '<i class="icon-4"></i></a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';