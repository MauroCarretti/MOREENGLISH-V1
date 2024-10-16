<?php

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class EduBlink_LD_Course_Review {
	protected static $instance = null;
	const POST_TYPE = 'sfwd-courses';

	public function __construct() {
		add_filter( 'comments_template', [ $this, 'comments_template_locator' ] );
		add_action( 'comment_post', [ $this,'save_rating_comment' ], 0, 3 );
		add_action( 'comment_unapproved_to_approved', [ $this,'save_ratings_average' ], 10 );
		add_action( 'comment_approved_to_unapproved', [ $this,'save_ratings_average' ], 10 );
	}

	public static function instance() {
        if ( null === self::$instance ) :
            self::$instance = new self();
        endif;
        return self::$instance;
    }

	public function comments_template_locator( $template ) {
	    if ( self::POST_TYPE === get_post_type() ) :
			if ( is_edublink_ld_rating_enable() ) :
				return get_template_directory() . '/learndash/custom/review/review-box.php';
			endif;
		endif;
	    return $template;
	}
	
	public static function ld_course_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
	    set_query_var( 'comment', $comment );
	    set_query_var( 'args', $args );
	    set_query_var( 'depth', $depth );
	    get_template_part( 
			'learndash/custom/review/review-list', 
			'', 
			array(
				'comment' => $comment, 
				'args'    => $args, 
				'depth'   => $depth
			) 
		);
	}

	public function save_rating_comment( $comment_id, $comment_approved, $data ) {
	    $post_type = get_post_type( $data['comment_post_ID'] );
	    if ( self::POST_TYPE === $post_type && isset( $_POST['rating'] ) ) :
	        add_comment_meta( $comment_id, '_ld_rating', $_POST['rating'] );
	        if ( ! empty( $data['comment_approved'] ) ) :
	        	self::update_average_ratings( $data['comment_post_ID'] );
			endif;
		endif;
	}

	public static function get_average_ratings( $post_id ) {
	    return get_post_meta( $post_id, '_ld_average_rating', true );
	}

	public function save_ratings_average( $comment ) {
		$post_id = $comment->comment_post_ID;
	    self::update_average_ratings( $post_id );
	}

	public static function update_average_ratings( $post_id ) {
	    $post_type = get_post_type( $post_id );
	    if ( self::POST_TYPE === $post_type ) :
	        $average_rating = self::get_total_rating( $post_id );
	        update_post_meta( $post_id, '_ld_average_rating', $average_rating );

	        $author_id = get_post_field ( 'post_author', $post_id );
	        $args = array(
	        	'fields' => 'ids',
	        	'author' => $author_id
	        );
	        $courses = edublink_learndash_get_courses( $args );
	        $author_average_rating = 0;

	        if ( ! empty( $courses ) ) :
	        	foreach ( $courses as $course_id ) :
	        		$average_rating = get_post_meta( $post_id, '_ld_average_rating', true );
	        		if ( ! empty( $average_rating ) && $average_rating > 0 ) :
	        			$author_average_rating += $average_rating;
					endif;
				endforeach;
			endif;
	        update_user_meta( $author_id, '_ld_average_rating', $author_average_rating );
	    endif;
	}

	public static function fetch_rating_comments( $args = array() ) {
	    $args = wp_parse_args( $args, array(
	        'status'    => 'approve',
	        'post_id'   => '',
	        'user_id'   => '',
	        'post_type' => self::POST_TYPE,
	        'number'    => 0
	    ) );
	    extract( $args );

	    $cargs = array(
	        'status'     => 'approve',
	        'post_type'  => $post_type,
	        'number'     => $number,
	        'meta_query' => array(
	            array(
	               'key'     => '_ld_rating',
	               'value'   => 0,
	               'compare' => '>'
	            )
	        )
	    );

	    if ( ! empty( $post_id ) ) :
	        $cargs['post_id'] = $post_id;
		endif;

	    if ( ! empty( $user_id ) ) :
	        $cargs['user_id'] = $user_id;
		endif;

	    $all_comments = get_comments( $cargs );
	    return $all_comments;
	}

	public static function get_all_reviews( $post_id ) {
	    $args = array( 'post_id' => $post_id );
	    $all_comments = self::fetch_rating_comments( $args );

	    if ( empty( $all_comments ) ) :
	        return 0;
		endif;
	    
	    return count( $all_comments );
	}

	public static function get_total_rating( $post_id ) {
	    $args = array( 'post_id' => $post_id );
	    $total_review = 0;
	    $all_comments = self::fetch_rating_comments( $args );

	    if ( empty( $all_comments ) ) :
	        return 0;
		endif;

	    foreach ( $all_comments as $comment ) :
	        $rating = intval( get_comment_meta( $comment->comment_ID, '_ld_rating', true ) );
	        if ( $rating ) :
	            $total_review += (int)$rating;
			endif;
	    endforeach;

	    return round( $total_review/count( $all_comments ), 2 );
	}

	public static function display_review( $rate, $style = 'default' ) {
		global $post;
		$rate = $rate ? $rate : 0;
		$rating = EduBlink_LD_Course_Review::get_all_reviews( get_the_ID() );
		$average_rating = EduBlink_LD_Course_Review::get_average_ratings( get_the_ID() );
		$single_rating_text = edublink_set_value( 'text_for_rating', __( 'Rating', 'edublink' ) ) ? edublink_set_value( 'text_for_rating', __( 'Rating', 'edublink' ) ) : __( 'Rating', 'edublink' );
		$plural_rating_text = edublink_set_value( 'text_for_ratings', __( 'Ratings', 'edublink' ) ) ? edublink_set_value( 'text_for_ratings', __( 'Ratings', 'edublink' ) ) : __( 'Ratings', 'edublink' );
		echo '<div class="eb-course-rating-content">';
			echo '<div class="eb-course-review-wrapper">';
				echo '<ul class="eb-course-review">';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
				echo '</ul>';
				
				echo '<ul class="eb-course-review eb-review-filled" style="width: ' . esc_attr( $rate * 20 . '%' ) . '">';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
				echo '</ul>';
			echo '</div>';

			if ( 'text' === $style ) :
	            echo '<span class="eb-rating-text">(';
					echo esc_html( number_format( floatval( $average_rating ), 1 ) ) . '/ ';
					echo esc_html( $rating ) . ' ';
					if ( (int)$rating > 1 ) :
						echo esc_html( $plural_rating_text );
					else :
						echo esc_html( $single_rating_text );
					endif;
				echo ')</span>';
			endif;
		echo '</div>';
	}
	
	public static function get_detail_ratings( $post_id ) {
	    global $wpdb;
	    $comment_ratings = $wpdb->get_results( $wpdb->prepare(
	        "
	            SELECT cm2.meta_value AS rating, COUNT(*) AS quantity FROM $wpdb->posts AS p
	            INNER JOIN $wpdb->comments AS c ON (p.ID = c.comment_post_ID AND c.comment_approved=1)
	            INNER JOIN $wpdb->commentmeta AS cm2 ON cm2.comment_id = c.comment_ID AND cm2.meta_key=%s
	            WHERE p.ID=%d
	            GROUP BY cm2.meta_value",
	            '_ld_rating',
	            $post_id
	        ), OBJECT_K
	    );
	    return $comment_ratings;
	}
}

EduBlink_LD_Course_Review::instance();