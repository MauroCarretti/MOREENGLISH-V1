<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

$edublink_post_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'edublink-post-thumb' );
$content_class = 'content position-top';
if ( isset( $edublink_post_thumb_src ) && ! empty( $edublink_post_thumb_src ) ) :
    $edublink_post_thumb_url = $edublink_post_thumb_src[0];
else :
    $edublink_post_thumb_url = '';
	$content_class = $content_class . ' ' . 'without-thumb';
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
	echo '<div class="edu-blog blog-style-2">';
		echo '<div class="inner">';
			if ( $edublink_post_thumb_url ) :
				echo '<div class="thumbnail">';
					echo '<a href="' . esc_url( get_the_permalink() ) . '">';
						echo '<img src="' . esc_url( $edublink_post_thumb_url ). '" alt="' . esc_attr( edublink_thumbanil_alt_text( get_post_thumbnail_id( get_the_id() ) ) ). '" >';
					echo '</a>';
				echo '</div>';
			endif;

			echo '<div class="' . esc_attr( $content_class ) . '">';
				echo '<div class="read-more-btn">';
					echo '<a class="btn-icon-round" href="' . esc_url( get_the_permalink() ) . '"><i class="icon-4"></i></a>';
				echo '</div>';
				
				echo '<div class="category-wrap">';
					echo edublink_category_by_id( get_the_ID() );
				echo '</div>';

				echo edublink_get_title( 'h5' );

				echo '<ul class="blog-meta">';
					echo '<li><i class="icon-27"></i>' . esc_html( get_the_date( 'd M, Y' ) ) . '</li>';
					if ( comments_open() ) :
						echo '<li><i class="icon-28"></i>';
							printf( // WPCS: XSS OK.
								/* translators: 1: comment count number, 2: title. */
								esc_html( _nx( '%2$s %1$s', '%2$s %1$s', get_comments_number(), 'comments title', 'edublink' ) ),
								number_format_i18n( get_comments_number() ),
								edublink_set_value( 'blog_post_comment_short_text', __( 'Com', 'edublink' ) ),
								'<span>' . get_the_title() . '</span>'
							);
						echo '</li>';
					endif;
				echo '</ul>';

				echo wpautop( wp_trim_words( wp_kses_post( get_the_excerpt() ), esc_html( $excerpt_length ), '...' ) );
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';