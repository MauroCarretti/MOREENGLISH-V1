<?php
use \Elementor\Control_Media;

echo '<div class="eb-testimonial-grid">';
    if ( ! empty( $image_url ) ) :
        echo '<div class="thumbnail">';
            echo '<img src="' . esc_url( $image_url ) . '" class="testimonial-author-avatar" alt="' . Control_Media::get_image_alt( $testimonial['thumb'] ) . '">';
        echo '</div>';
    endif;

    echo '<div class="content">';
        echo $testimonial['testimonial'] ? '<p class="description">' . wp_kses_post( $testimonial['testimonial'] ) . '</p>' : '';
        echo '<div class="rating-icon">';
            $this->rating( $testimonial['rating'] );
        echo '</div>';

        echo $testimonial['name'] ? '<h5 class="title">' . esc_html( $testimonial['name'] ) . '</h5>' : '';
        echo $testimonial['designation'] ? '<span class="subtitle">' . esc_html( $testimonial['designation'] ) . '</span>' : '';
    echo '</div>';
echo '</div>';