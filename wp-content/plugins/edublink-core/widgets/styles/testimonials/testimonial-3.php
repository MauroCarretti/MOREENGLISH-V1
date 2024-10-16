<?php
use \Elementor\Control_Media;

echo '<div class="eb-testimonial-slide">';
    echo '<div class="content">';
        echo '<div class="logo">';
            echo '<img src="' . esc_url( $testimonial['logo']['url'] ) . '" alt="' . Control_Media::get_image_alt( $testimonial['logo'] ) . '">';
        echo '</div>';

        echo $testimonial['testimonial'] ? '<p class="description">' . wp_kses_post( $testimonial['testimonial'] ) . '</p>' : '';
        
        echo '<div class="rating-icon">';
            $this->rating( $testimonial['rating'] );
        echo '</div>';
    echo '</div>';

    echo '<div class="author-info">';
        if ( ! empty( $image_url ) ) :
            echo '<div class="thumbnail">';
                echo '<img src="' . esc_url( $image_url ) . '" class="testimonial-author-avatar" alt="' . Control_Media::get_image_alt( $testimonial['thumb'] ) . '">';
            echo '</div>';
        endif;
        
        if ( ! empty( $testimonial['name'] ) || ! empty( $testimonial['designation'] ) ) :
            echo '<div class="info">';
                echo $testimonial['name'] ? '<h5 class="title">' . esc_html( $testimonial['name'] ) . '</h5>' : '';
                echo $testimonial['designation'] ? '<span class="subtitle">' . esc_html( $testimonial['designation'] ) . '</span>' : '';
            echo '</div>';
        endif;
    echo '</div>';
echo '</div>';