<?php

/**
 * return the value of meta options
 * 
 * @since 1.0.0
 */
function edublink_set_value( $name, $default = '' ) {
	global $edublink_options;
    if ( isset( $edublink_options[$name] ) ) :
        return $edublink_options[$name];
    endif;
    return $default;
}

/**
 * check if LearnPress is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_learnpress_activated() {
	return class_exists( 'LearnPress' ) ? true : false; 
}

/**
 * check if LearnDash is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_learndash_activated() {
	return class_exists( 'SFWD_LMS' ) ? true : false;
}

/**
 * check if Tutor LMS is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_tutor_lms_activated() {
	return function_exists( 'tutor' ) ? true : false;
}

/**
 * check if Lifter LMS is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_lifter_lms_activated() {
	return class_exists( 'LifterLMS' ) ? true : false;
}

/**
 * check if Sensei LMS is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_sensei_lms_activated() {
	return class_exists( 'Sensei_Main' ) ? true : false;
}

/**
 * check if MasterStudy LMS is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_masterstudy_lms_activated() {
	return class_exists( 'MasterStudy\Lms\Plugin' ) ? true : false;
}

/**
 * check if WooCommerce is active/deactive
 *
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_woocommerce_activated() {
	return class_exists( 'WooCommerce' ) ? true : false;
}

/**
 * check if WP Events Manager is active/deactive
 * https://wordpress.org/plugins/wp-events-manager/
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_wp_events_manager_activated() {
	return class_exists( 'WPEMS' ) ? true : false;
}

/**
 * check if WP Events Manager is active/deactive
 * https://wordpress.org/plugins/the-events-calendar/
 * return boolean
 * 
 * @since 1.0.0
 */
function edublink_is_the_events_calendar_activated() {
	return class_exists( 'Tribe__Events__Main' ) ? true : false;
}

/**
 * return all the header items from edublink_header post type 
 * and theme default headers
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_fetch_header_layouts' ) ) :
	function edublink_fetch_header_layouts() {
		$headers = apply_filters( 'edublink_theme_header_types', array(
			'theme-default-header' => 'Theme Default Header',
			'theme-header-1' => 'Theme Header 1',
			'theme-header-2' => 'Theme Header 2',
			'theme-header-3' => 'Theme Header 3',
			'theme-header-4' => 'Theme Header 4',
			'theme-header-4-alt-1' => 'Theme Header 4 Alter 1',
			'theme-header-4-alt-2' => 'Theme Header 4 Alter 2',
			'theme-header-4-alt-3' => 'Theme Header 4 Alter 3',
			'theme-header-5' => 'Theme Header 5',
			'theme-header-5-alt' => 'Theme Header 5 Alter',
			'theme-header-6' => 'Theme Header 6',
			'theme-header-6-alt' => 'Theme Header 6 Alter',
			'theme-header-6-alt-secondary-color' => 'Theme Header 6 Alter(Color Secondary)'
		) );

		$args    = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'edublink_header',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) :
			$headers[$post->post_name] = $post->post_title;
		endforeach;
		return $headers;
	}
endif;

/**
 * return elementor header
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_get_header_config' ) ) :
	function edublink_get_header_config() {
		
		global $post;
		if ( is_page() && is_object( $post ) && isset( $post->ID ) ) :
			$header = get_post_meta( $post->ID, 'edublink_page_header_type', true );
			if ( empty( $header ) || $header == 'global' ) :
				return edublink_set_value( 'header_type' );
			endif;
			return $header;
		endif;
		return edublink_set_value( 'header_type' );
	}
	add_filter( 'edublink_get_header_layout', 'edublink_get_header_config' );
endif;

/**
 * print Elementor Header
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_show_header_builder' ) ) :
		function edublink_show_header_builder( $header_slug ) {
			$args = array(
				'name'        => $header_slug,
				'post_type'   => 'edublink_header',
				'post_status' => 'publish',
				'numberposts' => 1
			);
			$posts         = get_posts( $args );
			$sticky_header = edublink_set_value( 'sticky_header', false );
			foreach ( $posts as $post ) :
				$classes        = array( 'edublink-elementor-header-wrapper' );
				$classes[]      = $post->post_name . '-' . $post->ID;
				$bg_color       = '';

				echo '<header class="' . esc_attr( implode( ' ', $classes ) ) . '">';
					echo '<div class="edublink-header-container"' . trim( $bg_color ) . '>';
						if ( $sticky_header ) :
							echo '<div class="edublink-sticky-header-wrapper">';
						else :
							echo '<div class="edublink-non-sticky-header-wrapper">';
						endif;
							echo apply_filters( 'edublink_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID );
						echo '</div>';
					echo '</div>';
				echo '</header>';

			endforeach;
		}
endif;

/**
 * return all the footer items from edublink_footer post type 
 * and theme default footers
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_get_footer_layouts' ) ) :
	function edublink_get_footer_layouts() {
		$footers = apply_filters( 'edublink_theme_footer_types', array(
			'theme-default-footer' => 'Theme Default Footer'
		) );

		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'edublink_footer',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) :
			$footers[$post->post_name] = $post->post_title;
		endforeach;
		return $footers;
	}
endif;

/**
 * return elementor footer
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_get_footer_config' ) ) :
	function edublink_get_footer_config() {
		if ( is_page() ) {
			global $post;
			$footer = '';
			if ( is_object( $post ) && isset( $post->ID ) ) :
				$footer = get_post_meta( $post->ID, 'edublink_page_footer_type', true );
				if ( empty( $footer ) || $footer == 'global' ) :
					return edublink_set_value( 'footer_type', '' );
				endif;
			endif;
			return $footer;
		}
		return edublink_set_value( 'footer_type', '' );
	}
	add_filter( 'edublink_get_footer_layout', 'edublink_get_footer_config' );
endif;

/**
 * print Elementor Footer
 * 
 * @since 1.0.0
 */
function edublink_show_footer_builder( $footer_slug ) {
	$args = array(
		'name'        => $footer_slug,
		'post_type'   => 'edublink_footer',
		'post_status' => 'publish',
		'numberposts' => 1
	);

	$posts = get_posts($args);
	foreach ( $posts as $post ) :
		$classes = array( 'edublink-footer footer-builder-wrapper' );
		$classes[] = $post->post_name;

		echo '<footer id="edublink-footer" class="' . esc_attr( implode( ' ', $classes ) ) . '">';
			echo '<div class="edublink-footer-inner">';
				echo apply_filters( 'edublink_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID);
			echo '</div>';
		echo '</footer>';
	endforeach;
}


/**
 * return category/single category with link
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_category_by_id' ) ) :
	function edublink_category_by_id( $post_id = null, $taxonomy = 'category', $single = true ) {
		$terms = get_the_terms( $post_id, $taxonomy );
		$cat = '';
		$cat_with_link = '';

		if ( is_array( $terms ) ) :
			foreach ( $terms as $tkey => $term ) :
				$cat .= $term->slug . ' ';
				$cat_with_link .= sprintf( '<a href="%s">%s</a>', esc_url( get_category_link( $term->term_id ) ), esc_html( $term->name ) );
				if ( $single ) :
					break;
				endif;
			endforeach;
		endif;
		return $cat_with_link;
	}
endif;

/**
 * get instructor lists from specific role type
 */
if ( ! function_exists( 'edublink_get_all_instructors' ) ) :
    function edublink_get_all_instructors( $user_role = 'lp_teacher' ) {
		$instructors = array();
		$user_role   = $user_role;
		$users       = get_users( 
            array( 
                'role__in' => array( 
                    $user_role
                ) 
            ) 
        );
        
        if ( is_array( $users ) && ! empty( $users ) && ! is_wp_error( $users ) ) :
            $instructors = ['' => ''];
            foreach ( $users as $user ) :
                if ( isset( $user ) ) :
                    $instructors[ $user->ID ] = $user->display_name.' [ID: '.$user->ID.']';
                endif;
            endforeach;
        else :
            $instructors[0] = __( 'No Instructor found',  'edublink' );
        endif;

        return $instructors;
    }
endif;

/**
 * Get Social icons for instructors
 */
if ( ! function_exists( 'edublink_user_social_icons' ) ) :
	function edublink_user_social_icons( $user_id, $link_tab = '_blank' ) {
		$facebook = $twitter = $linkedin = $youtube = '';

		if ( ! $user_id ) :
			$user_id = get_current_user_id();
		endif;

		$facebook  = get_the_author_meta( 'edublink_facebook', $user_id );
		$twitter   = get_the_author_meta( 'edublink_twitter', $user_id );
		$linkedin  = get_the_author_meta( 'edublink_linkedin', $user_id );
		$youtube   = get_the_author_meta( 'edublink_youtube', $user_id );

		$facebook ? printf( '<a href="%s" target="' . esc_attr( $link_tab ) . '"><i class="icon-facebook"></i></a>', esc_url( $facebook ) ) : '';
		$twitter ? printf( '<a href="%s" target="' . esc_attr( $link_tab ) . '"><i class="ri-twitter-x-fill"></i></a>', esc_url( $twitter ) ) : ''; 
		$linkedin ? printf( '<a href="%s" target="' . esc_attr( $link_tab ) . '"><i class="icon-linkedin2"></i></a>', esc_url( $linkedin ) ) : '';
		$youtube ? printf( '<a href="%s" target="' . esc_attr( $link_tab ) . '"><i class="icon-youtube"></i></a>', esc_url( $youtube ) ) : '';
	}
endif;

/**
 * Get title
 */
if ( ! function_exists( 'edublink_get_title' ) ) :
	function edublink_get_title( $tag = 'h6', $extra_class = null ) {
		$title = get_the_title();
		$class = 'title';

		if ( 0 === mb_strlen( $title ) ) :
			$title = '&nbsp;';
			$class = 'title empty-title';
		endif;

		if ( $extra_class ) :
			$class .= ' ' . $extra_class;
		endif;

		if ( ! empty( $title ) ) :
			return '<' . esc_attr( $tag ) . ' class="' . esc_attr( $class ). '"><a href="' . esc_url( get_permalink() ) . '">' . wp_kses_post( $title ) . '</a></' . esc_attr( $tag ) . '>';
		endif;

		return '';
	}
endif;

/**
 * Logo Setup
 */
if ( ! function_exists( 'edublink_logo_setup' ) ) :
    function edublink_logo_setup(){
		global $post;
		echo '<div class="logo-wrapper" itemscope itemtype="http://schema.org/Brand">';

			if ( is_page() && is_object( $post ) && function_exists( 'edublink_child_theme_is_activated' ) && edublink_child_theme_is_activated() ) :
				$page_custom_logo = get_post_meta( get_the_ID(), 'edublink_page_header_logo', true );
				if ( isset( $page_custom_logo ) && ! empty( $page_custom_logo ) ) :
					echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="navbar-brand site-main-logo page-custom-logo">';
						echo '<img class="site-logo" src="' . esc_url( $page_custom_logo ) . '">';
					echo '</a>';

					edublink_white_logo();
					echo '</div>';
					return;
				endif;
			endif;

			if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) :
				the_custom_logo();
			else :
				echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="navbar-brand site-main-logo">';
					echo '<img class="site-logo" src="' . esc_url( get_template_directory_uri().'/assets/images/logo.png' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
				echo '</a>';
			endif;

			edublink_white_logo();

		echo '</div>';
    }
endif;

/**
 * White Logo
 */
if ( ! function_exists( 'edublink_white_logo' ) ) :
    function edublink_white_logo() {
		global $post;
		$white_logo = edublink_set_value( 'header_white_logo' );

		if ( isset( $white_logo['url'] ) && ! empty( $white_logo['url'] ) ) :
			$white_logo = $white_logo['url'];
		else :
			$white_logo = '';
		endif;

		if ( is_page() && is_object( $post ) && function_exists( 'edublink_child_theme_is_activated' ) ) :
			$page_white_logo = get_post_meta( get_the_ID(), 'edublink_page_header_white_logo', true );
			if ( isset( $page_white_logo ) && ! empty( $page_white_logo ) ) :
				$white_logo = $page_white_logo;
			endif;
		endif;

		if ( isset( $white_logo ) && ! empty( $white_logo ) ) :
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="navbar-brand site-white-logo">';
				echo '<img src="' . esc_url( $white_logo ) . '" class="header-white-logo" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" />';
			echo '</a>';
		endif;
    }
endif;

/**
 * Menu Setup
 */
if ( ! function_exists( 'edublink_menu_setup' ) ) :
    function edublink_menu_setup(){
        if ( has_nav_menu( 'primary' ) ) :
			echo '<nav id="site-navigation" class="main-navigation edublink-theme-nav edublink-navbar-collapse">';
				echo '<div class="edublink-navbar-primary-menu">';
					do_action( 'edublink_before_main_menu' );
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'depth'          => 4,
						'container'      => 'div',
						'container_class'=> 'primary-menu-container-class',
						'container_id'   => 'primary-menu-container-id',
						'menu_class'     => 'edublink-default-header-navbar edublink-navbar-nav edublink-navbar-right',
						'menu_id'        => 'primary-menu-custom-id',
						'fallback_cb'    => 'EduBlink_NavWalker::fallback',
						'walker'         => new EduBlink\Navwalker\EduBlink_NavWalker()							
					) );
					do_action( 'edublink_after_main_menu' );
				echo '</div>';
			echo '</nav>';//#site-navigation
		endif;
    }
endif;

/**
 * Responsive Menu Setup
 */
if ( ! function_exists( 'edublink_responsive_menu_setup' ) ) :
    function edublink_responsive_menu_setup(){
        if ( has_nav_menu( 'primary' ) ) :
			echo '<div class="edublink-mobile-menu">';
				echo '<div class="edublink-mobile-menu-overlay"></div>';

				echo '<div class="edublink-mobile-menu-nav-wrapper">';
					echo '<div class="responsive-header-top">';
						echo '<div class="responsive-header-logo">';
							edublink_logo_setup();
						echo '</div>';
						
						echo '<div class="edublink-mobile-menu-close">';
							echo '<a href="javascript:void(0);">';
								echo '<i class="icon-73"></i>';
							echo '</a>';
						echo '</div>';
					echo '</div>';

					do_action( 'edublink_mobile_menu_before_nav' );

					wp_nav_menu( array(
						'theme_location' => 'primary',
						'depth'          => 4,
						'container'      => 'ul',
						'menu_id'        => 'edublink-mobile-menu-item',
						'menu_class'     => 'edublink-mobile-menu-item',
						'fallback_cb'    => 'EduBlink_NavWalker::fallback',
						'walker'         => new EduBlink\Navwalker\EduBlink_NavWalker()						
					) );	

					do_action( 'edublink_mobile_menu_after_nav' );	
				echo '</div>';
			echo '</div>';
		endif;
    }
