<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="edublink-feature-item">';
    echo '<div class="content">';
        if ( ! empty( $settings['link']['url'] ) ) :
            echo '<a ' . $this->get_render_attribute_string( 'link' ) . '>';
        endif;
        echo '<span class="icon">';
            echo wp_kses_post( $settings['title'] );
        echo '</span>';
                
        if ( ! empty( $settings['link']['url'] ) ) :
            echo '</a>';
        endif;

        if ( $settings['details'] ) : 
            echo '<p class="description">' . wp_kses_post( $settings['details'] ) . '</p>';
        endif;
    echo '</div>';
echo '</div>';