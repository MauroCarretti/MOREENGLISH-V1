<?php
namespace EduBlinkCore;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/*
 * EduBlinkCore Helper Class
 */ 
class Helper {

	/**
     * Retrieve all the posts from a specific post_type
     * @return array
     *
     * @since 1.0.0
     */
    public static function retrieve_posts( $post_type, $select_post = false ) {
        $options = [];

        $select_one = __( 'Select a Post', 'edublink-core' );
        $no_post    = __( 'No Post Found. Please, Create one First', 'edublink-core' );
        if ( 'wpcf7_contact_form' === $post_type ) :
            $select_one = __( 'Select a Form', 'edublink-core' );
            $no_post    = __( 'No Form Found. Please, Create one First', 'edublink-core' );
        elseif ( LP_COURSE_CPT === $post_type ) :
            $select_one = __( 'Select a Course', 'edublink-core' );
            $no_post    = __( 'Sorry, No Course Found. Please, Create one First', 'edublink-core' );
        endif;

        if ( true === $select_post ) :
            $options[0]  = $select_one;
        endif;

        $posts = get_posts( array(
            'post_type'      => $post_type,
            'posts_per_page' => -1,
            'order_by'       => 'date',
            'order'          => 'DESC'
        ) );

        if ( ! empty( $posts ) && ! is_wp_error( $posts ) ) :
            foreach ( $posts as $post ) :
                if ( isset( $post ) ) :
                    if ( isset( $post->ID ) && isset( $post->post_title ) ) :
                        $options[ $post->ID ] = $post->post_title;
                    endif;
                endif;
            endforeach;
        else :
            $options[0] = $no_post;
        endif;

        return $options;
    }

    /**
     * Retrieve all the categories from a specific taxonomy
     * @return array
     * 
     * @since 1.0.0
     */
    public static function retrieve_categories( $taxomy_name = 'category', $hide_empty = false ) {

        $options = [];
        if ( ! empty( $taxomy_name ) ) :
            $terms = get_terms(
                array(
                    'taxonomy'   => $taxomy_name,
                    'hide_empty' => $hide_empty
                )
            );
            if ( ! empty( $terms ) ) :
                $options = ['' => ''];

                foreach ( $terms as $term ) :
                    if ( isset( $term ) ) :
                        if ( isset( $term->term_id ) && isset( $term->name ) ) :
                            $options[ $term->term_id ] = $term->name;
                        endif;
                    endif;
                endforeach;
            endif;
        endif;
        return $options;
    }

    /**
     * Retrieve all the lists from MailChimp API
     * @return array
     * 
     * @since 1.0.0
     */
    public static function retrieve_mailchimp_items() {
        $api_key = edublink_set_value( 'mailchimp_api' );
        $data    = array(
            'apikey' => $api_key
        );

        $mailchimp = curl_init();
        curl_setopt( $mailchimp, CURLOPT_URL, 'https://' . substr( $api_key, strpos( $api_key, '-' ) + 1 ) . '.api.mailchimp.com/3.0/lists/' );
        curl_setopt( $mailchimp, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Basic ' . base64_encode( 'user:' . $api_key ) ) );
        curl_setopt( $mailchimp, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $mailchimp, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt( $mailchimp, CURLOPT_TIMEOUT, 10 );
        curl_setopt( $mailchimp, CURLOPT_POST, true );
        curl_setopt( $mailchimp, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $mailchimp, CURLOPT_POSTFIELDS, json_encode( $data ) );

        $lists = curl_exec( $mailchimp );
        $lists = json_decode( $lists );
        if ( ! empty( $lists ) && ! empty( $lists->lists ) ) :
            $lists_name = array( '' => __( 'Select a mailChimp Form', 'edublink-core' ) );
            for ( $i = 0; $i < count( $lists->lists ); $i++ ) :
                $lists_name[$lists->lists[$i]->id] = $lists->lists[$i]->name;
            endfor;
            return $lists_name;
        endif;
    }

    /**
     * filter query params
     * @return array
     * 
     * @since 1.0.0
     */
    public static function query_args( $settings, $post_type = 'post', $category_slug = 'category', $widget_name = '' ) {
        $args = array(
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $settings['per_page']['size'],
            'orderby'        => $settings['order_by'],
            'order'          => $settings['order'],
            'post__in'       => $settings['specific_post_include'],
            'post__not_in'   => $settings['specific_post_exclude'],
            // 'paged' => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
        );

        // if ( 'grid' === $settings['display_type'] ) :
        //     if ( 'none' !== $settings['pagination_type'] ) :
        //         $args['paged'] = ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
        //     endif;
        // endif;

        if ( 'yes' === $settings['enable_only_featured_posts'] ) :
            $args['meta_query'][] = array( 'key' => '_thumbnail_id' );
        endif;

        if ( ! empty( $settings['include_categories'] ) ) :
            $args['tax_query'] = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => $category_slug,
                    'field'    => 'term_id',
                    'terms'    => $settings['include_categories']
                )
            );
        endif;

        return $args;
    }

