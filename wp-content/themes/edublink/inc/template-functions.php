<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package EduBlink
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function edublink_body_classes( $classes ) {
	$preloader     = edublink_set_value( 'preloader', true );
	$sticky_header = edublink_set_value( 'sticky_header', false );
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) :
		$classes[] = 'group-blog';
	endif;

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) :
		$classes[] = 'hfeed';
	endif;

	if ( $preloader ) :
		$classes[] = 'edublink-site-preloader-loading';
	endif;

	if ( $preloader ) :
		$classes[] = 'edublink-site-preloader-loading';
	endif;

	if ( $sticky_header ) :
		$classes[] = 'edublink-sticky-header-enable';
	endif;

	return $classes;
}
add_filter( 'body_class', 'edublink_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function edublink_pingback_header() {
	if ( is_singular() && pings_open() ) :
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	endif;
}
add_action( 'wp_head', 'edublink_pingback_header' );