endif;

/**
 * change default logo class
 */
add_filter( 'get_custom_logo', 'edublink_logo_class' );
if ( ! function_exists( 'edublink_logo_class' ) ) :
	function edublink_logo_class( $html ) {
	    $html = str_replace( 'custom-logo-link', 'navbar-brand site-main-logo', $html );
	    $html = str_replace( 'custom-logo', 'site-logo', $html );
	    return $html;
	}
endif;

/**
 * Header Search Field
 */
if ( ! function_exists( 'edublink_header_search_field' ) ) :
	function edublink_header_search_field( $extra_class = null ) {
		if ( $extra_class ) :
			$extra_class = ' ' . $extra_class;
		endif;
		$search_redirect = apply_filters( 'edublink_header_search_redirect', home_url( '/' ) );
		echo '<div class="edu-header-search-field' . esc_attr( $extra_class ) . '">';
            echo '<div class="inner">';
				echo '<form action="' . esc_url( $search_redirect ) .'" class="search-form" method="get">';
					echo '<input type="text" class="edublink-search-popup-field" name="s" value="' . esc_attr( get_search_query() ) . '" placeholder="' . esc_attr__( 'Search', 'edublink') . '">';
                    echo '<button class="submit-button"><i class="icon-2"></i></button>';
				echo '</form>';
            echo '</div>';
        echo '</div>';
	}
endif;

/**
 * Header Search Modal PopUp
 */
if ( ! function_exists( 'edublink_search_modal_popup' ) ) :
	function edublink_search_modal_popup() {
		$search_redirect = apply_filters( 'edublink_header_search_redirect', home_url( '/' ) );
		echo '<div class="edu-search-popup">';
			echo '<div class="content-wrap">';
				edublink_logo_setup();

				echo '<div class="close-button">';
					echo '<button class="close-trigger"><i class="icon-73"></i></button>';
				echo '</div>';

				echo '<div class="inner">';
					echo '<form action="' . esc_url( $search_redirect ) .'" class="search-form" method="get">';
						echo '<input type="text" class="edublink-search-popup-field" name="s" value="' . esc_attr( get_search_query() ) . '" placeholder="' . esc_attr__( 'Search Here...', 'edublink') . '">';
						echo '<button class="submit-button"><i class="icon-2"></i></button>';
					echo '</form>';
				echo '</div>';
			echo '</div>';
        echo '</div>';
	}
endif;

/**
 * Header User Login/Register
 */
if ( ! function_exists( 'edublink_header_user_login_option' ) ) :
	function edublink_header_user_login_option( $icon_with_text = false ) {
		echo '<div class="quote-icon quote-user">';
			if ( $icon_with_text ) :
				echo '<a class="header-login-register button-text-with-icon" href="' . esc_url( wp_login_url( get_permalink() ) ) . '" target="_blank"><i class="ri-user-line"></i><span class="button-text">' . __( 'Login / Register', 'edublink' ). '</span></a>';
			else :
				echo '<a class="header-login-register" href="' . esc_url( wp_login_url( get_permalink() ) ) . '" target="_blank"><i class="ri-user-line"></i></a>';
			endif;
		echo '</div>';
	}
endif;

/**
 * Header User Login/Register( alter )
 */
if ( ! function_exists( 'edublink_header_user_login_option_alter' ) ) :
	function edublink_header_user_login_option_alter( $icon_with_text = false ) {
		echo '<div class="quote-icon quote-user">';
			if ( is_user_logged_in() ) :
				$user_id = get_current_user_id();
				$user    = get_userdata( $user_id );
				if ( function_exists( 'learn_press_get_page_link' ) ) :
					$profile_url = learn_press_get_page_link( 'profile' );
					echo '<a href="' . esc_url( $profile_url ) . '">';
						echo get_avatar( $user_id, 100 );
					echo '</a>';
				else :
					echo get_avatar( $user_id, 100 );
				endif;
			else :
				if ( $icon_with_text ) :
					echo '<a class="header-login-register button-text-with-icon" href="' . esc_url( wp_login_url( get_permalink() ) ) . '" target="_blank"><i class="ri-user-line"></i><span class="button-text">' . __( 'Login / Register', 'edublink' ) . '</span></a>';
				else :
					echo '<a class="header-login-register" href="' . esc_url( wp_login_url( get_permalink() ) ) . '" target="_blank"><i class="ri-user-line"></i></a>';
				endif;
			endif;
		echo '</div>';
	}
endif;

/**
 * Header Category
 */
if ( ! function_exists( 'edublink_header_category' ) ) :
	function edublink_header_category( $extra_class = null ) {
		$cat_status = edublink_set_value( 'header_category_status', true );
		if ( ! $cat_status ) :
			return;
		endif;

		$class = "header-category";
		if ( $extra_class ) :
			$class .= ' ' . $extra_class;
		endif;
		$title = edublink_set_value( 'heading_category_text' ) ? edublink_set_value( 'heading_category_text' ) : __( 'Category', 'edublink' );
		echo '<div class="' . esc_attr( $class ) . '">';
			echo '<nav class="main-navigation">';
				echo '<ul class="category-menu edublink-navbar-nav">';
					echo '<li class="cat-menu-item dropdown">';
						echo '<a class="cat-menu-anchor-item">';
							echo '<i class="icon-1"></i>';
							echo esc_html( $title );
						echo '</a>';
						echo '<ul class="edublink-dropdown-menu">';
							edublink_header_category_items();
						echo '</ul>';
					echo '</a>';
				echo '</ul>';
			echo '</nav>';
		echo '</div>';
	}
endif;

/**
 * Header Category Items
 */
if ( ! function_exists( 'edublink_header_category_items' ) ) :
	function edublink_header_category_items() {
		$total_cat_to_show = edublink_set_value( 'heading_category_items', 10 );
		$total_cat_to_show = intval( $total_cat_to_show );
		$cat_slug = apply_filters( 'edublink_header_course_lms_cat_slug', 'course_category' );
		$args = [
			'taxonomy'   => $cat_slug,
			'orderby'    => 'name',
			'show_count' => 0,
			'title_li'   => '',
			'hide_empty' => 1,
			'number'     => $total_cat_to_show
		];

		$args = apply_filters( 'edublink_header_course_category_args', $args );
		$categories = get_categories( $args );

		if ( is_array( $categories ) && ! empty( $categories ) ) :
			foreach ( $categories as $category ) :
				echo '<li class="cat-item">';
					echo '<a href="' . esc_url( get_term_link( $category ) ) . '">';
						echo esc_html( $category->name );
					echo '</a>';
				echo '</li>';
			endforeach;
		else :
			echo '<li class="cat-item"><a class="no-cat-found">' . esc_html( 'No Category Found', 'edublink' ) . '</a></li>';
		endif;
	}
endif;

/**
 * Header Category Only Parent Items
 * by activating the following filter
 * only parent category will be visible
 */
// add_filter( 'edublink_header_course_category_args', 'edublink_header_category_only_parent' );
if ( ! function_exists( 'edublink_header_category_only_parent' ) ) :
	function edublink_header_category_only_parent( $args ) {
		$extra_args = wp_parse_args( [
			'parent' => 0
		], $args );
		return $extra_args;
	}
endif;

/**
 * Header Button
 */
if ( ! function_exists( 'edublink_header_button' ) ) :
	function edublink_header_button( $extra_class = null ) {
		$button_text = edublink_set_value( 'header_button_text' );
		$button_url = edublink_set_value( 'header_button_url', '#' );
		$button_text_logged_in = edublink_set_value( 'header_button_text_after_logged_in' ) ? edublink_set_value( 'header_button_text_after_logged_in' ) : $button_text;
		$button_url_logged_in = edublink_set_value( 'header_button_url_after_logged_in' ) ? edublink_set_value( 'header_button_url_after_logged_in' ) : $button_url;
		$same_tab = edublink_set_value( 'header_button_open_same_tab', true );
		if ( $same_tab ) :
			$tab = '_self';
		else :
			$tab = '_blank';
		endif;
		
		if ( $extra_class ) :
			$extra_class = ' ' . $extra_class;
		endif;


		if( ! is_user_logged_in() ) :
			if ( $button_text ) :
				echo '<a href="' . esc_url( $button_url ). '" target="' . esc_attr( $tab ) . '" class="edu-btn btn-medium' . esc_attr( $extra_class ) . '">' . wp_kses_post( $button_text ) . '</a>';
			else :
				echo '<a href="' . esc_url( $button_url ). '" target="' . esc_attr( $tab ) . '" class="main-header-btn edu-btn btn-medium' . esc_attr( $extra_class ) . '">' . __( 'Try for free', 'edublink' ) . ' <i class="icon-4"></i></a>';
			endif;
		else :
			if ( $button_text_logged_in ) :
				echo '<a href="' . esc_url( $button_url_logged_in ). '" target="' . esc_attr( $tab ) . '" class="edu-btn btn-medium' . esc_attr( $extra_class ) . '">' . wp_kses_post( $button_text_logged_in ) . '</a>';
			else :
				echo '<a href="' . esc_url( $button_url_logged_in ). '" target="' . esc_attr( $tab ) . '" class="main-header-btn edu-btn btn-medium' . esc_attr( $extra_class ) . '">' . __( 'Try for free', 'edublink' ) . ' <i class="icon-4"></i></a>';
			endif;
		endif;
	}
endif;

/**
 * Header Responsive Menu Toggle
 */
