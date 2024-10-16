<?php
use \Elementor\Control_Media;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<div class="edublink-team-item">';
    echo '<div class="thumbnail-wrap">';
        echo '<div class="thumbnail">';
            echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
                echo '<img src="' . esc_url( $image_url ) . '" alt="' . Control_Media::get_image_alt( $member['thumb'] ) . '">';
            echo '</a>';
        echo '</div>';

        if ( ! empty( $member['facebook'] ) || ! empty( $member['twitter'] ) || ! empty( $member['linkedin'] ) ) :
            echo '<ul class="team-share-info">';
                echo $member['facebook'] ? '<li><a href="' . esc_url( $member['facebook'] ) . '" target="' . esc_attr( $social_link_tab ) . '"><i class="icon-facebook"></i></a></li>' : '';
                echo $member['twitter'] ? '<li><a href="' . esc_url( $member['twitter'] ) . '" target="' . esc_attr( $social_link_tab ) . '"><i class="ri-twitter-x-fill"></i></a></li>' : '';
                echo $member['linkedin'] ? '<li><a href="' . esc_url( $member['linkedin'] ) . '" target="' . esc_attr( $social_link_tab ) . '"><i class="icon-linkedin2"></i></a></li>' : '';
            echo '</ul>';
        endif;
    echo '</div>';

    echo '<div class="content">';
        if ( $member['name'] ) :
            echo '<h4 class="title">';
                echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
                    echo esc_html( $member['name'] );
                echo '</a>';
            echo '</h4>';
        endif;

        echo $member['designation'] ? '<span class="designation">' . esc_html( $member['designation'] ) . '</span>' : '';
    echo '</div>';
echo '</div>';