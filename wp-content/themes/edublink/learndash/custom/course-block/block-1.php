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
            echo $args['level'] ? '<span class="course-level">' . esc_html( $args['level'] ) . '</span>' : '';

            echo edublink_get_title();

            if ( is_edublink_ld_rating_enable() ) :
                EduBlink_LD_Course_Review::display_review( $args['rating'], 'text' );
            endif;
            
            echo '<div class="course-price">';
                echo wp_kses_post( EduBlink_LD_Helper::course_price() );
            echo '</div>';

            echo '<ul class="course-meta">';
                echo '<li>';
                    echo '<i class="icon-24"></i>';
                    echo esc_html( $args['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';

                echo '<li>';
                    echo '<i class="icon-25"></i>';
                    echo esc_html( $args['enrolled'] );
                    _e( ' Students', 'edublink' );
                echo '</li>';
            echo '</ul>';
        echo '</div>';
    echo '</div>';

    echo '<div class="course-hover-content-wrapper">';
        if ( is_edublink_ld_wishlist_enable() ) :
            echo '<div class="wishlist-top-right">';
                echo '<div class="edublink-wishlist-item">';
                    EduBlink_Wishlist::content( $post );
                echo '</div>';
            echo '</div>';
        endif;
    echo '</div>';

    echo '<div class="course-hover-content">';
        echo '<div class="content">';

            echo $args['level'] ? '<span class="course-level">' . esc_html( $args['level'] ) . '</span>' : '';

            echo edublink_get_title();

            if ( is_edublink_ld_rating_enable() ) :
                EduBlink_LD_Course_Review::display_review( $args['rating'], 'text' );
            endif;

            echo '<div class="course-price">';
                echo wp_kses_post( EduBlink_LD_Helper::course_price() );
            echo '</div>';

            if ( true === $args['enable_excerpt'] ) :
                echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $args['excerpt_length'] ), esc_html( $args['excerpt_end'] ) ) );
            endif;

            echo '<ul class="course-meta">';
                echo '<li class="course-meta-lesson">';
                    echo '<i class="icon-24"></i>';
                    echo esc_html( $args['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';

                echo '<li class="course-meta-student">';
                    echo '<i class="icon-25 "></i>';
                    echo esc_html( $args['enrolled'] );
                    _e( ' Students', 'edublink' );
                echo '</li>';
            echo '</ul>';

            if ( $args['button_text'] ) :
                echo '<a class="edu-btn btn-secondary btn-small" href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $args['button_text'] ) . '<i class="icon-4"></i></a>';
            endif;
        echo '</div>';
    echo '</div>';
echo '</div>';