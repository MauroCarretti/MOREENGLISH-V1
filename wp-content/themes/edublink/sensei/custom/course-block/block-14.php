<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
echo '<div class="edublink-single-course course-style-' . esc_attr( $args['style'] ) . ' inline" data-tipped-options="inline: \'inline-tooltip-' . esc_attr( $args['uniqid'] ). '\'">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            echo '<a class="course-thumb" href="' . esc_url( get_the_permalink() ) . '">';
                echo '<img class="w-100" src="' . esc_url( $args['thumb_url'] ) . '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '">';
            echo '</a>';
        echo '</div>';

        echo '<div class="content">';
            echo '<div class="course-price">';
                echo wp_kses_post( EduBlink_SS_Helper::course_price() );
            echo '</div>';
            
            if ( $args['cat_item'] ) :
                echo '<span class="course-level">' . wp_kses_post( $args['cat_item'] ) . '</span>';
            endif;

            echo edublink_get_title();

            if ( true === $args['enable_excerpt'] ) :
                echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $args['excerpt_length'] ), esc_html( $args['excerpt_end'] ) ) );
            endif;

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
        echo '</div>';
    echo '</div>';
echo '</div>';

echo '<div id="inline-tooltip-' . esc_attr( $args['uniqid'] ) . '" class="edublink-course-' . esc_attr( $args['style'] ) . '-hover">';
    echo '<div class="inner">';
        echo '<div class="content">';
            if ( $args['cat_item'] ) :
                echo '<span class="course-level">' . wp_kses_post( $args['cat_item'] ) . '</span>';
            endif;

            echo edublink_get_title();

            EduBlink_SS_Course_Review::display_review( $args['rating'], 'text' );

            echo '<ul class="course-meta">';
                echo '<li>';
                    echo esc_html( $args['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';

                echo '<li class="course-meta-info">';
                    echo esc_html( $args['duration'] );
                echo '</li>';
                echo $args['level'] ? '<li class="course-meta-info">' . esc_html( $args['level'] ) . '</li>' : '';
            echo '</ul>';

            if ( is_array( $args['features'] ) ) :
                echo '<div class="course-feature">';
                    echo '<h6 class="feature-title">' . apply_filters( 'edublink_course_14_features_title', __( 'What You’ll Learn?', 'edublink' ) ) . '</h6>';
                    echo '<ul>';
                        $i = 1;
                        foreach( $args['features'] as $key => $feature ) :
                            echo '<li class="course-list-item">' . esc_html( $feature['name'] ) . '</span></li>';
                            if ( $i === 3 ) :
                                break;
                            endif;
                            $i++;
                        endforeach;
                    echo '</ul>';
                echo '</div>';
            endif;

            echo '<div class="button-group">';
                if ( $block_data['button_text'] ) :
                    echo '<a class="edu-btn btn-medium" href="' . esc_url( get_the_permalink() ) . '">' . esc_html( $block_data['button_text'] ) . '</a>';
                endif;
                echo '<div class="edublink-wishlist-item">';
                    EduBlink_Wishlist::content( $post );
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';