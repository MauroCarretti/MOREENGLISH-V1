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

        echo '<div class="content main-content">';
            echo '<div class="course-price">';
                EduBlink_MS_Helper::course_price();
            echo '</div>';

            echo edublink_get_title();

            edublink_ms_course_rating( 'text' );

            if ( true === $block_data['enable_excerpt'] ) :
                echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $block_data['excerpt_length'] ), esc_html( $block_data['excerpt_end'] ) ) );
            endif;

            echo '<ul class="course-meta">';
                echo '<li>';
                    echo '<i class="icon-24"></i>';
                    echo esc_html( $block_data['lessons'] );
                    _e( ' Lessons', 'edublink' );
                echo '</li>';
                
                echo '<li>';
                    echo '<i class="icon-25"></i>';
                    echo esc_html( $block_data['enrolled'] );
                    _e( ' Students', 'edublink' );
                echo '</li>';
            echo '</ul>';
        echo '</div>';
    echo '</div>';

    echo '<div class="edublink-course-14-hover visible-bottom">';
        echo '<div class="inner">';
            echo '<div class="content">';
                if ( $block_data['cat_item'] ) :
                    echo '<span class="course-level">' . wp_kses_post( $block_data['cat_item'] ) . '</span>';
                endif;

                echo edublink_get_title();

                edublink_ms_course_rating( 'count' );

                echo '<ul class="course-meta">';
                    echo '<li>';
                        echo esc_html( $block_data['lessons'] );
                        _e( ' Lessons', 'edublink' );
                    echo '</li>';

                    echo '<li class="course-meta-info">';
                        echo esc_html( $block_data['duration'] );
                    echo '</li>';
                    echo $block_data['level'] ? '<li class="course-meta-info">' . esc_html( $block_data['level'] ) . '</li>' : '';
                echo '</ul>';

                if ( is_array( $block_data['features'] ) ) :
                    echo '<div class="course-feature">';
                        echo '<h6 class="feature-title">' . apply_filters( 'edublink_course_14_features_title', __( 'What You’ll Learn?', 'edublink' ) ) . '</h6>';
                        echo '<ul>';
                            $i = 1;
                            foreach( $block_data['features'] as $key => $feature ) :
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

                    echo '<div class="wishlist-top-right">';
                        echo '<div class="edublink-wishlist-item">';
                            STM_LMS_Templates::show_lms_template( 'global/wish-list', array( 'course_id' => get_the_ID() ) );
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';