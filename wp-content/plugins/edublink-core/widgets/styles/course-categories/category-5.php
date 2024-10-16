<?php
use \Elementor\Control_Media;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="edublink-category-' . esc_attr( $settings['style'] ) . '">';
    echo '<div class="inner">';
        echo '<div class="thumbnail">';
            if ( $image_url ) :
                echo '<a href="' . esc_url( $link ) . '">';
                    echo '<img src="' . esc_url( $image_url ) . '" alt="' . Control_Media::get_image_alt( $category['image'] ) . '">';
                echo '</a>';
            endif;

            echo $category['price_range'] ? '<div class="course-price">' . wp_kses_post( $category['price_range'] ) . '</div>' : '';
            
            if ( $flag_image_src ) :
                echo '<div class="flag-wrap">';
                    echo '<a class="flag-content" href="' . esc_url( $link ) . '">';
                        echo '<img src="' . esc_url( $flag_image_src ) . '" alt="' . Control_Media::get_image_alt( $category['flag_image'] ) . '">';
                    echo '</a>';
                echo '</div>';
            endif;
        echo '</div>';

        echo '<div class="content">';
            if ( $title ) : 
                echo '<h6 class="title">';
                    echo '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) .'</a>';
                echo '</h6>';
            endif;

            if ( $settings['enable_category_count'] ) :
                echo '<p class="course-count">';
                    printf( _nx( '%s ' . esc_html( $settings['course_label'] ), '%s ' . esc_html( $settings['courses_label'] ), $count, 'Courses', 'edublink-core' ), number_format_i18n( $count ) );
                echo '</p>';
            endif;
        echo '</div>';
    echo '</div>';
echo '</div>';