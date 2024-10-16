<?php
use \Elementor\Control_Media;

echo '<div class="eb-testimonial-grid">';
    echo '<div class="content">';
        echo '<div class="quote-icon">';
            echo '<img src="' . EDUBLINK_ASSETS_URL . 'images/slider/quote.svg" alt="quote icon">';
        echo '</div>';

        echo $testimonial['testimonial'] ? '<p class="description">' . wp_kses_post( $testimonial['testimonial'] ) . '</p>' : '';
        echo $testimonial['name'] ? '<h5 class="title">' . esc_html( $testimonial['name'] ) . '</h5>' : '';
        echo $testimonial['designation'] ? '<span class="subtitle">' . esc_html( $testimonial['designation'] ) . '</span>' : '';
    echo '</div>';
echo '</div>';