    /**
     * return HEX color to RGBA format
     *
     * @since 1.0.0
     *
     * @access public
     */
    public static function hex2rgba( $color, $opacity = false ) {
 
        $default = 'rgb(0,0,0)';
     
        // Return default if no color provided
        if ( empty( $color ) ) :
            return $default; 
        endif;

        // Sanitize $color if "#" is provided 
        if ( $color[0] == '#' ) :
            $color = substr( $color, 1 );
        endif;

        // Check if color has 6 or 3 characters and get values
        if ( strlen( $color ) == 6 ) :
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        elseif ( strlen( $color ) == 3 ) :
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        else :
            return $default;
        endif;

        // Convert hexadec to rgb
        $rgb =  array_map( 'hexdec', $hex );

        // Check if opacity is set(rgba or rgb)
        if( $opacity ) :
            if( abs( $opacity ) > 1 )
                $opacity = 1.0;
            $output = 'rgba('.implode( ",",$rgb ).','.$opacity.')';
        else :
            $output = 'rgb('.implode( ",",$rgb ).')';
        endif;

        // Return rgb(a) color string
        return $output;
    }

    /**
     * all image mask shape
     * 
     * @access public
     * 
     * @return array
     * @since 1.0.0
     */
    public static function masking_shapes() {
        $path         = EDUBLINK_ASSETS_URL . 'images/masking-shapes/';
        $shape_prefix = 'shape';
        $format       = '.svg';
        $shapes       = [];
        for ( $i = 1; $i <= 9; $i++ ) :
            $shapes[$path . $shape_prefix . $i . $format] = ucwords( $shape_prefix . ' ' . $i );
        endfor;
        return $shapes;
    }

    /**
     * return HEX color to RGBA format
     *
     * @since 1.0.0
     *
     * @access public
     */
    public static function get_saved_template( $type = 'page' ) {
        $actual_type = __( 'Landing Page', 'edublink-core' );
        if ( 'page' === $type ) :
            $actual_type = __( 'Page', 'edublink-core' );
        elseif ( 'section' === $type ) :
            $actual_type = __( 'Section', 'edublink-core' );
        endif;
		$saved_widgets = self::get_post_template( $type );
		$options[-1]   = __( 'Select', 'edublink-core' );
		if ( count( $saved_widgets ) ) :
			foreach ( $saved_widgets as $saved_row ) :
				$options[ $saved_row['id'] ] = $saved_row['name'];
			endforeach;
		else :
			$options['no_template'] = __( 'No ' . esc_html( $actual_type ). ' template is added.', 'edublink-core' );
		endif;
		return $options;
	}

    /**
     * return all the post item of elementor_library
     *
     * @since 1.0.0
     *
     * @access public
     */
    public static function get_post_template( $type = 'page' ) {
		$posts = get_posts(
			array(
				'post_type'        => 'elementor_library',
                'post_status'      => 'publish',
				'orderby'          => 'title',
				'order'            => 'ASC',
				'posts_per_page'   => '-1',
				'tax_query'        => array(
					array(
						'taxonomy' => 'elementor_library_type',
						'field'    => 'slug',
						'terms'    => $type
					)
				)
			)
		);

		$templates = array();

		foreach ( $posts as $post ) :
			$templates[] = array(
				'id'   => $post->ID,
				'name' => $post->post_title
			);
		endforeach;

		return $templates;
	}
}