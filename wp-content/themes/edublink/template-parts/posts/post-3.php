<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

$edublink_post_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'edublink-post-thumb' );
if ( isset( $edublink_post_thumb_src ) && ! empty( $edublink_post_thumb_src ) ) :
    $edublink_post_thumb_url = $edublink_post_thumb_src[0];
else :
    $edublink_post_thumb_url = '';
endif;
$blog_post_desktop_cols  = 12/edublink_set_value( 'blog_post_columns', 2 );

if ( isset( $_GET['column'] ) && $_GET['column'] == 3 ) :
	$blog_post_desktop_cols = 4;
endif;

$excerpt_length = edublink_set_value( 'blog_post_excerpt_length', 10 );
if ( isset( $_GET['excerpt_length'] ) ) :
	$excerpt_length = (int)$_GET['excerpt_length'] ? $_GET['excerpt_length'] : $excerpt_length;
endif;

$masonry_status = edublink_set_value( 'blog_post_masonry_layout', true );
if ( $masonry_status || isset( $_GET['masonry'] ) ) :
	$blog_post_desktop_cols = $blog_post_desktop_cols . ' ' . 'eb-masonry-item';
endif;
?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'edublink-post-one-single-grid edublink-col-lg-' . esc_attr( $blog_post_desktop_cols ) . ' edublink-col-md-6 edublink-col-sm-12' ); ?> data-sal>
    <?php
    echo '<div class="edu-blog blog-style-6">';
        echo '<div class="inner">';
            if ( $edublink_post_thumb_url ) :
                echo '<div class="thumbnail">';
                    echo '<a href="' . esc_url( get_the_permalink() ) . '">';
                        echo '<img src="' . esc_url( $edublink_post_thumb_url ). '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '" >';
                    echo '</a>';

                    echo '<span class="date">' . esc_html( get_the_date( 'd M, Y' ) ) . '</span>';
                echo '</div>';
            endif;

            echo '<div class="content position-top">';
                echo '<div class="read-more-btn">';
                    echo '<a class="btn-icon-round" href="' . esc_url( get_the_permalink() ) . '"><i class="icon-4"></i></a>';
                echo '</div>';
                
                echo '<div class="category-wrap">';
                    echo edublink_category_by_id( get_the_ID() );
                echo '</div>';

                echo edublink_get_title( 'h5' );

                echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $excerpt_length ), '...' ) );
            echo '</div>';
        echo '</div>';
    echo '</div>';
echo '</div>';