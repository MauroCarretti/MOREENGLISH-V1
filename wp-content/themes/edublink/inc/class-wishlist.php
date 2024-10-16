<?php
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class EduBlink_Wishlist {
    protected static $instance = null;

    public function __construct() {
		add_action( 'wp_ajax_edublink_wishlist_item', [ $this, 'wishlist_ajax_connect' ] );
		add_action( 'wp_ajax_nopriv_edublink_wishlist_item', [ $this, 'wishlist_ajax_connect' ] );
		add_action( 'wp_ajax_edublink_wishlist_item_remove', [ $this, 'wishlist_ajax_remove' ] );
		add_action( 'wp_ajax_nopriv_edublink_wishlist_item_remove', [ $this, 'wishlist_ajax_remove' ] );
	}

    public static function instance() {
        if ( null === self::$instance ) :
            self::$instance = new self();
        endif;
        return self::$instance;
    }

	public function wishlist_ajax_connect() {
		check_ajax_referer( 'edublink-wishlist-ajax-connect', 'security' );
		$status = array();
		if ( isset( $_POST['post_id'] ) && $_POST['post_id'] ) :
			self::cache_in_wishlist( $_POST['post_id'] );
			$status['progress'] = 'done';
			$status['text'] = __( 'Item Added to Wishlist', 'edublink' );
		else :
			$status['progress'] = 'undone';
        endif;

		echo json_encode( $status );
		die();
	}

	public function wishlist_ajax_remove() {
		check_ajax_referer( 'edublink-wishlist-ajax-connect', 'security' );
		$status = array();
		if ( isset( $_POST['post_id'] ) && $_POST['post_id'] ) :
			$id = $_POST['post_id'];
		    $newly_added = array();
	        if ( isset( $_COOKIE['eb_course_wishlist'] ) ) :
	            $items = explode( ',', $_COOKIE['eb_course_wishlist'] );
	            foreach ( $items as $key => $item ) :
	                if ( $id != $item ) :
	                    unset( $items[$key] );
	                    $newly_added[] = $item;
                    endif;
	            endforeach;
	        endif;

	        setcookie( 'eb_course_wishlist', implode( ',', $newly_added) , time()+60*60*24*15, '/' );
	        $_COOKIE['eb_course_wishlist'] = implode( ',', $newly_added );
			$status['progress'] = 'done';
			$status['text'] = __( 'Add Item to wishlist', 'edublink' );
		else :
			$status['progress'] = 'error';
        endif;
		echo json_encode( $status );
		die();
	}

	public static function cache_in_wishlist( $id ) {
		$items = array();
        if ( isset( $_COOKIE['eb_course_wishlist'] ) ) :
            $items = explode( ',', $_COOKIE['eb_course_wishlist'] );
            if ( ! self::verify_wishlisted_items( $id, $items ) ) :
                $items[] = $id;
            endif;
        else :
            $items = array( $id );
        endif;

		setcookie( 'eb_course_wishlist', implode( ',', $items), time()+60*60*24*15, '/' );
        $_COOKIE['eb_course_wishlist'] = implode(',', $items);
	}

	public static function verify_wishlisted_items( $id ) {
		if ( empty( $id ) ) :
			return false;
        endif;

		if ( isset( $_COOKIE['eb_course_wishlist'] ) && ! empty( $_COOKIE['eb_course_wishlist'] ) ) :
            $added_items = explode( ',', $_COOKIE['eb_course_wishlist'] );
            if ( in_array( $id, $added_items ) ) :
	            return true;
	        endif;
        endif;
    	return false;
	}

	public static function content( $post, $type = 'icon' ) {
		$id = $post->ID;
		$class = '';
		$icon_class = 'icon-22';
		$text = __( 'Add Item to wishlist', 'edublink' );
		
		$added = self::verify_wishlisted_items($id);
		if ( $added ) :
			$text = __( 'Item Added to Wishlist', 'edublink' );
			$icon_class = 'icon-22';
			$class = 'eb-wishlisted';
		else :
			$class = 'eb-wishlist-non-added';
        endif;
		
        if( 'text' === $type ) :
			echo '<a href="#eb-wishlist-item-link" class="eb-wishlist-button with-icon-text ' . esc_attr( $class ) . '" data-id="' . esc_attr( $id ) . '">';
                echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
                echo '<span class="wishlist-text">' . esc_html( $text ) . '</span>';
            echo '</a>';
		else :
			echo '<a href="#eb-wishlist-item-link" class="eb-wishlist-button with-icon ' . esc_attr( $class ) . '" data-id="' . esc_attr( $id ) . '">';
                echo '<i class="edublink-wishlist-wrapper ' . esc_attr( $icon_class ) . '"></i>';
            echo '</a>';
        endif;
	}

	public static function fetch_wishlist() {
		if ( isset( $_COOKIE['eb_course_wishlist'] ) && ! empty( $_COOKIE['eb_course_wishlist'] ) ) :
            return explode( ',', $_COOKIE['eb_course_wishlist'] );
        endif;
        return array();
	}
}

EduBlink_Wishlist::instance();