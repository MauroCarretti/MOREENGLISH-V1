<?php
use \Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="edublink-category-' . esc_attr( $settings['style'] ) . '">';
    echo '<div class="icon">';
        if ( $category['icon'] ) :
            Icons_Manager::render_icon( $category['icon'], [ 'aria-hidden' => 'true' ] );
        endif;
    echo '</div>';
    
    echo '<div class="content">';
        if ( $title ) : 
            echo '<h5 class="title">';
                echo '<a href="' . esc_url( $link ) . '">' . esc_html( $title ) .'</a>';
            echo '</h5>';
        endif;

        if ( $settings['enable_category_count'] ) :
            echo '<span class="course-count">';
                printf( _nx( '%s ' . esc_html( $settings['course_label'] ), '%s ' . esc_html( $settings['courses_label'] ), $count, 'Courses', 'edublink-core' ), number_format_i18n( $count ) );
            echo '</span>';
        endif;
    echo '</div>';
echo '</div>';