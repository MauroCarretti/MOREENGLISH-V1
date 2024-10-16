<?php
use \Elementor\Control_Media;

echo '<div class="eb-testimonial-slide">';
    echo '<div class="content">';
        echo $settings['pre_heading'] ? '<span class="pre-title">' . esc_html( $settings['pre_heading'] ) . '</span>' : '';
        if ( $settings['heading'] ) :
            echo '<h3 class="section-title">' . wp_kses_post( $settings['heading'] ) . '</h3>';
            echo '<span class="shape-line"><i class="icon-19"></i></span>';
        endif;

        echo $testimonial['testimonial'] ? '<p class="description">' . wp_kses_post( $testimonial['testimonial'] ) . '</p>' : '';

        echo '<div class="author-info">';
            if ( ! empty( $image_url ) ) :
                echo '<div class="thumbnail">';
                    echo '<img src="' . esc_url( $image_url ) . '" class="testimonial-author-avatar" alt="' . Control_Media::get_image_alt( $testimonial['thumb'] ) . '">';
                echo '</div>';
            endif;
            echo '<div class="info">';
                echo $testimonial['name'] ? '<h5 class="title">' . esc_html( $testimonial['name'] ) . '</h5>' : '';
                echo $testimonial['designation'] ? '<span class="subtitle">' . esc_html( $testimonial['designation'] ) . '</span>' : '';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';