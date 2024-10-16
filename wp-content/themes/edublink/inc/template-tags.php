<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package EduBlink
 */

if ( ! function_exists( 'edublink_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function edublink_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) :
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		endif;

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'edublink' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'edublink_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function edublink_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'edublink' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'edublink_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function edublink_entry_footer() {
		$page_edit = apply_filters( 'edublink_page_edit_permission_for_logged_users', false );
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'edublink' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		endif;

		if ( $page_edit ) :
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'edublink' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		endif;
	}
endif;

if ( ! function_exists( 'edublink_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function edublink_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ( ! has_post_thumbnail() && ! get_the_post_thumbnail_url() ) ) :
			return;
		endif;

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'full' ); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'edublink-post-thumb', array(
				'alt' => the_title_attribute( array(
					'echo' => false
				) )
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;


/**
 * Thumbnail alt attribute text
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_thumbanil_alt_text' ) ) :
	function edublink_thumbanil_alt_text( $image_id ) {
		$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        $alt_text = $title = apply_filters( 'edublink_thumbanil_alt_default_text', __( 'Post Thumb', 'edublink' ) );
		$post_item = get_post( $image_id );

		if ( NULL !== $post_item ) :
			$title = $post_item->post_title;
		endif;

        if ( $alt ) :
            $alt_text = $alt;
        else :
            $alt_text = $title;
        endif;

		return $alt_text;
	}
endif;

/**
 * Get tags meta
 *
 * @return string
 */
if ( ! function_exists( 'edublink_entry_meta_tags' ) ) :
	function edublink_entry_meta_tags() {
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) :
			return sprintf( '<span class="tags-links">' . esc_html__( 'Tags: %1$s', 'edublink' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		endif;

		return '';
	}
endif;

/**
 * Search Form Theme Style
 *
 */
if ( ! function_exists( 'edublink_search_form_replace' ) ) {
    function edublink_search_form_replace( $search_form ) {

        $search_form = sprintf(
            '<div class="edublink-search-box">
				<form class="search-form" action="%s" method="get">
					<input type="search" value="%s" required name="s" placeholder="%s">
					<button type="submit" class="search-button"><i class="icon-2"></i></button>
				</form>
			</div>',
            esc_url( home_url( '/' ) ),
            esc_attr( get_search_query() ),
            __( 'Search', 'edublink' )
        );

        return $search_form;
    }
    add_filter( 'get_search_form', 'edublink_search_form_replace' );
}

/**
 * Single Post Before Content
 *
 * @since 1.0.0
 */
add_action( 'edublink_single_post_thumbnail_before', 'edublink_single_post_thumbnail_before_content', 10 );
if ( ! function_exists( 'edublink_single_post_thumbnail_before_content' ) ) {
	function edublink_single_post_thumbnail_before_content() {
		$title_tag = apply_filters( 'edublink_post_title_tag', 'h1' );
		echo '<div class="blog-details-top">';
			if ( edublink_category_by_id( get_the_ID() ) ) :
				echo '<span class="edublink-post-cat">' . wp_kses_post( edublink_category_by_id( get_the_ID(), 'category' ) ) . '</span>';
			endif;
			
			the_title( '<' . $title_tag . ' class="post-main-title">', '</' . $title_tag . '>' );

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
		echo '</div>';
	}
}

/**
 * Single Post After Content
 *
 * Post Category and Post Share
 *
 * @since 1.0.0
 */
add_action( 'edublink_single_post_after', 'edublink_single_post_after_cats_social_share', 10 );
function edublink_single_post_after_cats_social_share() {
	if ( 'post' === get_post_type() && edublink_set_value( 'blog_single_tags_and_social_share', true ) ) :
		$tags = edublink_category_by_id( get_the_ID(), 'post_tag', false );
		echo '<div class="edublink-tag-social-share-wrapper">';
			echo '<div class="edublink-tag-social-share edublink-row">';
				if ( empty( $tags ) ) :
					$column = 'edublink-col-md-12 tags-social-full-width';
					$tags_column = $column;
				else :
					$tags_column = 'edublink-col-md-7';
					$column = 'edublink-col-md-5';
				endif;

				if( ! empty( $tags ) ) :
					echo '<div class="' . esc_attr( $tags_column ). '">';
						echo '<div class="edublink-post-tag-wrapper">';
							echo '<span class="post-tags">' . __( 'Tags: ', 'edublink' ) . '</span>';
							echo '<div class="edublink-post-tag">';
								echo wp_kses_post( $tags );
							echo '</div>';
						echo '</div>';
					echo '</div>';
				endif;
				
				echo '<div class="' . esc_attr( $column ). '">';
					echo '<div class="edublink-single-post-social-share">';
						echo '<span class="post-share-text">' . __( 'Share on: ', 'edublink' ) . '</span>';
						get_template_part( 'template-parts/social', 'share' );
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	endif;
}

/**
 * Single Post After Content
 *
 * Author Bio
 *
 * @since 1.0.0
 */
add_action( 'edublink_single_post_after', 'edublink_single_post_after_author_bio', 15 );
function edublink_single_post_after_author_bio() {
	if ( 'post' === get_post_type() && edublink_set_value( 'blog_single_author_bio', true ) ) :
		edublink_author_bio();
	endif;
}

/**
 * Single Post After Content
 *
 * Related Posts
 *
 * @since 1.0.0
 */
// add_action( 'edublink_single_post_after', 'edublink_single_post_after_related_posts', 20 );
function edublink_single_post_after_related_posts() {
	if ( 'post' === get_post_type() && edublink_set_value( 'blog_single_related_post', true ) ) :
		get_template_part( 'template-parts/related', 'posts' );
	endif;
}

/**
 * Single Post After Content
 *
 * Displays Previous & Next Post Naviation
 *
 * @since 1.0.0
 */
add_action( 'edublink_single_post_after', 'edublink_post_nav_prev_next', 20 );
if ( ! function_exists( 'edublink_post_nav_prev_next' ) ) :
	function edublink_post_nav_prev_next() {
		if ( is_singular( 'post' ) ) :
			$prev_post = get_previous_post();
			$next_post = get_next_post();
			if ( ! empty( $prev_post->post_title ) || ! empty( $next_post->post_title ) ) :
				echo '<div class="edublink-post-nav-prev-next edublink-row">';
					if ( ! empty( $prev_post->post_title ) ) :
						echo '<div class="edublink-col-md-6">';
							echo '<div class="edublink-single-post-nav edublink-prev-post">';
								echo '<a href="' . esc_url( get_permalink( $prev_post->ID ) ) . '">';
									echo '<i class="icon-west"></i>';
									echo '<span class="post-title">' . esc_html( $prev_post->post_title ) . '</span>';
								echo '</a>';
							echo '</div>';
						echo '</div>';
					endif;

					if ( ! empty( $next_post->post_title ) ) :
						echo '<div class="edublink-col-md-6">';
							echo '<div class="edublink-single-post-nav edublink-next-post">';
								echo '<a href="' . esc_url( get_permalink( $next_post->ID ) ) . '">';
									echo '<span class="post-title">' . esc_html( $next_post->post_title ) . '</span>';
									echo '<i class="icon-east"></i>';
								echo '</a>';
							echo '</div>';
						echo '</div>';
					endif;
				echo '</div>';
			endif;
		endif;
	}
endif;
