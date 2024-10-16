<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="edublink-feature-item">';
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