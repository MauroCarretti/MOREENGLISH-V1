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
    echo '</div>';
echo '</div>';