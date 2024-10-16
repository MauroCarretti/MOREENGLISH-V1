<?php

require_once get_template_directory() . '/sensei/custom/helper-class.php';
require_once get_template_directory() . '/sensei/custom/review/class-review.php';

/**
 * Course Search Post Type
 */
add_filter( 'edublink_course_search_post_type', 'edublink_ss_course_search_post_type' );
if ( ! function_exists( 'edublink_ss_course_search_post_type' ) ) :
	function edublink_ss_course_search_post_type() {
		return 'course';
	}
endif;

/**
 * Header Course Category Slug
 */
add_filter( 'edublink_header_course_lms_cat_slug', 'edublink_header_course_ss_cat_slug' );
if ( ! function_exists( 'edublink_header_course_ss_cat_slug' ) ) :
	function edublink_header_course_ss_cat_slug() {
		return 'course-category';
	}
endif;

/**
 * post_class extends for sensei courses
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_sensei_course_class' ) ) :
    function edublink_sensei_course_class( $default = array() ) {
		$terms      = get_the_terms( get_the_ID(), 'course-category' );
		$terms_html = array();
		if ( is_array( $terms ) ) :
			foreach ( $terms as $term ) :
				$terms_html[] = $term->slug;
			endforeach;
		endif;
		$all_classes = array_merge( $terms_html, $default );
		$classes = apply_filters( 'edublink_sensei_course_class', $all_classes );
        post_class( $classes );
    }
endif;

/**
 * Sensei specific scripts & stylesheets.
 *
 * @return void
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_sensei_scripts' ) ) :
	function edublink_sensei_scripts() {
		wp_enqueue_style( 'edublink-sensei-style', get_template_directory_uri() . '/assets/css/sensei.css', array(), EDUBLINK_THEME_VERSION );
		if ( is_singular( 'course' ) ) :
			wp_enqueue_style( 'jquery-fancybox' );
			wp_enqueue_script( 'jquery-fancybox' );
		endif;
	}
endif;
add_action( 'wp_enqueue_scripts', 'edublink_sensei_scripts' );


function edublink_sensei_get_courses( $args = array() ) {

    $args = wp_parse_args( $args, array(
        'author' => '',
        'fields' => ''
    ) );

    extract($args);
    
    $query_args = array(
        'post_type' => 'course',
        'post_status' => 'publish'
    );

    if ( ! empty( $author ) ) :
        $query_args['author'] = $author;
	endif;

    if ( ! empty( $fields ) ) :
        $query_args['fields'] = $fields;
	endif;

    $loop = new WP_Query($query_args);
    $posts = array();
	
    if ( ! empty( $loop->posts ) ) :
        $posts = $loop->posts;
	endif;
    return $posts;
}

add_filter( 'sensei_register_post_type_course', 'edublink_sensei_post_type_comment_support' );
if ( ! function_exists( 'edublink_sensei_post_type_comment_support' ) ) :
	function edublink_sensei_post_type_comment_support( $args ) {
		$args['supports'][] = 'comments';
		return $args;
	}  
endif;

/**
 * Sensei Course Rating Active
 *
 */
if( ! function_exists( 'is_edublink_ss_rating_enable' ) ) :
	function is_edublink_ss_rating_enable() {
		$status = edublink_set_value( 'ss_course_rating_system', true ) ? edublink_set_value( 'ss_course_rating_system', true ) : false;
		return $status;
	}
endif;