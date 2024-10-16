<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="edublink-single-course course-style-' . esc_attr( $args['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $args['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';

            if ( $args['class_type'] ) :
                echo '<div class="time-top">';
                    echo '<span class="duration"><i class="icon-61"></i>' . esc_html( $args['class_type'] ) . '</span>';
                echo '</div>';
            endif;
        echo '</div>';

        echo '<div class="content">';
            if ( $args['cat_item'] ) :
                echo '<span class="course-level">' . wp_kses_post( $args['cat_item'] ) . '</span>';
            endif;

            echo edublink_get_title();

            if ( true === $args['enable_excerpt'] ) :
                echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $args['excerpt_length'] ), esc_html( $args['excerpt_end'] ) ) );
            endif;

            EduBlink_SS_Course_Review::display_review( $args['rating'], 'text' );

            if ( $args['button_text'] ) :
                echo '<div class="read-more-btn">';
                    echo '<a class="edu-btn btn-small btn-secondary" href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $args['button_text'] ) . '<i class="icon-4"></i></a>';
                echo '</div>';
            endif;
        echo '</div>';
    echo '</div>';
echo '</div>';