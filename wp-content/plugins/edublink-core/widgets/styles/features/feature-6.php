<?php
use \Elementor\Control_Media;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="edublink-feature-item">';
    if ( $image_url ) :
        if ( ! empty( $settings['link']['url'] ) ) :
            echo '<a ' . $this->get_render_attribute_string( 'link' ) . '>';
        endif;
        echo '<div class="thumbnail">';
            echo '<img src="' . esc_url( $image_url ) . '" alt="' . Control_Media::get_image_alt( $settings['image'] ) . '">';
        echo '</div>';
        if ( ! empty( $settings['link']['url'] ) ) :
            echo '</a>';
        endif;
    endif;

    $this->print_icon( $settings );

    echo '<div class="content">';
        if ( ! empty( $settings['link']['url'] ) ) :
            echo '<a ' . $this->get_render_attribute_string( 'link' ) . '>';
        endif;
        echo '<h4 class="title">';
            echo wp_kses_post( $settings['title'] );
        echo '</h4>';
                
        if ( ! empty( $settings['link']['url'] ) ) :
            echo '</a>';
        endif;

        if ( $settings['details'] ) : 
            echo '<p class="description">' . wp_kses_post( $settings['details'] ) . '</p>';
        endif;
    echo '</div>';
echo '</div>';