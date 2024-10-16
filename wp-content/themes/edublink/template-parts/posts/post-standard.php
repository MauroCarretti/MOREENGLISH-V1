<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

$edublink_post_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
if ( isset( $edublink_post_thumb_src ) && ! empty( $edublink_post_thumb_src ) ) :
    $edublink_post_thumb_url = $edublink_post_thumb_src[0];
else :
    $edublink_post_thumb_url = '';
endif;

$excerpt_length = edublink_set_value( 'blog_post_excerpt_length', 10 );
if ( isset( $_GET['excerpt_length'] ) ) :
	$excerpt_length = (int)$_GET['excerpt_length'] ? $_GET['excerpt_length'] : $excerpt_length;
endif;

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'edublink_post_standard_classes', 'edublink-post-one-single-grid edublink-col-lg-12 edublink-blog-post-standard' ) ); ?> data-sal>
    <?php
    echo '<div class="edu-blog edublink-radius-small">';
        echo '<div class="inner">';
            if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
                echo '<div class="thumbnail">';
                    echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                        echo '<img src="' . esc_url( $edublink_post_thumb_url ). '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '" >';
                    echo '</a>';
                echo '</div>';
            endif;

            echo '<div class="content">';
                if ( edublink_category_by_id( get_the_ID() ) ) :
                    echo '<span class="edublink-post-cat">' . wp_kses_post( edublink_category_by_id( get_the_ID(), 'category' ) ) . '</span>';
                endif;

                echo edublink_get_title( 'h3' );

                echo '<ul class="blog-meta">';
                    echo '<li>';
                        echo '<i class="icon-27"></i>';
                        echo esc_html( get_the_date( 'd M, Y' ) );
                    echo '</li>';
                    
                    echo '<li><i class="icon-28"></i>';
                        printf( // WPCS: XSS OK.
                            /* translators: 1: comment count number, 2: title. */
                            esc_html( _nx( '%2$s %1$s', '%2$s %1$s', get_comments_number(), 'comments title', 'edublink' ) ),
                            number_format_i18n( get_comments_number() ),
                            edublink_set_value( 'blog_post_comment_short_text', __( 'Com', 'edublink' ) ),
                            '<span>' . get_the_title() . '</span>'
                        );
                    echo '</li>';
                echo '</ul>';

                echo '<div class="card-bottom">';
                    echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $excerpt_length ), '...' ) );
                echo '</div>';

                echo '<div class="read-more-button">';
                    echo '<a class="edu-btn btn-border btn-medium" href="' . esc_url( get_the_permalink() ) . '">';
                        echo edublink_set_value( 'blog_post_button_text', __( 'Learn More', 'edublink' ) );
                        echo '<i class="icon-4"></i>';
                    echo '</a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';