if ( ! function_exists( 'edublink_header_responsive_toggle' ) ) :
	function edublink_header_responsive_toggle() {
		echo '<div class="quote-icon edublink-theme-nav-responsive hamburger-icon">';
			echo '<div class="edublink-mobile-hamburger-menu">';
				echo '<a href="javascript:void(0);">';
					echo '<i class="icon-54"></i>';
				echo '</a>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Header Cart Icon
 */
if ( ! function_exists( 'edublink_header_cart_icon' ) ) :
	function edublink_header_cart_icon() {
		if ( edublink_is_woocommerce_activated() ) :
			echo '<div class="edublink-woo-mini-cart-wrapper woocommerce">';
				echo '<div class="edublink-woo-mini-cart-inner">';
					echo '<div class="edublink-woo-mini-cart-icon-wrapper edublink-woo-mini-cart-active-on-hover">';
						echo '<a class="edublink-woo-mini-cart-link edublink-woo-mini-cart-visible-on-hover" href="' . esc_url( wc_get_cart_url() ) .'" target="_self">';
							echo '<i aria-hidden="true" class="icon-3"></i>';
						echo '</a>';

						echo '<span class="edublink-woo-mini-cart-total-item">';
							echo WC()->cart->get_cart_contents_count();
						echo '</span>';
						
						echo '<div class="edublink-woo-mini-cart-content">';
							echo '<div class="widget_shopping_cart_content">';
								woocommerce_mini_cart();
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		else :
			return;
		endif;
	}
endif;

/**
 * Header Cart Icon
 */
if ( ! function_exists( 'edublink_header_search_toggle' ) ) :
	function edublink_header_search_toggle() {
		echo '<div class="header-quote">';
			echo '<div class="quote-icon quote-search">';
				echo '<button class="search-trigger"><i class="icon-2"></i></button>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Theme main header
 */
add_action( 'edublink_main_header', 'edublink_header_setup' );
if ( ! function_exists( 'edublink_header_setup' ) ) :
	function edublink_header_setup() {
		$default_headers = array( 
			'theme-default-header',
			'theme-header-1',
			'theme-header-2',
			'theme-header-3',
			'theme-header-4',
			'theme-header-4-alt-1',
			'theme-header-4-alt-2',
			'theme-header-4-alt-3',
			'theme-header-5',
			'theme-header-5-alt',
			'theme-header-6',
			'theme-header-6-alt',
			'theme-header-6-alt-secondary-color'
		);
		$header = apply_filters( 'edublink_get_header_layout', edublink_set_value( 'header_type', 'theme-default-header' ) );
		$sticky_header = edublink_set_value( 'sticky_header', false );
		$classes[] = 'site-header';
		$classes[] = $header;

		if ( $sticky_header ) :
			$classes[] = 'header-get-sticky';
		endif;

		$classes = apply_filters( 'edublink_header_class_array', $classes );

		if ( 'none' !== $header ) :
			if ( in_array( $header, $default_headers ) || empty( $header ) ) :
				echo '<header id="masthead" class="' . esc_attr( implode( ' ', $classes ) ) . '">';
					edublink_header_top_bar();
					edublink_header();
				echo '</header>'; //#masthead
				
				// responsive menu
				edublink_responsive_menu_setup();
			else :
				edublink_show_header_builder( $header );
			endif;
		endif;

	}
endif;

/**
 * Theme header
 */
if ( ! function_exists( 'edublink_header' ) ) :
	function edublink_header(){
		$header = apply_filters( 'edublink_get_header_layout', edublink_set_value( 'header_type', 'theme-default-header' ) );
		$container_class = 'edublink-container-fluid';
		if ( 'theme-default-header' === $header || 'theme-header-3' === $header || 'theme-header-6-alt' === $header || 'theme-header-6-alt-secondary-color' === $header ) :
			$container_class = 'edublink-container';
		endif;

		echo '<div class="edublink-header-area edublink-navbar edublink-navbar-expand-lg">';
			echo '<div class="' . esc_attr( apply_filters( 'edublink_header_container_class', $container_class ) ) . '">';
				echo '<div class="eb-header-navbar edublink-align-items-center">';

					echo '<div class="site-branding site-logo-info">';
						edublink_logo_setup();
					echo '</div>';

					if ( 'theme-header-1' === $header ) :
						edublink_header_category();	
					endif;

					echo '<div class="edublink-theme-header-nav edublink-d-none edublink-d-xl-block">';
						edublink_menu_setup();
					echo '</div>';

					edublink_header_right_side_content();
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Theme header Right Side Content
 */
if ( ! function_exists( 'edublink_header_right_side_content' ) ) :
	function edublink_header_right_side_content(){
		$header = apply_filters( 'edublink_get_header_layout', edublink_set_value( 'header_type', 'theme-default-header' ) );
		
		$search_field = $header_btn = '';
		if ( 'theme-header-5-alt' === $header ) :
			$search_field = 'bg-white border-0';
		endif;

		if ( 'theme-header-4' === $header || 'theme-header-4-alt-1' === $header || 'theme-header-4-alt-2' === $header ) :
			$header_btn = 'btn-curved';
		elseif ( 'theme-header-4-alt-3' === $header ) :
			$header_btn = 'btn-radius color-heading bg-white';
		endif;

		echo '<div class="edublink-header-right-side">';

			do_action( 'edublink_header_right_before_content' );

			if ( edublink_set_value( 'header_search_status', true ) ) :
				if ( 'theme-header-1' === $header || 'theme-header-1' === $header || 'theme-header-4' === $header || 'theme-header-4-alt-2' === $header || 'theme-header-5' === $header || 'theme-header-5-alt' === $header ) :
					edublink_header_search_field( $search_field );
				endif;

				if ( 'theme-default-header' !== $header && 'theme-header-2' !== $header ) :
					edublink_header_search_toggle();
				endif;
			endif;

			if ( 'theme-default-header' !== $header && 'theme-header-3' !== $header && 'theme-header-2' !== $header && edublink_set_value( 'header_cart_status', true ) ) :
				edublink_header_cart_icon();
			endif;

			if( 'theme-default-header' !== $header && 'theme-header-6' !== $header && 'theme-header-6-alt' !== $header && 'theme-header-6-alt-secondary-color' !== $header && edublink_set_value( 'header_button_status', true ) ) :
				edublink_header_button( $header_btn );
			endif;

			do_action( 'edublink_header_right_after_content' );

			edublink_header_responsive_toggle();

		echo '</div>';
	}
endif;

/**
 * Theme header top bar
 */
if ( ! function_exists( 'edublink_header_top_bar' ) ) :
	function edublink_header_top_bar() {
		global $post;
		$top_bar = edublink_set_value( 'header_top_bar_status', false );
		$top_bar_type = edublink_set_value( 'header_top_bar_type', 'theme-default-header' );

		if ( is_page() && is_object( $post ) ) :
			$page_top_bar = get_post_meta( get_the_ID(), 'edublink_page_header_top_bar_status', true );
			$page_top_bar_type = get_post_meta( get_the_ID(), 'edublink_page_header_top_bar_type', true );
			if ( 'enable' === $page_top_bar ) :
				$top_bar = true;
			elseif ( 'disable' === $page_top_bar ) :
				$top_bar = false;
			endif;

			if ( '1' === $page_top_bar_type || '2' === $page_top_bar_type ) :
				$top_bar_type = $page_top_bar_type;
			endif;
		endif;

		$container_class = 'edublink-container-fluid';
		if ( '2' === $top_bar_type ) :
			$container_class = 'edublink-container';
		endif;

		if ( $top_bar ) :
			echo '<div class="eb-header-top-bar eb-top-bar-style-' . esc_attr( $top_bar_type ) . '">';
				echo '<div class="' . esc_attr( apply_filters( 'edublink_header_top_bar_container_class', $container_class ) ) . '">';
					echo '<div class="edublink-header-top-content">';
						if ( '1' === $top_bar_type ) :
							edublink_header_top_1();
						else :
							edublink_header_top_2();
						endif;
					echo '</div>';
				echo '</div>';
			echo '</div>';
		endif;
	}
endif;

/**
 * Theme header top social share
 */
if ( ! function_exists( 'edublink_header_top_social_share' ) ) :
	function edublink_header_top_social_share() {
		$facebook = edublink_set_value( 'header_top_facebook_address', '#' );
		$twitter = edublink_set_value( 'header_top_twitter_address', '#' );
		$linkedin = edublink_set_value( 'header_top_linkedin_address', '#' );
		$instagram = edublink_set_value( 'header_top_instagram_address', '#' );
		$youtube = edublink_set_value( 'header_top_youtube_address' );
		$tiktok = edublink_set_value( 'header_top_tiktok_address' );
		$button_tab = edublink_set_value( 'header_top_social_share_open_tab', true ) ? '_blank' : '_self';

		if ( $facebook || $twitter || $linkedin || $instagram || $youtube ) :
			echo '<div class="header-top-social-share">';
				do_action( 'edublink_header_top_social_icon_before' );
				if ( $facebook ) :
					echo '<span class="header-top-facebook">';
						echo '<a href="' . esc_url( $facebook ) . '" target="' . esc_attr( $button_tab ) . '"><i class="icon-facebook"></i></a>';
					echo '</span>';
				endif;
				
				if ( $instagram ) :
					echo '<span class="header-top-instagram">';
						echo '<a href="' . esc_url( $instagram ) . '" target="' . esc_attr( $button_tab ) . '"><i class="icon-instagram"></i></a>';
					echo '</span>';
				endif;

				if ( $twitter ) :
					echo '<span class="header-top-twitter">';
						echo '<a href="' . esc_url( $twitter ) . '" target="' . esc_attr( $button_tab ) . '"><i class="ri-twitter-x-fill"></i></a>';
					echo '</span>';
				endif;
				
				if ( $linkedin ) :
					echo '<span class="header-top-linkedin">';
						echo '<a href="' . esc_url( $linkedin ) . '" target="' . esc_attr( $button_tab ) . '"><i class="icon-linkedin2"></i></a>';
					echo '</span>';
				endif;
				
				if ( $youtube ) :
					echo '<span class="header-top-youtube">';
						echo '<a href="' . esc_url( $youtube ) . '"><i class="icon-youtube"></i></a>';
					echo '</span>';
				endif;
				
				if ( $tiktok ) :
					echo '<span class="header-top-tiktok">';
						echo '<a href="' . esc_url( $tiktok ) . '" target="' . esc_attr( $button_tab ) . '"><i class="ri-tiktok-fill"></i></a>';
					echo '</span>';
				endif;
				do_action( 'edublink_header_top_social_icon_after' );
			echo '</div>';
		endif;
	}
endif;

/**
 * Theme header top bar 1
 */
if ( ! function_exists( 'edublink_header_top_1' ) ) :
	function edublink_header_top_1() {
		$message = edublink_set_value( 'header_top_message_text', __( 'First 20 students get 50% discount.', 'edublink' ) );
		$phone_text = edublink_set_value( 'header_top_phone_text', __( 'Call: ', 'edublink' ) );
		$email_text = edublink_set_value( 'header_top_email_text', __( 'Email: ', 'edublink' ) );
		$phone = edublink_set_value( 'header_top_phone_number', '123 4561 5523' );
		$email = edublink_set_value( 'header_top_email_address', 'info@edublink.co' );
		$social_icons = edublink_set_value( 'header_top_social_share', true );

		if ( $message ) :
			echo '<div class="header-top-left">';
				echo '<div class="header-top-message">';
					echo wp_kses_post( $message );
				echo '</div>';
			echo '</div>';
		endif;

		echo '<div class="header-top-right">';
			edublink_header_top_login_register_button();

			if ( $phone ) :
				echo '<div class="header-top-phone">';
					echo '<a href="tel:' . esc_attr( $phone ) . '"><i class="icon-phone"></i>'. esc_html( $phone_text ) . ' ' . esc_html( $phone ) . '</a>';
				echo '</div>';
			endif;

			if ( $email ) :
				echo '<div class="header-top-email">';
					echo '<a href="mailto:' . esc_attr( $email ) . '"><i class="icon-envelope"></i>'. esc_html( $email_text ) . ' ' . esc_html( $email ) . '</a>';
				echo '</div>';
			endif;

			if ( $social_icons ) :
				edublink_header_top_social_share();
			endif;
		echo '</div>';
	}
endif;

/**
 * Theme header top bar 2
 */
if ( ! function_exists( 'edublink_header_top_2' ) ) :
	function edublink_header_top_2() {
		$phone = edublink_set_value( 'header_top_phone_number', '123 4561 5523' );
		$email = edublink_set_value( 'header_top_email_address', 'info@edublink.co' );
		$button_text = edublink_set_value( 'header_top_button_text' );
		$button_url = edublink_set_value( 'header_top_button_url', '#' );
		$button_text_logged_in = edublink_set_value( 'header_top_button_text_after_logged_in' ) ? edublink_set_value( 'header_top_button_text_after_logged_in' ) : $button_text;
		$button_url_logged_in = edublink_set_value( 'header_top_button_url_after_logged_in' ) ? edublink_set_value( 'header_top_button_url_after_logged_in' ) : $button_url;
		$same_tab = edublink_set_value( 'header_top_button_open_same_tab', true );
		$phone_text = edublink_set_value( 'header_top_phone_text', __( 'Call: ', 'edublink' ) );
		$email_text = edublink_set_value( 'header_top_email_text', __( 'Email: ', 'edublink' ) );
		if ( $same_tab ) :
			$tab = '_self';
		else :
			$tab = '_blank';
		endif;

		if ( $phone || $email ) :
			echo '<div class="header-top-left">';
				if ( $phone ) :
					echo '<div class="header-top-phone">';
						echo '<a href="tel:' . esc_attr( $phone ) . '"><i class="icon-phone"></i>'. esc_html( $phone_text ) . ' ' . esc_html( $phone ) . '</a>';
					echo '</div>';
				endif;

				if ( $email ) :
					echo '<div class="header-top-email">';
						echo '<a href="mailto:' . esc_attr( $email ) . '"><i class="icon-envelope"></i>'. esc_html( $email_text ) . ' ' . esc_html( $email ) . '</a>';
					echo '</div>';
				endif;
			echo '</div>';
		endif;

		echo '<div class="header-top-right">';
			edublink_header_top_login_register_button();

			if ( edublink_set_value( 'header_top_button_status', true ) ) :
				if( ! is_user_logged_in() ) :
					if ( $button_text ) :
						echo '<a href="' . esc_url( $button_url ). '" target="' . esc_attr( $tab ) . '" class="edu-btn btn-medium">' . wp_kses_post( $button_text ) . '</a>';
					else :
						echo '<a href="' . esc_url( $button_url ). '" target="' . esc_attr( $tab ) . '" class="main-header-btn edu-btn btn-medium">' . __( 'Apply Now', 'edublink' ) . ' <i class="icon-4"></i></a>';
					endif;
				else :
					if ( $button_text_logged_in ) :
						echo '<a href="' . esc_url( $button_url_logged_in ). '" target="' . esc_attr( $tab ) . '" class="edu-btn btn-medium">' . wp_kses_post( $button_text_logged_in ) . '</a>';
					else :
						echo '<a href="' . esc_url( $button_url_logged_in ). '" target="' . esc_attr( $tab ) . '" class="main-header-btn edu-btn btn-medium">' . __( 'Apply Now', 'edublink' ) . ' <i class="icon-4"></i></a>';
					endif;
				endif;
			endif;
		echo '</div>';
	}
endif;

/**
 * Theme header top bar login/register button
 */
if ( ! function_exists( 'edublink_header_top_login_register_button' ) ) :
	function edublink_header_top_login_register_button() {
		if ( edublink_set_value( 'header_login_register_popup', true ) ) :
			$login_text = edublink_set_value( 'header_login_register_popup_text', __( 'Login/Register', 'edublink' ) );
			$logout_text = edublink_set_value( 'header_logout_text', __( 'Logout', 'edublink' ) );
			echo '<div class="header-top-login-register">';
				if( ! is_user_logged_in() ) :
					echo '<a href="javascript:void(0)" class="eb-login-register-popup-trigger">' . esc_html( $login_text ) . '</a>';
				else :
					$learnpress_profile = edublink_set_value( 'lp_header_top_username_show', false );
					$tutor_dashboard = edublink_set_value( 'tl_header_top_username_show', false );
					$lifter_profile = edublink_set_value( 'll_header_top_username_show', false );
					$masterstudy_profile = edublink_set_value( 'ms_header_top_username_show', false );
					if ( edublink_is_learnpress_activated() && $learnpress_profile ) :
						$user = learn_press_get_current_user();
						$username = apply_filters( 'edublink_lp_user_name_at_header', $user->get_display_name() );
						echo '<a href="' . esc_url( learn_press_user_profile_link() ) . '" class="eb-logout-trigger"><i class="ri-user-3-fill"></i>' . wp_kses_post( $username ) . '</a>';
					elseif ( edublink_is_tutor_lms_activated() && $tutor_dashboard ) :
						$user_id   = get_current_user_id();
						$user = get_userdata( $user_id );
						$username = apply_filters( 'edublink_tl_user_name_at_header', $user->display_name );
						$page_id = (int) tutor_utils()->get_option( 'tutor_dashboard_page_id' );
						echo '<a href="' . esc_url( get_permalink( $page_id ) ) . '" class="eb-logout-trigger"><i class="ri-user-3-fill"></i>' . wp_kses_post( $username ) . '</a>';
					elseif ( edublink_is_lifter_lms_activated() && $lifter_profile ) :
						$user_id   = get_current_user_id();
						$user = get_userdata( $user_id );
						$username = apply_filters( 'edublink_ll_user_name_at_header', $user->display_name );
						$page_id = get_option( 'lifterlms_myaccount_page_id' );
						echo '<a href="' . esc_url( get_permalink( $page_id ) ) . '" class="eb-logout-trigger"><i class="ri-user-3-fill"></i>' . wp_kses_post( $username ) . '</a>';
					elseif ( edublink_is_masterstudy_lms_activated() && $masterstudy_profile ) :
						$user_id   = get_current_user_id();
						$user = get_userdata( $user_id );
						$username = apply_filters( 'edublink_ms_user_name_at_header', $user->display_name );
						$settings = get_option( 'stm_lms_settings', array() );
						$page_id = $settings['user_url'];
						if ( 'user-public-account' === edublink_set_value( 'ms_header_top_username_profile_page', 'user-account' ) ) :
							$page_id = $settings['user_url_profile'];
						endif;
						echo '<a href="' . esc_url( get_permalink( $page_id ) ) . '" class="eb-logout-trigger"><i class="ri-user-3-fill"></i>' . wp_kses_post( $username ) . '</a>';
					else :
						echo '<a href="' . esc_url( wp_logout_url() ).'" class="eb-logout-trigger">' . esc_html( $logout_text ) . '</a>';
					endif;
				endif;
			echo '</div>';
		endif;
	}
endif;

/**
 * theme after header
 * page title & breadcrumb
 */
add_action( 'edublink_after_header', 'edublink_breadcrumb_display' );
if ( ! function_exists( 'edublink_breadcrumb_display' ) ) :
	function edublink_breadcrumb_display() {
		global $post;
		global $wp_query;
		$breadcrumb = '';
		$has_bg_image = '';
		$show = true;
		$style = array();
		$query_var = $wp_query->query_vars;
		$global_breadcrumb_visibility   = edublink_set_value( 'global_breadcrumb_visibility', true );

		if ( edublink_is_lms_course_details() ) :
			return;
		endif;

		if ( edublink_is_tutor_lms_activated() && ! empty( $wp_query->query['tutor_profile_username'] ) ) :
			return;
		endif;

		if ( $global_breadcrumb_visibility ) :
			$global_breadcrumb_type   = edublink_set_value( 'global_breadcrumb_bg_type', 'image' );

			if ( 'image' === $global_breadcrumb_type ) :
				$global_breadcrumb_img   = edublink_set_value( 'global_breadcrumb_bg_image' );
				if ( isset( $global_breadcrumb_img['url'] ) && ! empty( $global_breadcrumb_img['url'] ) ) :
					$style[] = 'background-image:url(\'' . esc_url( $global_breadcrumb_img['url'] ) . '\' )';
					$has_bg_image = 'edublink-breadcrumb-has-bg';
				endif;
			elseif ( 'color' === $global_breadcrumb_type ) :
				$breadcrumb_color = edublink_set_value( 'global_breadcrumb_bg_color' );
				if ( $breadcrumb_color ) :
					$style[] = 'background-color:' . esc_attr( $breadcrumb_color );
				endif;
			endif;
		else :
			return;
		endif;

		if ( is_page() && is_object( $post ) ) :
			$breadcrumb_visibility      = get_post_meta( get_the_ID(), 'edublink_page_breadcrumb', true );
			$breadcrumb_show_framework = edublink_set_value( 'show_page_breadcrumb', true );
			if ( 'disable' !== $breadcrumb_visibility ) :
				if ( ( 'enable' === $breadcrumb_visibility ) || ( isset( $breadcrumb_show_framework ) && ! empty( $breadcrumb_show_framework ) ) ) :
					$default_breadcrumb_at_page = edublink_set_value( 'default_breadcrumb_at_page', true );
					$bg_meta_image      = get_post_meta( get_the_ID(), 'edublink_page_breadcrumb_image', true );
					$bg_meta_color      = get_post_meta( get_the_ID(), 'edublink_page_breadcrumb_color', true );
					$bg_framework_image = edublink_set_value( 'page_breadcrumb_image' );
					$bg_framework_color = edublink_set_value( 'page_breadcrumb_color' );

					if ( $bg_meta_color ) :
						$style[] = 'background-color:' . $bg_meta_color;
					elseif ( $bg_framework_color ) :
						$style[] = 'background-color:' . $bg_framework_color;
					endif;


					if ( $bg_meta_image ) : 
						$style[] = 'background-image:url(\''.esc_url( $bg_meta_image ).'\' )';
						$has_bg_image = 'edublink-breadcrumb-has-bg'; 
					elseif ( ! $default_breadcrumb_at_page ) : 
						$breadcrumb_img   = edublink_set_value( 'page_breadcrumb_image' );
						if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
							$style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
							$has_bg_image = 'edublink-breadcrumb-has-bg';
						endif;
					endif;

				else :
					return '';
				endif;
			else :
				return '';
			endif;
		
		elseif ( is_singular( 'tp_event' ) || is_post_type_archive( 'tp_event' ) || is_tax( 'tp_event_category' ) || is_tax( 'tp_event_tags' ) ) :

			$show = edublink_set_value( 'tp_event_show_breadcrumb', true );
			if ( ! $show ) :
				return ''; 
			endif;

			$default_breadcrumb_at_event = edublink_set_value( 'tp_event_show_default_breadcrumb', true );
			if ( $default_breadcrumb_at_event ) :
				$breadcrumb_img   = edublink_set_value( 'tp_event_breadcrumb_image' );
				$breadcrumb_color = edublink_set_value( 'tp_event_breadcrumb_color' );
				if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
					$style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
					$has_bg_image = 'edublink-breadcrumb-has-bg';
				endif;
				
				if ( $breadcrumb_color ) :
					$style[] = 'background-color:' . esc_attr( $breadcrumb_color );
				endif;
			endif;

		elseif ( edublink_is_lms_courses() ) :
			$show = edublink_set_value( 'show_course_breadcrumb', true );
			if ( ! $show ) :
				return ''; 
			endif;

			$default_breadcrumb_at_course = edublink_set_value( 'show_default_breadcrumb_at_course', true );
			if ( ! $default_breadcrumb_at_course ) :
				$breadcrumb_img   = edublink_set_value( 'course_breadcrumb_image' );
				$breadcrumb_color = edublink_set_value( 'course_breadcrumb_color' );

				if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
					$style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
					$has_bg_image = 'edublink-breadcrumb-has-bg';
				endif;
				
				if ( $breadcrumb_color ) :
					$style[] = 'background-color:' . esc_attr( $breadcrumb_color );
				endif;
			endif;

	    elseif ( edublink_is_woocommerce_activated() && is_woocommerce() ) :
			$show = edublink_set_value( 'show_shop_breadcrumb', true );
			if ( ! $show ) :
				return ''; 
			endif;

			$default_breadcrumb_at_shop = edublink_set_value( 'default_breadcrumb_at_shop', true );

			if ( ! $default_breadcrumb_at_shop ) :
				$breadcrumb_img   = edublink_set_value( 'shop_breadcrumb_image' );
				$breadcrumb_color = edublink_set_value( 'shop_breadcrumb_color' );

				if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
					$style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
					$has_bg_image = 'edublink-breadcrumb-has-bg';
				endif;

				if ( $breadcrumb_color ) :
					$style[] = 'background-color:' . esc_attr( $breadcrumb_color );
				endif;
			endif;
		
		elseif ( is_singular( 'post' ) || is_search() || edublink_is_blog() ) :
			$show = edublink_set_value( 'show_blog_breadcrumb', true );
			if ( ! $show ) :
				return ''; 
			endif;

			$default_breadcrumb_at_blog = edublink_set_value( 'default_breadcrumb_at_blog', true );

			if ( ! $default_breadcrumb_at_blog ) :
				$breadcrumb_img   = edublink_set_value( 'blog_breadcrumb_image' );
				$breadcrumb_color = edublink_set_value( 'blog_breadcrumb_color' );

				if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
					$style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
					$has_bg_image = 'edublink-breadcrumb-has-bg';
				endif;

				if ( $breadcrumb_color ) :
					$style[] = 'background-color:' . esc_attr( $breadcrumb_color );
				endif;
			endif;
		endif;

		$title = edublink_get_page_title();
		$extra_style = ! empty( $style ) ? ' style="' . implode( "; ", $style ) . '"' : "";

		$breadcrumb_style = edublink_set_value( 'global_breadcrumb_style_type', '1' );
		if ( is_page() && is_object( $post ) ) :
			$page_breadcrumb_style = get_post_meta( get_the_ID(), 'edublink_page_breadcrumb_style', true );
			if ( $page_breadcrumb_style === 'global' || empty( $page_breadcrumb_style ) || ! isset( $page_breadcrumb_style ) ) :
				$breadcrumb_style = $breadcrumb_style;
			else :
				$breadcrumb_style = $page_breadcrumb_style;
			endif;
		endif;

		if ( isset( $_GET['breadcrumb_preset'] ) ) :
			$breadcrumb_style = in_array( $_GET['breadcrumb_preset'], array( 'default', '1', '2' ) ) ? $_GET['breadcrumb_preset'] : 'default';
		endif;

		$breadcrumb_style = apply_filters( 'edublink_breadcrumb_style', $breadcrumb_style );
		
		if ( '1' === $breadcrumb_style ) :
			edublink_breadcrumb_style_1( $title, $has_bg_image, $extra_style );
		elseif ( '2' === $breadcrumb_style ) :
			edublink_breadcrumb_style_2( $title, $has_bg_image, $extra_style );
		else:
			edublink_breadcrumb_default_style( $title );
		endif;
	}
endif;

/**
 * Breadcrumb Shapes
 *
 */
if( ! function_exists( 'edublink_breadcrumb_shapes' ) ) :
	function edublink_breadcrumb_shapes() {
		$status = apply_filters( 'edublink_breadcrumb_shape', true );

		if ( $status ) :
			echo '<div class="shape-dot-wrapper shape-wrapper edublink-d-xl-block edublink-d-none">';
				echo '<div class="shape-image shape-1">';
					echo '<span></span>';
				echo '</div>';

				echo '<div class="shape-image shape-2">';
					echo '<span></span>';
				echo '</div>';

				echo '<div class="shape-image eb-mouse-animation shape-3">';
					echo '<span data-depth="2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-1.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';

				echo '<div class="shape-image eb-mouse-animation shape-4">';
					echo '<span data-depth="-2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-2.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';

				echo '<div class="shape-image eb-mouse-animation shape-5">';
					echo '<span data-depth="2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-3.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';
			echo '</div>';
		endif;
	}
endif;

/**
 * Breadcrumb Default Style
 */
if ( ! function_exists( 'edublink_breadcrumb_default_style' ) ) :
	function edublink_breadcrumb_default_style( $title = null, $has_bg_image = null, $extra_style = null ) {
		if ( ( is_singular( 'tutor_quiz' )|| is_singular( 'lesson' ) ) && edublink_is_tutor_lms_activated() ) :
			return;
		endif;
		echo '<div class="edublink-page-title-area edublink-default-breadcrumb '. esc_attr( $has_bg_image ) .'"' . $extra_style .'>';
			echo '<div class="' . esc_attr( apply_filters( 'edublink_breadcrumb_container_class', 'edublink-container' ) ) . '">';
				echo '<div class="edublink-page-title">';
					echo '<h1 class="entry-title">';
						echo wp_kses_post( $title ); 
					echo '</h1>';
				echo '</div>';

				echo '<div class="edublink-breadcrumb-wrapper">';
					do_action( 'edublink_breadcrumb' );
				echo '</div>';
			echo '</div>';

			edublink_breadcrumb_shapes();
		echo '</div>';
	}
endif;

/**
 * Breadcrumb Style 1
 */
if ( ! function_exists( 'edublink_breadcrumb_style_1' ) ) :
	function edublink_breadcrumb_style_1( $title = null, $has_bg_image = null, $extra_style = null ) {
		echo '<div class="edublink-page-title-area edublink-breadcrumb-style-1 '. esc_attr( $has_bg_image ) .'"' . $extra_style .'>';
			echo '<div class="' . esc_attr( apply_filters( 'edublink_breadcrumb_container_class', 'edublink-container' ) ) . '">';
				echo '<div class="edublink-page-title">';
					echo '<h1 class="entry-title">';
						echo wp_kses_post( $title ); 
					echo '</h1>';
				echo '</div>';

				echo '<div class="edublink-breadcrumb-wrapper">';
					do_action( 'edublink_breadcrumb' );
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Breadcrumb Style 2
 */
if ( ! function_exists( 'edublink_breadcrumb_style_2' ) ) :
	function edublink_breadcrumb_style_2( $title = null, $has_bg_image = null, $extra_style = null ) {
		echo '<div class="edublink-breadcrumb-style-2">';
			echo '<div class="' . esc_attr( apply_filters( 'edublink_breadcrumb_container_class', 'edublink-container' ) ) . '">';
				echo '<div class="edublink-breadcrumb-wrapper">';
					do_action( 'edublink_breadcrumb' );
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;

/**
 * Setup breadcrumb
 */
add_action( 'edublink_breadcrumb', 'edublink_breadcrumb_setup', 10 );

if ( ! function_exists( 'edublink_breadcrumb_setup' ) ) :
	function edublink_breadcrumb_setup() {
		edublink_breadcrumb_default();
	}
endif;

/**
 * page title
 */
if ( ! function_exists( 'edublink_get_page_title' ) ) :
	function edublink_get_page_title() {
		global $post;
		$title = get_the_title();

		if ( is_home() ) :
			$title = apply_filters( 'edublink_blog_page_title', __( 'Blog', 'edublink' ) );
		elseif ( is_singular( 'post' ) ) :
			$title = get_the_title();
		elseif ( is_archive() ) :
			$title = get_the_archive_title();
			if ( is_post_type_archive( 'lp_course' ) ) :
				$lp_course_archive_page_title = edublink_set_value( 'lp_course_archive_breadcrumb_heading' );
				$title = $lp_course_archive_page_title ? $lp_course_archive_page_title : $title;
			elseif ( is_post_type_archive( 'courses' ) && edublink_is_tutor_lms_activated() ) :
				$tl_course_archive_page_title = edublink_set_value( 'tl_course_archive_breadcrumb_heading' );
				$title = $tl_course_archive_page_title ? $tl_course_archive_page_title : $title;
			endif;
			// if ( is_post_type_archive( 'product' ) ) :
			// 	// $shop_product_archive_page_title = edublink_set_value( 'woo_product_archive_breadcrumb_heading' );
			// 	// $title = $shop_product_archive_page_title ? $shop_product_archive_page_title : $title;
				// $title = '*********';
			// endif;
		elseif ( is_day() ) :
			$title = get_the_time( get_option( 'date_format' ) );
		elseif ( is_month() ) :
			$title = get_the_time( 'F Y' );
		elseif ( is_year() ) :
			$title = get_the_time( 'Y' );
		elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() && ! is_author() && ! is_search() ) :
			$post_type = get_post_type_object( get_post_type() );
			if ( is_object( $post_type ) ) :
				$title = $post_type->labels->singular_name;
			endif;
		elseif ( is_attachment() ) :
			$title = get_the_title();
		elseif ( is_page() && ! $post->post_parent ) :
			$title = get_the_title();
			$page_custom_title = get_post_meta( $post->ID, 'edublink_page_title_at_breadcrumb', true );
			$title = $page_custom_title ? $page_custom_title : $title;
		elseif ( is_page() && $post->post_parent ) :
			$title = get_the_title();
			$page_custom_title = get_post_meta( $post->ID, 'edublink_page_title_at_breadcrumb', true );
			$title = $page_custom_title ? $page_custom_title : $title;
		elseif ( is_search() ) :
			if ( edublink_is_search_has_results() ) :
				$title = __( 'Search results for', 'edublink' );
			else :
				$title = __( 'Nothing Found', 'edublink' );
			endif;
		elseif ( is_tag() ) :
			$title = __( 'Posts tagged "', 'edublink' ). single_tag_title( '', false ) . '"';
		elseif ( is_author() ) :
			global $author;
			$userdata = get_userdata( $author );
			$title = $userdata->display_name;
		elseif ( is_404() ) :
			$title = __( '404: Error Not Found', 'edublink' );
		elseif ( is_singular( 'lp_course' ) ) :
			$title = get_the_title();
		elseif ( ( function_exists( 'edublink_is_lp_courses' ) && edublink_is_lp_courses() ) ) :
			$title = esc_html( get_the_title( learn_press_get_page_id( 'courses' ) ) );
		endif;
		return apply_filters( 'edublink_page_breadcrumb_title', $title );
	}
endif;

/**
 * Setup breadcrumb
 */
if ( ! function_exists( 'edublink_breadcrumb_default' ) ) :
	function edublink_breadcrumb_default( $spacer = ' ', $word = '' ) {
		$main_home = apply_filters( 'edublink_breadcrumb_home_text', __( 'Home', 'edublink' ) );
		$yoast_breadcrumb = apply_filters( 'edublink_breadcrumb_replace_with_yoast', true );
		$before = '<li><span class="active">';
		$after = '</span></li>';
		
		if ( ! is_front_page() || is_paged() ) :
			global $post;
			$homeURL = esc_url( home_url() );

			
			if ( function_exists( 'yoast_breadcrumb' ) && $yoast_breadcrumb ) :
				yoast_breadcrumb( '<nav class="edublink-yoast-breadcrumb">', '</nav>' );
				return;
			endif;

			echo '<nav class="edublink-breadcrumb">';
				echo '<ul class="breadcrumb">';
					echo '<li><a href="' . esc_url( $homeURL ) . '">' . wp_kses_post( $main_home ) . '</a> ' . wp_kses_post( $spacer ) . '</li> ';

					if ( is_category() ) :
						global $wp_query;
						$cat_obj = $wp_query->get_queried_object();
						$thisCat = $cat_obj->term_id;
						$thisCat = get_category( $thisCat );
						$parentCat = get_category( $thisCat->parent );
						echo '<li>';
						if ( $thisCat->parent != 0 )
							echo get_category_parents( $parentCat, TRUE, '</li><li>' );
						echo '<span class="active">' . single_cat_title( '', false ) . wp_kses_post( $after );

					elseif ( is_day() ) :
						echo '<li><a href="' . esc_url( get_year_link(get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li> ' . wp_kses_post( $spacer ) . ' ';
						echo '<li><a href="' . esc_url( get_month_link(get_the_time( 'Y' ),get_the_time( 'm' )) ) . '">' . get_the_time( ' F' ) . '</a></li> ' . wp_kses_post( $spacer ) . ' ';
						echo trim( $before ) . get_the_time( 'd' ) . wp_kses_post( $after );

					elseif ( is_month() ) :
						echo '<a href="' . esc_url( get_year_link(get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li> ' . wp_kses_post( $spacer ) . ' ';
						echo trim( $before ) . get_the_time( 'F' ) . wp_kses_post( $after );
						
					elseif ( is_year() ) :
						echo trim( $before ) . get_the_time( 'Y' ) . wp_kses_post( $after );

					elseif ( is_single() && ! is_attachment() ) :
						if ( get_post_type() != 'post' ) :
							$post_type = get_post_type_object( get_post_type() );
							$slug = $post_type->rewrite;
							$slug_url = '';
							
							if ( isset( $slug['slug'] ) && ! empty( $slug['slug'] ) ) :
								$slug_url = $slug['slug'] . '/';
							endif;

							echo '<li><a href="' . esc_url( $homeURL ) . '/' . $slug_url . '">' . $post_type->labels->singular_name . '</a></li> ' . $spacer . ' ';
							// echo '<li><a href="' . esc_url( $homeURL ) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $spacer . ' ';
							echo trim( $before ) . get_the_title() . wp_kses_post( $after );

						elseif ( get_post_type() == 'post' ) :
							global $post;
							$cat = get_the_category(); $cat = $cat[0];
							echo '<li>'.get_category_parents($cat, TRUE, '</li><li class="hidden">');
							echo '<span class="active">'. $post->post_title . wp_kses_post( $after );

						else :
							$cat = get_the_category(); $cat = $cat[0];
							echo '<li>'.get_category_parents($cat, TRUE, '</li>');
						endif;
					elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() && ! is_author() && ! is_search() ) :
						$post_type = get_post_type_object( get_post_type() );
						if ( is_object( $post_type ) ) :
							echo trim( $before ) . $post_type->labels->singular_name . wp_kses_post( $after );
						endif;

					elseif ( is_404() ) :
						echo trim( $before) . __( 'Error 404', 'edublink' ) . wp_kses_post( $after );

					elseif ( is_attachment() ) :
						$parent = get_post($post->post_parent);
						$cat = get_the_category($parent->ID);
						echo '<li>';

						if ( ! empty( $cat ) ) :
							$cat = $cat[0];
							echo get_category_parents($cat, TRUE, '</li><li>');
						endif;

						if ( ! empty( $parent ) ) :
							echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li><li>';
						endif;
						echo '<span class="active">'.get_the_title() . wp_kses_post( $after );

					elseif ( is_page() ) :
						$page_custom_title = get_post_meta( get_the_ID(), 'edublink_page_title_at_breadcrumb', true );
						$page_custom_sub_title = get_post_meta( get_the_ID(), 'edublink_page_sub_title_at_breadcrumb', true );
						$page_custom_title = $page_custom_sub_title ? $page_custom_sub_title : $page_custom_title;
						if ( ! $post->post_parent ) :
							if ( $page_custom_title ) :
								echo trim( $before ) . esc_html( $page_custom_title ) . wp_kses_post( $after );
							else :
								echo trim( $before ) . get_the_title() . wp_kses_post( $after );
							endif;
						elseif ( $post->post_parent ) :
							$parent_id  = $post->post_parent;
							$breadcrumbs = array();
							while ( $parent_id ) :
								$page = get_page( $parent_id );
								$breadcrumbs[] = '<li><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . esc_html( get_the_title( $page->ID ) ) . '</a></li>';
								$parent_id  = $page->post_parent;
							endwhile;

							$breadcrumbs = array_reverse($breadcrumbs);
							foreach ( $breadcrumbs as $breadcrumb ) :
								echo trim( $breadcrumb ) . ' ' . $spacer . ' ';
							endforeach;
							if ( $page_custom_title ) :
								echo trim( $before ) . esc_html( $page_custom_title ) . wp_kses_post( $after );
							else :
								echo trim( $before ) . get_the_title() . wp_kses_post( $after );
							endif;
						endif;

					elseif ( is_search() ) :
						echo trim( $before ) . sprintf( __( 'Search results for "%s"', 'edublink' ), get_search_query() ) . wp_kses_post( $after );

					elseif ( is_tag() ) :
						echo trim( $before ) . sprintf( __( 'Posts tagged "%s"', 'edublink' ), single_tag_title( '', false ) ) . wp_kses_post( $after );

					elseif ( is_author() ) :
						global $author;
						$userdata = get_userdata($author);
						echo trim( $before ) . __( 'Articles posted by ', 'edublink' ) . $userdata->display_name . wp_kses_post( $after );

					elseif ( is_404() ) :
						echo trim( $before ) . __( 'Error 404', 'edublink' ) . wp_kses_post( $after );

					elseif ( is_home() ) :
						$posts_page_id = get_option( 'page_for_posts');
						if ( $posts_page_id ) :
							$label = get_the_title( $posts_page_id );
						else :
							$label = __( 'Blog', 'edublink' );
						endif;
						echo trim( $before ) . $label . wp_kses_post( $after );
					endif;
				echo '</ul>';
			echo '</nav>';
		endif;
	}
endif;

/**
 * Setup breadcrumb Alter
 */
if ( ! function_exists( 'edublink_breadcrumb_default_alt' ) ) :
	function edublink_breadcrumb_default_alt( $word = '' ) {
	 	echo '<nav class="edublink-breadcrumb">';
			echo '<ul class="breadcrumb">';
				if ( ! is_home() ) :
					echo '<li><a href="' . esc_url( get_home_url( '/' ) ) . '">' . apply_filters( 'edublink_breadcrumb_home_text', __( 'Home', 'edublink' ) ) . '</a></li>';

					if ( is_category() || is_single() ) :
						echo '<li>';
							$category	 = get_the_category();
							$post		 = get_queried_object();
							$postType	 = get_post_type_object( get_post_type( $post ) );
						
							if ( ! empty( $category ) ) :
								echo esc_html( $category[ 0 ]->cat_name ) . '</li>';
							elseif ( defined( 'LP_COURSE_CPT' ) && is_category() ) :
								single_cat_title() . '</li>';
							elseif ( $postType ) :
								echo esc_html( $postType->labels->singular_name ) . '</li>';
							endif;

						if ( is_single() ) :
							echo  '<li>';
								echo esc_html( $word ) != '' ? wp_trim_words( get_the_title(), $word ) : get_the_title();
							echo '</li>';
						endif;
						
					elseif ( is_page() ) :
						echo '<li>';
							$page_custom_title = get_post_meta( get_the_ID(), 'edublink_page_title_at_breadcrumb', true );
							$page_custom_sub_title = get_post_meta( get_the_ID(), 'edublink_page_sub_title_at_breadcrumb', true );
							if ( $page_custom_title || $page_custom_sub_title ) :
								if ( $page_custom_sub_title ) :
									echo esc_html( $page_custom_sub_title  );
								else :
									echo esc_html( $page_custom_title );
								endif;
							else :
								echo esc_html( $word ) != '' ? wp_trim_words( get_the_title(), $word ) : get_the_title();
							endif;
						echo '</li>';
					endif;
				endif;

				if ( edublink_is_tutor_lms_activated() ) :
					$course_post_type = tutor()->course_post_type;
					
					if ( $course_post_type === 'courses' && is_post_type_archive( 'courses' ) ) :
						echo '<li>' . __( ' Courses', 'edublink' ) . '</li>';	
					endif;
				endif;

				if ( is_post_type_archive( 'simple_team' ) ) :
				  	echo '<li>' . __( ' Team', 'edublink' ) . '</li>';	
				endif;

				if ( is_post_type_archive( 'product' ) ) :
				  	echo '<li>' . __( ' Products', 'edublink' ) . '</li>';	
				endif;

				if ( is_tag() ) :
					echo '<li>'; 
						echo sprintf( __( 'Posts tagged "%s"', 'edublink' ), single_tag_title( '', false ) );
					echo '</li>';
				elseif ( is_day() ) :
					echo '<li>' . __( 'Blogs for', 'edublink' ) . ' ';
						the_time( 'F jS, Y' );
					echo '</li>';
				elseif ( is_month() ) :
					echo'<li>' . __( 'Blogs for', 'edublink' ) . ' ';
						the_time( 'F, Y' );
					echo'</li>';
				elseif ( is_year() ) :
					echo'<li>' . __( 'Blogs for', 'edublink' ) . ' ';
						the_time( 'Y' );
					echo'</li>';
				elseif ( is_author() ) :
					global $author;
					$userdata = get_userdata( $author );
					echo'<li>';
						echo __( 'Articles posted by ', 'edublink' ) . $userdata->display_name;
					echo'</li>';
				elseif ( isset( $_GET[ 'paged' ] ) && !empty( $_GET[ 'paged' ] ) ) :
					echo '<li>' . __( 'Blogs', 'edublink' ) . '</li>';
				elseif ( is_search() ) :
					echo '<li>' . sprintf( __( 'Search results for "%s"', 'edublink' ), get_search_query() ) . '</li>';
				elseif ( is_404() ) :
					echo '<li>' . __( '404: Error Not Found', 'edublink' ) . '</li>';
				elseif ( is_home() ) :
					echo '<li>' . __( 'Blog Page', 'edublink') . '</li>';
				elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() && ! is_author() && ! is_search() ) :
					$post_type = get_post_type_object( get_post_type() );
					if ( is_object( $post_type ) ) :
						echo '<li>' . $post_type->labels->singular_name . '</li>';
					endif;
				endif;
			echo '</ul>';
		echo '</nav>';
	}
endif;

if( ! function_exists( 'edublink_login_register_form_popup' ) ) :
	function edublink_login_register_form_popup() { 
		if( is_user_logged_in() || ( ! edublink_set_value( 'header_login_register_popup', true ) ) ) return;

		$logged_in_after = apply_filters( 'edublink_login_after_link', wp_login_url() );

		echo '<div id="edublink-custom-login-wrapper" class="edublink-login-form-popup">';
            echo '<div class="edublink-login-form-inner">';
				echo '<div class="edublink-login-popup-close"><button class="close-trigger"><i class="icon-73"></i></button></div>';
				echo '<div class="edublink-login-form-content">';
					echo '<div id="edublink-login-form-wrapper" class="edublink-login-form-wrapper">';
						echo '<div class="edublink-login-form-tab-wrapper">';
							echo '<div class="edublink-login-form-tab">';
								echo '<span class="login-tab-title login-item active" data-tab-id="tab1">' . __( 'Sign in', 'edublink' ) . '</span>';
								echo '<span class="login-tab-title register-item" data-tab-id="tab2">' . __( 'Sign up', 'edublink' ) . '</span>';
							echo '</div>';
						echo '</div>';

						echo '<div class="edublink-login-form-items">';
							echo '<div class="edublink-login-form-item login-form" id="tab1">';
								echo '<div class="edublink-login-box-text">';
									echo '<h3 class="sign-in-heading">' . __( 'Sign in', 'edublink' ) . '</h3>';

									echo '<div class="edublink-register-text">';
										echo '<span class="note-for-non-account-user">';
											echo __( 'Don’t have an account?', 'edublink' );
										echo '</span>';
										echo '<span id="edublink-register-form-trigger">';
											echo ' ' . __( 'Sign up', 'edublink' );
										echo '</span>';
									echo '</div>';
								echo '</div>';

								echo '<form action="' . esc_url( $logged_in_after ) . '" class="edublink-login-form-container" method="post">';
									echo '<div class="edublink-login-item">';
										echo '<input type="text" name="log" id="username" placeholder="' . __( 'Email or username', 'edublink' ) . '" required>';
									echo '</div>';

									echo '<div class="edublink-login-item">';
										echo '<input type="password" name="pwd" id="password" placeholder="' . __( 'Password', 'edublink' ) . '" required>';
									echo '</div>';

									echo '<div class="remember-me-with-register">';
										echo '<label class="forgetmenot">';
											echo '<input name="rememberme" class="remember-user" type="checkbox" id="rememberme" value="forever">';
											echo '<span class="remember-me-text">' . __( 'Remember me', 'edublink' ) . '</span>';
										echo '</label>';

										echo '<a href=' . esc_url( wp_lostpassword_url() ) . '" class="lost_password">' . __( 'Lost your password?', 'edublink' ) . '</a>';
									echo '</div>';

									echo '<div class="edublink-login-register-button button-login">';
										echo '<div class="edublink-login-register-wrapper">';
											echo '<input type="submit" value="' . __( 'Sign in', 'edublink' ) . '" class="edublink-submit-button login">';
										echo '</div>';
									echo '</div>';
								echo '</form>';
							echo '</div>';

							echo '<div class="edublink-login-form-item register-form" id="tab2">';
								echo '<div class="edublink-register-box-text">';
									echo '<h3 class="sign-up-heading">' . __( 'Sign up', 'edublink' ) . '</h3>';

									echo '<div class="edublink-login-text">';
										echo '<span class="note-for-account-user">';
											echo __( 'Already have an account?', 'edublink' );
										echo '</span>';
										echo '<span id="edublink-login-form-trigger">';
											echo ' ' . __( 'Sign in', 'edublink' );
										echo '</span>';
									echo '</div>';
								echo '</div>';

								echo '<form action="' . esc_url( wp_registration_url() ) . '" class="edublink-register-form-container" method="post">';
									echo '<div class="edublink-login-item">';
										echo '<input type="text" name="user_login" id="reg_username" placeholder="' . __( 'Username', 'edublink' ) . '" required>';
									echo '</div>';

									echo '<div class="edublink-login-item">';
										echo '<input type="email" name="user_email" id="reg_email" placeholder="' . __( 'Email', 'edublink' ) . '" required>';
									echo '</div>';
									
									echo '<div class="edublink-login-item">';
										echo '<input type="password" name="user_pass" id="reg_password" placeholder="' . __( 'Password', 'edublink' ) . '" required>';
									echo '</div>';

									do_action( 'register_form' );

									echo '<div class="edublink-login-register-button button-register">';
										echo '<div class="edublink-login-register-wrapper">';
											echo '<input type="submit" value="' . __( 'Sign up', 'edublink' ) . '" class="edublink-submit-button register">';
										echo '</div>';
									echo '</div>';
								echo '</form>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
            echo '</div>';
        echo '</div>';

		echo '<div class="edublink-login-popup-overlay"></div>';
	}
endif;

/**
 * EduBlink Footer Content
 */
if ( ! function_exists( 'edublink_footer_content_init' ) ) :
	function edublink_footer_content_init() {
		// search modal popup
		edublink_search_modal_popup();

		// preloader
		$preloader = edublink_set_value( 'preloader', false );
		if ( $preloader ) : 
			get_template_part( 'template-parts/preloaders/preloader' );
		endif;

		// scroll to top
		if ( edublink_set_value( 'scroll_to_top', true ) ) :
			echo '<div class="devsblink-progress-parent">';
				echo '<svg class="devsblink-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">';
					echo '<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />';
				echo '</svg>';
			echo '</div>';
		endif;

		// login register form popup
		if ( edublink_set_value( 'header_login_register_popup', true ) ) :
			edublink_login_register_form_popup();
		endif;
	}
endif;
add_action( 'wp_footer', 'edublink_footer_content_init' );

/**
 * is Search has result
 */
if ( ! function_exists( 'edublink_is_search_has_results' ) ) :
	function edublink_is_search_has_results() {
	    return 0 != $GLOBALS['wp_query']->found_posts;
	}
endif;

/**
 * Register Google fonts.
 *
 * @return string Google fonts URL for the theme.
 */
if ( ! function_exists( 'edublink_main_fonts_url' ) ) :
	function edublink_main_fonts_url() {
		$body_typo_array = edublink_set_value( 'theme_body_typo' );
		$heading_typo_array = edublink_set_value( 'theme_heading_typo' );
		$body_font_family = 'Poppins';
		$heading_font_family = 'Spartan';

		if ( isset( $body_typo_array['font-family'] ) && ! empty( $body_typo_array['font-family'] ) ) :
			$body_font_family = $body_typo_array['font-family'];
		endif;

		if ( isset( $heading_typo_array['font-family'] ) && ! empty( $heading_typo_array['font-family'] ) ) :
			$heading_font_family = $heading_typo_array['font-family'];
		endif;

	    $fonts_url = '';
	    $fonts     = array();
	    $subsets   = 'latin,latin-ext';
	    if ( 'off' !== esc_html_x( 'on', $body_font_family . ' font: on or off', 'edublink' ) ) :
	        $fonts[] = $body_font_family . ':300,400,500,600,700,800';
	    endif;
		
	    if ( 'off' !== esc_html_x( 'on', $heading_font_family . ' font: on or off', 'edublink' ) ) :
	        $fonts[] = $heading_font_family . ':300,400,500,600,700,800';
	    endif;

	    if ( $fonts ) :
	        $fonts_url = add_query_arg( array(
	            'family' => urlencode( implode( '|', $fonts ) ),
	            'subset' => urlencode( $subsets ),
	        ), 'https://fonts.googleapis.com/css' );
	    endif;
	    return esc_url_raw( $fonts_url );
	}
endif;

// Enqueue Google Fonts styles
add_action( 'wp_enqueue_scripts', 'edublink_google_fonts_adding' );
if ( ! function_exists( 'edublink_google_fonts_adding' ) ) :
	function edublink_google_fonts_adding() {
	    wp_enqueue_style( 'edublink-main-fonts', edublink_main_fonts_url(), array(), EDUBLINK_THEME_VERSION );
	}
endif;

/**
 * Excerpt more
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_excerpt_more' ) ) :
	function edublink_excerpt_more( $more ) {
	    return '&#8230;';
	}
endif;
add_filter( 'excerpt_more', 'edublink_excerpt_more' );

/**
 * EduBlink Post Archive Support For Theme Option
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_has_archive_theme_option_support' ) ) :
	function edublink_has_archive_theme_option_support () {
		$supported = [
			'lp_course',
			'product'
		];
		return $supported;
	}
endif;

/**
 * is Blog
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_is_blog' ) ) :
	function edublink_is_blog () {
		global $post;
		$posttype = get_post_type( $post );
		return ( ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) || ( is_search() ) ) && ( ! in_array( $posttype, edublink_has_archive_theme_option_support() ) ) ) ? true : false ;
	}
endif;

/**
 * Page Layout setup
 *
 * @since 1.0.0
 */
add_filter( 'edublink_container_class', 'edublink_page_layout_setup' );
if ( ! function_exists( 'edublink_page_layout_setup' ) ) :
	function edublink_page_layout_setup( $class ) {
		if ( is_page() ) :
			$page_layout = get_post_meta( get_the_ID(), 'edublink_page_layout_type', true );
			if ( 'full-width' === $page_layout ) :
            	$class = ' edublink-fullwidth-page-container';
            else :
            	$class = ' edublink-page-container edublink-container';
            endif;
		endif;

		if ( is_singular( 'elementor_library' ) ) :
			$class = ' edublink-elementor-fullwidth-page-container';
		endif;

		return $class;
	}
endif;

/**
 * Before Content
 *
 * @since 1.0.0
 */
add_action( 'edublink_before_content', 'edublink_before_main_content' );
if ( ! function_exists( 'edublink_before_main_content' ) ) :
	function edublink_before_main_content(){
		$layout_type = '';

		if ( true === edublink_is_blog() ) :
			$layout_type = ' edublink-row';
		endif;

		if ( is_post_type_archive( 'zoom-meetings' ) ) :
			$layout_type = ' edublink-blog-post-archive-style-1 edublink-row';
		endif;

		if ( is_page() ) :
			$page_layout = get_post_meta( get_the_ID(), 'edublink_page_layout_type', true );
			if ( 'full-width' === $page_layout ) :
            	$layout_type = ' edublink-fullwidth-page-row';
            else :
            	$layout_type = ' edublink-row';
            endif;
		endif;

		if ( is_404() ) :
			$layout_type = ' edublink-row edublink-justify-content-center';
		endif;

		if ( is_search() ) :
			$layout_type = ' edublink-row';
		endif;
		
		if ( is_singular( 'elementor_library' ) ) :
			$layout_type = '';
		endif;

		if ( is_post_type_archive( 'product' ) || is_post_type_archive( 'tp_event' ) || is_tax( 'tp_event_category' ) || is_tax( 'tp_event_tag' ) ) :
			$layout_type = '';
		endif;

		if ( function_exists( 'tml_get_action' ) ) :
			if ( tml_get_action() ) :
				$layout_type = ' edublink-row edublink-justify-content-center';
			endif;
		endif;

		echo '<div class="edublink-main-content-inner' . esc_attr( apply_filters( 'edublink_main_content_inner', $layout_type ) ) . '">';
	}
endif;

/**
 * After Content
 *
 * @since 1.0.0
 */
add_action( 'edublink_after_content', 'edublink_after_main_content' );
if ( ! function_exists( 'edublink_after_main_content' ) ) :
	function edublink_after_main_content(){
		echo '</div>';
	}
endif;

/**
 * Content area class
 *
 * @since 1.0.0
 */
add_filter( 'edublink_content_area_class', 'edublink_content_wrapper_class' );
if ( ! function_exists( 'edublink_content_wrapper_class' ) ) :
	function edublink_content_wrapper_class ( $class ) {
		if ( edublink_is_blog() ) :
			$blog_layout = edublink_set_value( 'blog_archive_layout', 'right-sidebar' );
			$blog_sidebar = edublink_set_value( 'blog_archive_sidebar_name', 'blog-sidebar' );
			if ( isset( $_GET['sidebar_disable'] ) ) :
				$blog_sidebar = 'no-sidebar';
			endif;

			if ( ! is_active_sidebar( $blog_sidebar ) ) :
				$class = 'edublink-col-lg-12';
			elseif ( 'right-sidebar' === $blog_layout ) :
				$class = 'edublink-col-lg-8';
			elseif ( 'left-sidebar' === $blog_layout ) :
				$class = 'edublink-col-lg-8 edublink-order-2';
			elseif ( 'no-sidebar' === $blog_layout ) :
				$class = 'edublink-col-lg-12';
			endif;
		endif;

		if ( is_single() ) :
			$single_layout = edublink_set_value( 'blog_single_layout', 'right-sidebar' );
			$single_sidebar = edublink_set_value( 'blog_single_sidebar_name', 'blog-sidebar' );
			if ( ! is_active_sidebar( $single_sidebar ) ) :
				$class = 'edublink-col-lg-12';
			elseif ( 'right-sidebar' === $single_layout ) :
				$class = 'edublink-col-lg-8';
			elseif ( 'left-sidebar' === $single_layout ) :
				$class = 'edublink-col-lg-8 edublink-order-2';
			elseif ( 'no-sidebar' === $single_layout ) :
				$class = 'edublink-col-lg-12';
			endif;
		endif;

		if ( is_single() && 'simple_team' === get_post_type() ) :
			$class = 'edublink-col-lg-12';
		endif;

		if ( is_page() ) :
			$content_type = get_post_meta( get_the_ID(), 'edublink_page_content_type', true );
			$page_layout  = get_post_meta( get_the_ID(), 'edublink_page_layout_type', true );
			$page_sidebar  = get_post_meta( get_the_ID(), 'edublink_page_sidebar_name', true );
			if ( isset( $page_layout ) && ! empty( $page_layout ) ) :
				if ( 'full-width' === $page_layout ) :
					$class = 'edublink-col-lg-12';
				else :
					if ( ! is_active_sidebar( $page_sidebar ) ) :
						$class = 'edublink-col-lg-12';
					elseif ( 'right-sidebar' === $content_type ) :
						$class = 'edublink-col-lg-8';
					elseif ( 'left-sidebar' === $content_type ) :
						$class = 'edublink-col-lg-8 edublink-order-2';
					elseif ( 'no-sidebar' === $content_type ) :
						$class = 'edublink-col-lg-12';
					endif;
				endif;
			else : 
				$class = 'edublink-col-lg-12';
			endif;
		endif;

		return $class;
	}
endif;

/**
 * Widget area class
 *
 * @since 1.0.0
 */
add_filter( 'edublink_widget_area_class', 'edublink_widget_wrapper_class' );
if ( ! function_exists( 'edublink_widget_wrapper_class' ) ) :
	function edublink_widget_wrapper_class ( $class ) {
		if ( edublink_is_blog() ) :
			$blog_layout = edublink_set_value( 'blog_archive_layout', 'right-sidebar' );
			if ( 'right-sidebar' === $blog_layout ) :
				$class = 'edublink-col-lg-4';
			elseif ( 'left-sidebar' === $blog_layout ) :
				$class = 'edublink-col-lg-4 edublink-order-1';
			elseif ( 'no-sidebar' === $blog_layout ) :
				$class = '';
			endif;
		endif;

		if ( is_single() ) :
			$single_layout = edublink_set_value( 'blog_single_layout', 'right-sidebar' );
			if ( 'right-sidebar' === $single_layout ) :
				$class = 'edublink-col-lg-4';
			elseif ( 'left-sidebar' === $single_layout ) :
				$class = 'edublink-col-lg-4 edublink-order-1';
			elseif ( 'no-sidebar' === $single_layout ) :
				$class = '';
			endif;
		endif;

		if ( is_page() ) :
			$content_type = get_post_meta( get_the_ID(), 'edublink_page_content_type', true );
			if ( 'right-sidebar' === $content_type ) :
				$class = 'edublink-col-lg-4';
			elseif ( 'left-sidebar' === $content_type ) :
				$class = 'edublink-col-lg-4 edublink-order-1';
			elseif ( 'no-sidebar' === $content_type ) :
				$class = '';
			endif;
		endif;
		
		return $class;
	}
endif;

/**
 * Sidebar Name
 *
 * @since 1.0.0
 */
add_filter( 'edublink_get_sidebar', 'edublink_sidebar_name' );
if ( ! function_exists( 'edublink_sidebar_name' ) ) :
	function edublink_sidebar_name ( $sidebar_layout ) {
		if ( edublink_is_blog() ) :
			$sidebar_layout = edublink_set_value( 'blog_archive_sidebar_name', 'blog-sidebar' );
		endif;
		if ( is_single() ) :
			$sidebar_layout = edublink_set_value( 'blog_single_sidebar_name', 'blog-sidebar' );
		endif;
		if ( is_page() ) :
			$sidebar_layout  = get_post_meta( get_the_ID(), 'edublink_page_sidebar_name', true );
		endif;
		return $sidebar_layout;
	}
endif;

/**
 *  page footer wrapper class
 *  action located at content-page.php
 *
 * @since 1.0.0
 */
add_action( 'edublink_page_footer_wrapper_class', 'edublink_page_footer_wrapper_class_setup' );
if ( ! function_exists( 'edublink_page_footer_wrapper_class_setup' ) ) :
	function edublink_page_footer_wrapper_class_setup(){
		$class = '';		
		if ( is_page() ) :
			$content_type = 'boxed';

			if ( $content_type && $content_type == 'boxed' ) :
				$class = '';
			else :
				$class = ' edublink-container';
			endif;
		endif;

		echo esc_attr( $class );
	}
endif;

/**
 *  Author bio
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_author_bio' ) ) :
	function edublink_author_bio() {
		$description 	= get_the_author_meta( 'description' );

		if ( ! empty( $description ) ) :
			echo '<div class="edublink-author-bio">';
				echo '<div class="edublink-author-thumb">';
				    echo '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'edublink_author_thumb_size', 200 ) ) . '</a>';
				echo '</div>';

				echo '<div class="edublink-author-details">';
				    echo '<h5><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></h5>';

					echo '<div class="edublink-author-info">';
				    	echo wpautop( wp_kses_post( $description ) );
					echo '</div>';

					echo '<div class="edublink-editor-social-info">';
						edublink_user_social_icons( get_the_author_meta( 'ID' ) );
					echo '</div>';
				echo '</div>';
			echo '</div>';	    
		endif;
	}
endif;

/**
 * Link Pages Bootstrap
 * @author toscha
 * @link http://wordpress.stackexchange.com/questions/14406/how-to-style-current-page-number-wp-link-pages
 * @param  array $args
 * @return void
 * Modification of wp_link_pages() with an extra element to highlight the current page.
 */

if ( ! function_exists( 'edublink_link_pages' ) ):
	function edublink_link_pages( $args = array () ) {
	    $defaults = array(
			'before'         => '<nav class="edublink-paignation"><ul class="edublink-custom-pagination">',
			'after'          => '</ul></nav>',
			'before_link'    => '<li>',
			'after_link'     => '</li>',
			'current_before' => '<li class="active">',
			'current_after'  => '</li>',
			'link_before'    => '',
			'link_after'     => '',
			'pagelink'       => '%',
			'echo'           => 1
	    );
	    $r = wp_parse_args( $args, $defaults );
	    $r = apply_filters( 'wp_link_pages_args', $r );
	    extract( $r, EXTR_SKIP );

	    global $page, $numpages, $multipage, $more, $pagenow;
	    if ( ! $multipage ) :
	        return;
	    endif;

	    $output = $before;
	    for ( $i = 1; $i < ( $numpages + 1 ); $i++ ) :
	        $j       = str_replace( '%', $i, $pagelink );
	        $output .= ' ';
	        if ( $i != $page || ( ! $more && 1 == $page ) ) :
	            $output .= "{$before_link}" . _wp_link_page( $i ) . "{$link_before}{$j}{$link_after}</a>{$after_link}";
	        else :
	            $output .= "{$current_before}{$link_before}<span>{$j}</span>{$link_after}{$current_after}";
	        endif;
	    endfor;
	    print wp_kses_post( $output ) . wp_kses_post( $after );
	}
endif;


/**
 * WordPress Bootstrap pagination
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_numeric_pagination' ) ) :
    function edublink_numeric_pagination( $args = array() ) {
        
        $defaults = array(
            'range'           => 4,
            'custom_query'    => FALSE,
            'previous_string' => '<span class="edublink-pagination-icon icon-west"></span>',
            'next_string'     => '<span class="edublink-pagination-icon icon-east"></span>',
            'before_output'   => '<nav class="edublink-pagination-wrapper"><ul class="page-number">',
            'after_output'    => '</ul></nav>'
        );
        
        $args = wp_parse_args( 
            $args, 
            apply_filters( 'wp_bootstrap_pagination_defaults', $defaults )
        );
        
        $args['range'] = (int) $args['range'] - 1;
        if ( !$args['custom_query'] )
            $args['custom_query'] = $GLOBALS['wp_query'];
        $count = (int) $args['custom_query']->max_num_pages;
        $page  = intval( get_query_var( 'paged' ) );
        $ceil  = ceil( $args['range'] / 2 );
        
        if ( $count <= 1 )
            return FALSE;
        
        if ( !$page )
            $page = 1;
        
        if ( $count > $args['range'] ) :
            if ( $page <= $args['range'] ) :
                $min = 1;
                $max = $args['range'] + 1;
            elseif ( $page >= ($count - $ceil) ) :
                $min = $count - $args['range'];
                $max = $count;
            elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) :
                $min = $page - $ceil;
                $max = $page + $ceil;
            endif;
        else :
            $min = 1;
            $max = $count;
        endif;
        
        $echo = '';
        $previous = intval($page) - 1;
        $previous = esc_attr( get_pagenum_link($previous) );
        
        if ( $previous && (1 != $page) )
        	$echo .= sprintf ( '<li><a class="page-numbers" href="%s" title="%s">%s</a></li>', esc_url( $previous ), __( 'previous', 'edublink' ), $args['previous_string'] );
        
        if ( ! empty( $min ) && ! empty( $max ) ) :
            for( $i = $min; $i <= $max; $i++ ) :
                if ( $page == $i ) :
                    $echo .= sprintf ( '<li class="active"><span class="page-numbers current">%s</span></li>', esc_html( (int)$i ) );
                else :
                    $echo .= sprintf( '<li><a class="page-numbers" href="%s">%2d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
                endif;
            endfor;
        endif;
        
        $next = intval($page) + 1;
        $next = esc_attr( get_pagenum_link( $next ) );
        if ($next && ($count != $page) )
        	$echo .= sprintf ( '<li><a class="page-numbers" href="%s" title="%s">%s</a></li>', esc_url( $next ), __( 'next', 'edublink' ), $args['next_string'] );
        
        if ( isset($echo) )
            echo wp_kses_post( $args['before_output'] ) . $echo . wp_kses_post( $args['after_output'] );
    }
endif;

/**
 * Pagination RTL support
 *
 * @since 1.0.0
 */

add_filter( 'wp_bootstrap_pagination_defaults', 'edublink_pagination_rtl_support' );

if ( ! function_exists( 'edublink_pagination_rtl_support' ) ) :
	function edublink_pagination_rtl_support($args) {
	  	if ( is_rtl() ) :
		   $args['next_string']   = '<span class="edublink-pagination-icon icon-west"></span>';
		   $args['previous_string']  = '<span class="edublink-pagination-icon icon-east"></span>';
		endif;
		return $args;
	}
endif;


/**
 * Comment list walker
 * A custom WordPress comment walker class to implement the Bootstrap 3 Media object in wordpress comment list.
 * @package     WP Bootstrap Comment Walker
 * @version     1.0.0
 * @author      Edi Amin <to.ediamin@gmail.com>
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link        https://github.com/ediamin/wp-bootstrap-comment-walker
 */

if ( ! class_exists( 'EduBlink_Comment_Walker' ) ) :
	class EduBlink_Comment_Walker extends Walker_Comment {
		/**
		 * Output a comment in the HTML5 format.
		 *
		 * @access protected
		 * @since 1.0.0
		 *
		 * @see wp_list_comments()
		 *
		 * @param object $comment Comment to display.
		 * @param int    $depth   Depth of comment.
		 * @param array  $args    An array of arguments.
		 */
		protected function html5_comment( $comment, $depth, $args ) {
			$tag       = ( 'div' === $args['style'] ) ? 'div' : 'li';
			$commenter = wp_get_current_commenter();
		    if ( $commenter['comment_author_email'] ) :
		        $moderation_note = __( 'Your comment is awaiting moderation.', 'edublink' );
		    else :
		        $moderation_note = __( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.', 'edublink' );
		    endif;
			?>		
			<<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent edublink-media edublink-comment-item' : 'edublink-media edublink-comment-item' ); ?>>

			<article id="comment-<?php comment_ID(); ?>" class="edublink-single-comment <?php echo esc_attr( get_avatar($comment) ? 'edublink-comment-has-avatar' : 'edublink-comment-no-avatar' ); ?>">
				<div class="edublink-comment-each-item">
					<?php if ( get_avatar( $comment ) && 0 != $args['avatar_size'] ): ?>
						<div class="edublink-comment-avatar">
							<a href="<?php echo esc_url( esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ); ?>" class="edublink-media-object">
								<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="edublink-media-body">
						<div class="edublink-comment-header">
							<h4 class="edublink-media-heading">
								<?php echo get_comment_author_link(); ?>
							</h4>
							<span class="comment-metadata">
								<a class="edublink-comment-time" href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
									<time datetime="<?php esc_attr( comment_time( 'c' ) ); ?>">
										<?php 
											printf(
												__( '%1$s at %2$s', 'edublink' ), get_comment_date(), get_comment_time()
											);

											edit_comment_link( __( '(Edit)', 'edublink' ), '  ', '' );
										?>
									</time>
								</a>
							</span>
						</div>						

						<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation label label-info"><?php echo esc_html( $moderation_note ); ?></p>
						<?php endif; ?>

						<div class="comment-content">
							<?php comment_text(); ?>
						</div>
						
						<div class="edublink-comment-bottom-part">
							<?php 
								echo get_comment_reply_link(
									array(
										'depth'      => $depth,
										'max_depth'  => $args['max_depth'],
										'reply_text' => sprintf( '<i class="ri-reply-all-line"></i> %s', __( 'Reply', 'edublink' ) )
									),
									$comment->comment_ID,
									$comment->comment_post_ID
								);
							?>
						</div>	
					</div>	
				</div>
			</article>	
			<?php
		}	
	}
endif;

/**
 * Custom list of comments for the theme.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_comments_template' ) ) :
	function edublink_comments_template() {
		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$args     = array(
			'class_form'         => 'edublink-comment-form form media-body',
			'class_submit'       => 'edublink-comment-btn',
			'title_reply_before' => '<h3 class="edublink-title">',
			'title_reply'		 => __( 'Leave a Reply', 'edublink' ),
			'label_submit'		 => __( 'Post A Comment', 'edublink' ),
			'title_reply_after'  => '</h3>',
			'must_log_in'        => '<p class="must-log-in">' .
									sprintf(
										wp_kses(
											/* translators: %s is Link to login */
											__( 'You must be <a href="%s">logged in</a> to post a comment.', 'edublink' ), array(
												'a' => array(
													'href' => array()
												)
											)
										), esc_url( wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) )
									) . '</p>',
			'fields'             => 
			apply_filters(
				'comment_form_default_fields', array(

					'author' => '<div class="edublink-row"><div class="edublink-col-md-6 "><div class="form-group edublink-comment-field label-floating is-empty"><input id="author" name="author" class="form-control" type="text"' . $aria_req . ' placeholder="' . __( 'Name', 'edublink' ) . ( $req ? '*' : '' ) . '" /></div></div>',

					'email'  => '<div class="edublink-col-md-6"><div class="form-group edublink-comment-field label-floating is-empty"><input id="email" name="email" class="form-control" type="email"' . $aria_req . ' placeholder="' . __( 'Email', 'edublink' ) . ( $req ? '*' : '' ) . '" /></div></div>',

					'url'    => '<div class="edublink-col-lg-12"><div class="form-group edublink-comment-field label-floating is-empty"><input id="url" name="url" class="form-control" type="url"' . $aria_req . ' placeholder="' . __( 'Website', 'edublink' ) .'" /></div></div> </div>',
				)
			),
			'comment_field'      => '<div class="form-group edublink-comment-field label-floating is-empty"><textarea rows="8" id="comment" name="comment" class="form-control" cols="20" aria-required="true"  placeholder="' . __( 'Comment', 'edublink' ) .'"></textarea></div>'
		);

		return $args;
	}
endif;

/**
 * Custom form
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_hidden_comment_form' ) ) :
	function edublink_hidden_comment_form( $arg ) {
		global $post;
		if ( 'open' == $post->comment_status ) :
			ob_start();
	      	comment_form( $arg );
	      	$form = ob_get_clean();

			echo '<div class="comment-comment-form-hidden">';
				echo str_replace( 'id="commentform"', 'id="commentform" enctype="multipart/form-data"', $form );
			echo '</div>';
		endif;
	}
endif;

/**
 * Move Comment Field & Cookie Consent to Bottom
 *
 * @since 1.0.0
 */
function edublink_move_comment_field_to_bottom( $fields ) {
    $comment_field = $fields['comment'];
	if ( isset( $fields['cookies'] ) ) :
    	$cookies_field = $fields['cookies'];
	endif;

    unset( $fields['comment'] );
	if ( isset( $fields['cookies'] ) ) :
    	unset( $fields['cookies'] );
	endif;
	
	$fields['comment'] = $comment_field;

	if ( isset( $fields['cookies'] ) ) :
    	$fields['cookies'] = $cookies_field;
	endif;
    return $fields;
}
add_filter( 'comment_form_fields', 'edublink_move_comment_field_to_bottom' );

/**
 *  Body Classes
 *
 * @since 1.0.0
 */
add_filter( 'body_class', 'edublink_get_body_classes' );

if ( ! function_exists( 'edublink_get_body_classes' ) ) :
	function edublink_get_body_classes( $classes ) {
		global $post;
		if ( is_page() && is_object( $post ) ) :
			$classes[]                 = 'edublink-page-content';
			$page_layout               = get_post_meta( get_the_ID(), 'edublink_page_layout_type', true );
			$content_type              = get_post_meta( get_the_ID(), 'edublink_page_content_type', true );
			$breadcrumb_visibility     = get_post_meta( get_the_ID(), 'edublink_page_breadcrumb', true );
			$breadcrumb_show_framework = edublink_set_value( 'show_page_breadcrumb', true );

			if( get_post_meta( $post->ID, 'edublink_page_header_transparent', true ) && get_post_meta( $post->ID, 'edublink_page_header_transparent', true ) == 'enable' ) :
				$classes[] = 'edublink-header-transparent-enable';
			endif;

			if ( ! is_front_page() ) :
				if ( 'disable' !== $breadcrumb_visibility ) :
					if ( ( 'enable' === $breadcrumb_visibility ) || ( isset( $breadcrumb_show_framework ) && ! empty( $breadcrumb_show_framework ) ) ) :
						$classes[] = 'edublink-page-breadcrumb-enable';
					else :
						$classes[] = 'edublink-page-breadcrumb-disable';
					endif;
				else :
					$classes[] = 'edublink-page-breadcrumb-disable';
				endif;
			else :
				$classes[] = 'edublink-page-breadcrumb-disable';
			endif;

			if ( 'full-width' === $page_layout ) :
				$classes[] = 'edublink-page-fullwidth';
			else :
				$classes[] = 'edublink-page-boxed';
			endif;

			if ( isset( $content_type ) && ! empty( $content_type ) ) :
				if ( 'no-sidebar' === $content_type ) :
					$classes[] = 'edublink-page-sidebar-disable';
				else :
					$classes[] = 'edublink-page-sidebar-enable';
				endif;
			else :
				$classes[] = 'edublink-page-sidebar-disable';
			endif;

			$extra_class = get_post_meta( $post->ID, 'edublink_page_extra_class', true );

			if ( ! empty( $extra_class ) ) :
				$classes[] = trim( $extra_class );
			endif;

		elseif ( is_singular() || is_category() || is_tax() || is_home() || is_search() || edublink_is_blog() ) :
			$show = edublink_set_value( 'show_blog_breadcrumb', true );
			if ( ! $show ) :
				$classes[] = 'edublink-page-breadcrumb-disable';
			endif;

		elseif ( is_singular( 'tp_event' ) || is_post_type_archive( 'tp_event' ) || is_tax( 'tp_event_category' )  || is_tax( 'tp_event_tags' ) ) :
			$show = edublink_set_value( 'tp_event_show_breadcrumb', true );
			if ( ! $show ) :
				$classes[] = 'edublink-page-breadcrumb-disable';
			endif;
			
		elseif ( edublink_is_woocommerce_activated() && is_woocommerce() ) :
			$show = edublink_set_value( 'show_shop_breadcrumb', true );
			if ( ! $show ) :
				$classes[] = 'edublink-page-breadcrumb-disable';
			endif;
    	endif;

	    return $classes;
	}
endif;

/**
 * Header Extra Class
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_header_classes' ) ) :
	function edublink_header_classes( $classes ) {
		global $post;
		if ( is_page() && is_object( $post ) ) :
			$header_color_white = get_post_meta( get_the_ID(), 'edublink_page_header_color_white', true );
			$header_transparent = get_post_meta( get_the_ID(), 'edublink_page_header_transparent', true );
			$header_white_logo_status = get_post_meta( get_the_ID(), 'edublink_page_header_white_logo_status', true );
			$header_sticky = get_post_meta( get_the_ID(), 'edublink_page_header_sticky', true );
			// $extra_class = get_post_meta( $post->ID, 'edublink_page_extra_class', true );
			$white_logo = edublink_set_value( 'header_white_logo' );

			if ( 'enable' === $header_color_white ) :
				$classes[] = 'header-color-white';
			endif;

			if ( 'enable' === $header_transparent && 'enable' === $header_white_logo_status && isset( $white_logo['url'] ) && ! empty( $white_logo['url'] ) ) :
				$classes[] = 'white-logo-enable';
			endif;

			if ( 'enable' === $header_sticky && ! in_array( 'header-get-sticky', $classes ) ) :
				$classes[] = 'header-get-sticky';
			endif;

			// if ( ! empty( $extra_class ) ) :
			// 	$classes[] = trim( $extra_class );
			// endif;
		endif;
		return $classes;
	}
endif;
add_filter( 'edublink_header_class_array', 'edublink_header_classes' );

/**
 * Event Google Map API
 *
 * @since 1.0.0
 */
function edublink_event_map_api_key( $key ) {
    $key = edublink_set_value( 'tp_single_event_google_map_api_key' );
    return $key;
}
add_filter( 'edublink_map_api_key', 'edublink_event_map_api_key' );

/**
 * EduBlink Supported LMS Builders
 *
 * @return boolean
 */
function edublink_is_lms_courses() {
	if ( ( function_exists( 'edublink_is_lp_courses' ) && edublink_is_lp_courses() ) || is_singular( 'lp_course' ) || is_post_type_archive( 'lp_course' ) || is_tax( 'course_category' ) || is_tax( 'course_tag' ) ) : 
		return true;
	elseif ( is_singular( 'courses' ) || is_post_type_archive( 'courses' ) || is_tax( 'course-category' ) || is_tax( 'course-tag' ) ) :
		return true;
	elseif ( is_singular( 'sfwd-courses' ) || is_post_type_archive( 'sfwd-courses' ) || is_tax( 'ld_course_category' ) || is_tax( 'ld_course_tag' ) ) :
		return true;
    endif;
    return false;

}

/**
 * EduBlink Supported LMS Builders Course Details Page
 *
 * @return boolean
 */
function edublink_is_lms_course_details() {
	if ( is_singular( 'lp_course' ) ) : 
		// LearnPress
		return true;
	elseif ( is_singular( 'courses' ) ) :
		// Tutor LMS
		return true;
	elseif ( is_singular( 'course' ) ) :
		// Lifter Lms & Sensei LMS
		return true;
	elseif ( is_singular( 'stm-courses' ) || is_page( 'user-public-account' ) || is_page( 'enrolled-courses' ) || is_page( 'user-account' ) ) :
		// Masterstudy
		return true;
	elseif ( is_singular( 'sfwd-courses' ) ) :
		// LearnDash
		return true;
    endif;

    return apply_filters( 'edublink_page_without_breadcrumb', false );
}

/**
 * Course Ajax Search
 */
add_action( 'wp_ajax_nopriv_edublink_ajax_course_search', 'edublink_ajax_course_search' );
add_action( 'wp_ajax_edublink_ajax_course_search', 'edublink_ajax_course_search' );

if ( ! function_exists( 'edublink_ajax_course_search' ) ) :
	function edublink_ajax_course_search() {
		$args = array (
			'post_type' 	 => apply_filters( 'edublink_course_search_post_type', LP_COURSE_CPT ),
			'post_status' 	 => 'publish',
			'order' 		 => 'DESC',
			'orderby' 		 => 'date',
			's' 			 => $_POST['term'],
			'posts_per_page' => apply_filters( 'edublink_course_search_number_of_post', 10 )
		);
		 
		$query = new WP_Query( $args );
		 
		if ( $query->have_posts() ) :
			echo '<ul>';
				while ( $query->have_posts() ) :
					$query->the_post();
					printf( '<li><a href="%s">%s</a></li>', esc_url( get_the_permalink() ), esc_html( get_the_title() ) );
				endwhile;
			echo '</ul>';
		else :
			printf( '<ul><li>%s</li></ul>', __( 'Sorry, No Course Found.', 'edublink' ) );
		endif;

		wp_reset_postdata();
		exit;
	}
endif;

// Define home url for ajax course search
if ( ! function_exists( 'edublink_ajax_course_search_base' ) ) :
	function edublink_ajax_course_search_base(){
		?>
			<script type="text/javascript">var edublink_home_url = "<?php echo esc_url( home_url() ); ?>";</script>
		<?php
	}
endif;
add_action( 'wp_footer', 'edublink_ajax_course_search_base' );

/**
 *  Add Preloader Class at Body Classes
 *
 * @since 1.0.0
 */
add_filter( 'body_class', 'edublink_add_preloader_class_at_body' );

if ( ! function_exists( 'edublink_add_preloader_class_at_body' ) ) :
	function edublink_add_preloader_class_at_body( $classes ) {
		if ( edublink_set_value( 'preloader', false ) ) :
			$preloader_type = edublink_set_value( 'preloader_type', '1' );
			$classes[] = 'edublink-preloader-type-' . $preloader_type;
		endif;

		if ( edublink_set_value( 'eb_dark_mode', false ) ) :
			$classes[] = 'edublink-dark';
		endif;
		
		$theme_prefix = 'edub';
		$theme_suffix = 'link';
		$classes[] = 'theme-name-' . $theme_prefix . $theme_suffix;
		return $classes;
	}
endif;

/**
 *  Single Post Support With Header & Footer Blank
 *	return array of post_types
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_header_footer_blank_single_post_array' ) ) :
	function edublink_header_footer_blank_single_post_array() {
		$supported_array = apply_filters( 'edublink_header_footer_blank_post_array', [
			'edublink_header', 
			'edublink_footer', 
			'edublink_megamenu', 
			'elementor_library' 
		] );
		return $supported_array;
	}
endif;

/**
 * Estimated Reading Time
 *
 * @return void
 */
if( ! function_exists( 'edublink_post_estimated_reading_time' ) ) :
	function edublink_post_estimated_reading_time( $with_second = false ) {
		global $post;
		$words_per_min = apply_filters( 'edublink_words_read_per_min', 200 );
		// get the content
		$the_content = $post->post_content;
		// count the number of words
		$words = str_word_count( strip_tags( $the_content ) );
		// rounding off and deviding per 200( $words_per_min ) words per minute
		$minute = floor( $words / $words_per_min );
		// rounding off to get the seconds
		$second = floor( $words % $words_per_min / ( $words_per_min / 60 ) );
		// calculate the amount of time needed to read

		$estimate = $minute . ' ' . __( 'Min', 'edublink' ) . ( $minute == 1 ? '' : __( 's', 'edublink' ) );

		if ( $minute < 1 ) :
			$estimate = $second . ' ' . __( 'Sec', 'edublink' ) . ( $second == 1 ? '' : __( 's', 'edublink' ) );
		endif;

		if ( $with_second ) :
			$estimate = $minute . ' ' . __( 'Min', 'edublink' ) . ( $minute == 1 ? '' : __( 's', 'edublink' ) ) . ', ' . $second . ' ' . __( 'Sec', 'edublink' ) . ( $second == 1 ? '' : __( 's', 'edublink' ) );
		endif;
		
		return $estimate;
	}
endif;

/**
 * return all the thumb sizes
 *
 * @return void
 */
function edublink_available_thumb_size() {
	$image_sizes = get_intermediate_image_sizes();
	$additional_sizes = array(
		__( 'Full size', 'edublink' ) => 'full'
	);

	$newsizes = array_merge( $image_sizes, $additional_sizes );
	return apply_filters( 'edublink_thumb_size_filter', array_combine( $newsizes, $newsizes ) );
}

/**
 * add title after image at zoom details page
 */
// Left Section Single Content( with heading )
add_action( 'vczoom_single_content_left', 'edublink_video_conference_zoom_heading', 15 );
if( ! function_exists( 'edublink_video_conference_zoom_heading' ) ) :
	function edublink_video_conference_zoom_heading() {
		echo '<div class="eb-zoom-details-page-heading">';
			echo '<h3 class="title">' . wp_kses_post( get_the_title() ) . '</h3>';
		echo '</div>';
	}
endif;

// Left Section Single Content( with heading )
if( ! function_exists( 'edublink_vczapi_html_after_meeting_details' ) ) :
	function edublink_vczapi_html_after_meeting_details() {
		$extra_meta = get_post_meta( get_the_ID(), 'edublink_zoom_extra_meta_fields', true ); 
		// var_dump($extra_meta);
		if ( isset( $extra_meta ) && is_array( $extra_meta ) ) :
			foreach ( $extra_meta as $key => $meta ) :
				if ( $meta['label'] ) :
					$wrapper_class = '';
					if ( isset( $meta['wrapper_class'] ) && ! empty( $meta['wrapper_class'] ) ) :
						$wrapper_class = ' ' . $meta['wrapper_class'];
					endif;

					echo '<div class="dpn-zvc-sidebar-content-list' . esc_attr( $wrapper_class ) . '">';
						echo '<span class="label">';
							echo $meta['label'] ? '<strong>' . esc_html( $meta['label'] ) . '</strong>' : '';
						echo '</span>';

						echo $meta['value'] ? ' <span class="vczapi-single-meeting-value">' . esc_html( $meta['value'] ) . '</span>' : '';
					echo '</div>';
				endif;
			endforeach;
		endif;
	}
endif;

add_action( 'vczapi_html_after_meeting_details', 'edublink_vczapi_html_after_meeting_details' );

/**
 * number of event items in event archive
 */
if( ! function_exists( 'edublink_tp_event_archive_items' ) ) :
	function edublink_tp_event_archive_items( $query ) {
		$items = edublink_set_value( 'tp_event_archive_page_items' ) ? edublink_set_value( 'tp_event_archive_page_items' ) : 6;
		if ( $query->is_main_query() && ! is_admin() && ( is_post_type_archive( 'tp_event' ) || is_tax( 'tp_event_category' ) ) ) :
			$query->set( 'posts_per_page', $items );
		endif;
	}
endif;
add_action( 'pre_get_posts', 'edublink_tp_event_archive_items' );


/**
 * Course Details 
 * Header Style 6 Shapes
 *
 */
if( ! function_exists( 'edublink_course_breadcrumb_header_6_shapes' ) ) :
	function edublink_course_breadcrumb_header_6_shapes() {
		$status = apply_filters( 'edublink_breadcrumb_shape', true );

		if ( $status ) :
			echo '<div class="shape-dot-wrapper shape-wrapper edublink-d-xl-block edublink-d-none">';
				echo '<div class="shape-image eb-mouse-animation shape-a">';
					echo '<span data-depth="2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-1.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';

				echo '<div class="shape-image shape-b">';
					echo '<span>';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-4.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';

				echo '<div class="shape-image eb-mouse-animation shape-c">';
					echo '<span data-depth="2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-5.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';

				echo '<div class="shape-image eb-mouse-animation shape-d">';
					echo '<span data-depth="-2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-6.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';
			echo '</div>';
		endif;
	}
endif;

/**
 * Required Plugins
 */
add_action( 'tgmpa_register', 'edublink_load_required_plugins' );

if( ! function_exists( 'edublink_load_required_plugins' ) ) :
	function edublink_load_required_plugins() {

		$plugins = array(
			array(
				'name'      => __( 'Classic Editor', 'edublink' ),
				'slug'      => 'classic-editor',
				'required'  => false
			),
			array(
				'name'      => __( 'CMB2', 'edublink' ),
				'slug'      => 'cmb2',
				'required'  => true
			),
			array(
				'name'      => __( 'Contact Form 7', 'edublink' ),
				'slug'      => 'contact-form-7',
				'required'  => false
			),
			array(
				'name'      => __( 'EduBlink Core', 'edublink' ),
				'slug'      => 'edublink-core',
				'source'    => get_template_directory() . '/lib/plugins/edublink-core.zip',
				'required'  => true,
				'version'   => '1.0.0'
			),
			array(
				'name'      => __( 'Elementor', 'edublink' ),
				'slug'      => 'elementor',
				'required'  => true
			),
			array(
				'name'      => __( 'One Click Demo Import', 'edublink' ),
				'slug'      => 'one-click-demo-import',
				'required'  => false
			),
			array(
				'name'      => __( 'Safe SVG', 'edublink' ),
				'slug'      => 'safe-svg',
				'required'  => false
			),
			array(
				'name'      => __( 'WP Events Manager', 'edublink' ),
				'slug'      => 'wp-events-manager',
				'required'  => false
			),
			array(
				'name'      => __( 'YITH WooCommerce Quick View', 'edublink' ),
				'slug'      => 'yith-woocommerce-quick-view',
				'required'  => false
			),
			array(
				'name'      => __( 'Redux Framework', 'edublink' ),
				'slug'      => 'redux-framework',
				'required'  => true
			),
			array(
				'name'      => __( 'Video Conferencing with Zoom', 'edublink' ),
				'slug'      => 'video-conferencing-with-zoom-api',
				'required'  => false
			),
			array(
				'name'      => __( 'WooCommerce', 'edublink' ),
				'slug'      => 'woocommerce',
				'required'  => false
			)
		);

		tgmpa( $plugins );
	}
endif;
