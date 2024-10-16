<?php

require_once get_template_directory() . '/stm-lms-templates/custom/helper-class.php';
use \EduBlink\Filter;

/**
 * Course Details Page Wrapper
 */
add_filter( 'stm_lms_wrapper_classes', 'edublink_ms_course_details_wrapper_class' );
if ( ! function_exists( 'edublink_ms_course_details_wrapper_class' ) ) :
	function edublink_ms_course_details_wrapper_class( $class ) {
		if ( is_singular( 'stm-courses' ) ) :
			$class = 'stm-lms-wrappe eb-ms-course-single-wrapper';
		endif;
		return $class;
	}
endif;

/**
 * Course Search Post Type
 */
add_filter( 'edublink_course_search_post_type', 'edublink_ms_course_search_post_type' );
if ( ! function_exists( 'edublink_ms_course_search_post_type' ) ) :
	function edublink_ms_course_search_post_type() {
		return 'stm-courses';
	}
endif;

/**
 * MasterStudy specific scripts & stylesheets.
 *
 * @return void
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_ms_scripts' ) ) :
	function edublink_ms_scripts() {
		$dependency = array();
		$dependency = apply_filters( 'edublink_masterstudy_css_dependency', $dependency );
		$handler = apply_filters( 'edublink_masterstudy_css_handler', 'edublink-ms-style' );
		wp_enqueue_style( $handler, get_template_directory_uri() . '/assets/css/masterstudy.css', $dependency, EDUBLINK_THEME_VERSION );

		if ( is_singular( 'stm-courses' ) ) :
			wp_enqueue_style( 'jquery-fancybox' );
			wp_enqueue_script( 'jquery-fancybox' );
		endif;
	}
endif;
add_action( 'wp_enqueue_scripts', 'edublink_ms_scripts' );

/**
 * post_class extends for MasterStudy courses
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_masterstudy_course_class' ) ) :
    function edublink_masterstudy_course_class( $default = array() ) {
		$terms      = get_the_terms( get_the_ID(), 'stm_lms_course_taxonomy' );
		$terms_html = array();
		if ( $terms ) :
			foreach ( $terms as $term ) :
				$terms_html[] = $term->slug;
			endforeach;
		endif;
		$ams_classes = array_merge( $terms_html, $default );
		$classes     = apply_filters( 'edublink_masterstudy_course_class', $ams_classes );
        post_class( $classes );
    }
endif;

add_action( 'pre_get_posts', 'edublink_ms_custom_query_for_author' );
if ( ! function_exists( 'edublink_ms_custom_query_for_author' ) ) :
	function edublink_ms_custom_query_for_author( $query ) {
		$author_redirect_to_courses = apply_filters( 'ms_author_course_archive', true );
	    if ( is_admin() || ! $query->is_main_query() ) :
	        return;
		endif;
		if ( isset( $_GET['msauthor'] ) ) :
			$msauthor = $_GET['msauthor'];
		else :
			$msauthor = false;
		endif;
		if ( is_author() && ( 'true' == $msauthor ) && ( true == $author_redirect_to_courses ) ) :
	        $query->set( 'post_type' , array( 'stm-courses' ) );
	    endif;
	}
endif;

/**
 * Content area class for Author( As Instructor ) Archive
 */
add_filter( 'edublink_content_area_class', 'edublink_ms_author_archive_content_area_class' );

if ( ! function_exists( 'edublink_ms_author_archive_content_area_class' ) ) :
	function edublink_ms_author_archive_content_area_class ( $class ) {
		$author_redirect_to_courses = apply_filters( 'ms_author_course_archive', true );
		if ( isset( $_GET['msauthor'] ) ) :
			$msauthor = $_GET['msauthor'];
		else :
			$msauthor = false;
		endif;
		if ( true == $author_redirect_to_courses && 'true' == $msauthor ) :
			$class = 'edublink-col-lg-12';
		endif;

		return $class;
	}
endif;

/**
 * Header Course Category Slug
 */
add_filter( 'edublink_header_course_lms_cat_slug', 'edublink_header_course_ms_cat_slug' );
if ( ! function_exists( 'edublink_header_course_ms_cat_slug' ) ) :
	function edublink_header_course_ms_cat_slug() {
		return 'stm_lms_course_taxonomy';
	}
endif;

/**
 * Right Side Course Preview
 */
if ( ! function_exists( 'edublink_ms_course_preview' ) ) :
	function edublink_ms_course_preview() {
		$preview_video = get_post_meta( get_the_ID(), 'edublink_ms_course_preview_video_link', true );
		$preview_image = get_post_meta( get_the_ID(), 'edublink_ms_course_preview_image', true );
		$video_status = edublink_set_value( 'ms_course_preview_video_popup', true );

		if ( empty( $preview_image ) ) :
			$preview_image = apply_filters( 'edublink_ms_course_default_preview_image', esc_url( get_template_directory_uri() . '/assets/images/course-preview.jpg' ) );
		endif;
		echo '<div class="edublink-course-details-card-preview" style="background-image: url(' . esc_url( $preview_image ) . ')">';
			if ( $video_status ) :
				echo '<div class="edublink-course-video-preview-area">';
					if ( ! empty( $preview_video ) ) :
						echo '<a data-fancybox href="' . esc_url( $preview_video ) . '" class="edublink-course-video-popup">';
							echo '<i class="icon-18"></i>';
						echo '</a>';
					endif;
				echo '</div>';
			endif;
		echo '</div>';
	}
endif;

/**
 * MasterStudy Course Details Header
 *
 */
if( ! function_exists( 'edublink_ms_course_details_header' ) ) :
	function edublink_ms_course_details_header( $style ) {
		switch ( $style ):
			case 1:
				edublink_ms_course_details_header_default_style();
				break;
			case 2:
				edublink_ms_course_details_header_default_style( 'dark-version' );
				break;
			case 3:
				edublink_ms_course_details_header_default_style();
				break;
			case 4:
				edublink_ms_course_details_header_style_2();
				break;
			case 5:
				edublink_ms_course_details_header_default_style( 'style-5' );
				break;
			case 6:
				edublink_ms_course_details_header_default_style( 'style-6' );
				break;
			default:
			edublink_ms_course_details_header_default_style();
		endswitch;
	}
endif;

/**
 * MasterStudy Course Details Header Default Style
 *
 */
if( ! function_exists( 'edublink_ms_course_details_header_default_style' ) ) :
	function edublink_ms_course_details_header_default_style( $style = null ) {
		$style = $style ? ' ' . esc_attr( $style ) : '';
		echo '<div class="edublink-course-page-header' . esc_attr( $style ) . '">';
			echo '<div class="eb-course-header-breadcrumb">';
				echo '<div class="' . esc_attr( apply_filters( 'edublink_breadcrumb_container_class', 'edublink-container' ) ) . '">';
					do_action( 'edublink_breadcrumb' );
				echo '</div>';
			echo '</div>';

			echo '<div class="eb-course-header-breadcrumb-content">';
				echo '<div class="' . esc_attr( apply_filters( 'edublink_breadcrumb_container_class', 'edublink-container' ) ) . '">';
					echo '<div class="edublink-course-breadcrumb-inner">';
						echo '<div class="edublink-course-title">';
							echo '<h1 class="entry-title">';
								the_title(); 
							echo '</h1>';
						echo '</div>';
						
						echo '<div class="edublink-course-header-meta">';
							edublink_breadcrumb_ms_course_meta();
						echo '</div>';
					echo '</div>';
				echo '</div>';
				if ( ' style-6' === $style  ) :
					edublink_course_breadcrumb_header_6_shapes();
				endif;
			echo '</div>';
			
			if ( ' style-6' !== $style ) :
				edublink_breadcrumb_shapes();
			endif;
		echo '</div>';
	}
endif;

/**
 * MasterStudy Course Details Header Style 2
 *
 */
if( ! function_exists( 'edublink_ms_course_details_header_style_2' ) ) :
	function edublink_ms_course_details_header_style_2() {
		$has_bg_image = '';
		$breadcrumb_img   = edublink_set_value( 'ms_course_breadcrumb_image' );
		$title = get_the_title();
		$style = array();
		
		if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
			$style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
			$has_bg_image = 'edublink-breadcrumb-has-bg course-header-4';
		else :
			$has_bg_image = 'edublink-breadcrumb-empty-bg course-header-4';
		endif;

		$extra_style = ! empty( $style ) ? ' style="' . implode( "; ", $style ) . '"' : "";

		edublink_breadcrumb_style_1( $title, $has_bg_image, $extra_style );
	}
endif;

/**
 * MasterStudy Course Breaecrumb Meta
 *
 */
if( ! function_exists( 'edublink_breadcrumb_ms_course_meta' ) ) :
	function edublink_breadcrumb_ms_course_meta() {
		global $post;
		$author_id = $post->post_author;
		$category = edublink_category_by_id( get_the_ID(), 'stm_lms_course_taxonomy' );
		$instructor_id = ( ! empty( $instructor_id ) ) ? $instructor_id : get_the_author_meta( 'ID' );
		$author = STM_LMS_User::get_current_user( $instructor_id );
		echo '<ul class="eb-course-header-meta-items">';
			echo '<li class="instructor">';
				echo '<i class="icon-58"></i>';
				echo '<span class="instruct-by">';
					_e( 'By', 'edublink' );
				echo '</span>';
				
				if ( edublink_set_value( 'ms_instructor_linking', true ) ) :
					echo '<a href="' . esc_url( STM_LMS_User::user_public_page_url( $author['id'] ) ) .'"> ';
				endif;
				echo get_the_author_meta( 'display_name', $author_id );

				if ( edublink_set_value( 'ms_instructor_linking', true ) ) :
					echo '</a>';
				endif;
			echo '</li>';

			if ( $category ) :
				echo '<li class="category"><i class="icon-59"></i>' . wp_kses_post( $category ) . '</li>';
			endif;

			echo '<li class="rating">';
				edublink_ms_course_rating( 'text' );
			echo '</li>';
		echo '</ul>';
	}
endif;

/**
 * MasterStudy Course Details 
 * Header Style 6 Shapes
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
 * Right Side Content
 */
if ( ! function_exists( 'edublink_ms_course_content_sidebar' ) ) :
	function edublink_ms_course_content_sidebar() {
		$course_data = apply_filters( 'masterstudy_course_page_header', 'default' );
		$style = edublink_set_value( 'ms_course_details_style', '1' );
		$preview_thumb = edublink_set_value( 'ms_course_preview_thumb', true );
		$button = edublink_set_value( 'ms_course_sidebar_button', true );
		$social_share_status = edublink_set_value( 'ms_course_sidebar_social_share', true );
		$extra_class = $preview_thumb ? 'enable' : 'disable';

		if ( isset( $_GET['course_details'] ) ) :
			$style = in_array( $_GET['course_details'], array( 1, 2, 3, 4, 5, 6 ) ) ? $_GET['course_details'] : 1;
		endif;

		echo '<div class="edublink-course-details-sidebar eb-ld-course-sidebar eb-course-single-' . esc_attr( $style ) . ' sidebar-' . esc_attr( $extra_class ) . '">';
			echo '<div class="edublink-course-details-sidebar-inner">';
				if ( $preview_thumb && '4' != $style ) :
					edublink_ms_course_preview();
				endif;

				echo '<div class="edublink-course-details-sidebar-content">';

					do_action( 'edublink_ms_course_sidebar_before_meta', $course_data );

					edublink_ms_course_meta_data();

					do_action( 'edublink_ms_course_sidebar_after_meta', $course_data );

					STM_LMS_Templates::show_lms_template(
						'components/course/complete',
						array(
							'course_id'     => $course_data['course']->id,
							'user_id'       => $course_data['current_user_id'],
							'settings'      => $course_data['settings'],
							'block_enabled' => true,
						)
					);
					
					if ( ! $course_data['is_coming_soon'] || $course_data['course']->coming_soon_preorder ) {
						?>
						<div class="masterstudy-single-course__cta">
							<?php
							STM_LMS_Templates::show_lms_template(
								'components/buy-button/buy-button',
								array(
									'post_id'              => $course_data['course']->id,
									'item_id'              => '',
									'user_id'              => $course_data['current_user_id'],
									'dark_mode'            => false,
									'prerequisite_preview' => false,
									'hide_group_course'    => false,
								)
							);
							?>
						</div>
						<?php
						STM_LMS_Templates::show_lms_template( 'components/course/money-back', array( 'course' => $course_data['course'] ) );
					}
					if ( $course_data['is_coming_soon'] && $course_data['course']->coming_soon_price && ! $course_data['course']->coming_soon_preorder ) {
						?>
						<div class="masterstudy-single-course__cta">
							<?php STM_LMS_Templates::show_lms_template( 'components/course/coming-button' ); ?>
						</div>
						<?php
					}
					STM_LMS_Templates::show_lms_template(
						'components/course/expired',
						array(
							'course'         => $course_data['course'],
							'user_id'        => $course_data['current_user_id'],
							'is_coming_soon' => $course_data['is_coming_soon'],
						)
					);
					
					if ( $course_data['settings']['course_allow_requirements_info'] ) {
						STM_LMS_Templates::show_lms_template(
							'components/course/info',
							array(
								'course_id' => $course_data['course']->id,
								'content'   => $course_data['course']->requirements,
								'title'     => esc_html__( 'Course requirements', 'edublink' ),
							),
						);
					}
					if ( $course_data['settings']['course_allow_intended_audience'] ) {
						STM_LMS_Templates::show_lms_template(
							'components/course/info',
							array(
								'course_id' => $course_data['course']->id,
								'content'   => $course_data['course']->intended_audience,
								'title'     => esc_html__( 'Intended audience', 'edublink' ),
							),
						);
					}

					do_action( 'edublink_ms_course_sidebar_after_button', $course_data );

					if ( $social_share_status ) :
						$social_heading = edublink_set_value( 'ms_course_sidebar_social_share_heading', __( 'Share On:', 'edublink' ) );
						echo '<div class="edublink-single-event-social-share">';
							echo '<h4 class="share-title">' . esc_html( $social_heading ) . '</h4>';
							get_template_part( 'template-parts/social', 'share' );
						echo '</div>';
					endif;

					do_action( 'edublink_ms_course_sidebar_after_social_share' );
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;


/**
 * Right Side Meta Data
 */
if ( ! function_exists( 'edublink_ms_course_meta_data' ) ) :
	function edublink_ms_course_meta_data() {
		global $post;
		$data = Filter::MS_Data();
		$heading_status = edublink_set_value( 'ms_course_sidebar_heading_status', true );
		$heading = edublink_set_value( 'ms_course_sidebar_heading_text', __( 'Course Includes:', 'edublink') );

		if ( $heading_status && $heading ) :
			echo '<h4 class="widget-title">' . esc_html( $heading ). '</h4>';
		endif;

		echo '<ul class="edublink-course-meta-informations">';
			do_action( 'edublink_ms_course_meta_before' );

			if ( edublink_set_value( 'ms_course_sidebar_price_status', true ) ) :
				$price_label = edublink_set_value( 'ms_course_sidebar_price_label' ) ? edublink_set_value( 'ms_course_sidebar_price_label' ) : __( 'Price:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-price">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-60"></i>';
						echo esc_html( $price_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo wp_kses_post( EduBlink_ms_Helper::course_price() );
					echo '</span>';
				echo '</li>';
			endif;

			if ( edublink_set_value( 'ms_course_instructor', true ) ) :
				$instructor_label = edublink_set_value( 'ms_course_instructor_label' ) ? edublink_set_value( 'ms_course_instructor_label' ) : __( 'Instructor:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-instructor">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-62"></i>';
						echo esc_html( $instructor_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo wp_kses_post( get_the_author() );
					echo '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $data['duration'] ) && edublink_set_value( 'ms_course_duration', true ) ) :
				$duration_label = edublink_set_value( 'ms_course_duration_label' ) ? edublink_set_value( 'ms_course_duration_label' ) : __( 'Duration:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-duration">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-61"></i>';
						echo esc_html( $duration_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $data['duration'] );
					echo '</span>';
				echo '</li>';
			endif;

			if ( edublink_set_value( 'ms_course_lessons', true ) ) :
				$lessons_label = edublink_set_value( 'ms_course_lessons_label' ) ? edublink_set_value( 'ms_course_lessons_label' ) : __( 'Lessons:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-lesson">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/icons/books.svg' ) . '" class="edublink-course-sidebar-img-icon">';
						echo esc_html( $lessons_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $data['lessons'] );
					echo '</span>';
				echo '</li>';
			endif;

			if ( edublink_set_value( 'ms_course_students', true ) && $data['enrolled'] ) :
				$students_label = edublink_set_value( 'ms_course_students_label' ) ? edublink_set_value( 'ms_course_students_label' ) : __( 'Students:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-student">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-63"></i>';
						echo esc_html( $students_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $data['enrolled'] );
					echo '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $data['language'] ) && edublink_set_value( 'ms_course_language', true ) ) :
				$language_label = edublink_set_value( 'ms_course_language_label' ) ? edublink_set_value( 'ms_course_language_label' ) : __( 'Language:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-language">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-59"></i>';
						echo esc_html( $language_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $data['language'] );
					echo '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $data['certificate'] ) && edublink_set_value( 'ms_course_certificate', true ) ) :
				$certificate_label = edublink_set_value( 'ms_course_certificate_label' ) ? edublink_set_value( 'ms_course_certificate_label' ) : __( 'Certifications:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-certificate">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-64"></i>';
						echo esc_html( $certificate_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $data['certificate'] );
					echo '</span>';
				echo '</li>';
			endif;

			if ( isset( $data['extra_meta'] ) && is_array( $data['extra_meta'] ) ) :
				foreach ( $data['extra_meta'] as $key => $meta ) :
					if ( $meta['label'] ) :
						$wrapper_class = '';
						if ( isset( $meta['wrapper_class'] ) && ! empty( $meta['wrapper_class'] ) ) :
							$wrapper_class = ' ' . $meta['wrapper_class'];
						endif;
						echo '<li class="edublink-course-details-features-item' . esc_attr( $wrapper_class ) . '">';
							echo '<span class="edublink-course-feature-item-label">';
								if ( isset( $meta['icon_class'] ) ) :
									echo '<i class="' . esc_attr( $meta['icon_class'] ) . '"></i>';
								else :
									echo '<i class="ri-check-fill"></i>';
								endif;
								echo esc_html( $meta['label'] );
							echo '</span>';

							if ( ! empty( $meta['value'] ) ) :
								echo '<span class="edublink-course-feature-item-value">' . esc_html( $meta['value'] ) . '</span>';
							endif;
						echo '</li>';
					endif;
				endforeach;
			endif;

			if ( isset( $data['buttons'] ) && is_array( $data['buttons'] ) ) :
				echo '<div class="edublink-course-details-sidebar-buttons">';
					foreach ( $data['buttons'] as $key => $button ) :
						$button_class = '';
						$href = '#';
						$target = '_self';
						if ( isset( $button['button_class'] ) && ! empty( $button['button_class'] ) ) :
							$button_class = ' ' . $button['button_class'];
						endif;
						if ( isset( $button['button_url'] ) ) :
							$href = $button['button_url'];
						endif;

						if ( isset( $button['button_tab_type'] ) && 'on' === $button['button_tab_type'] ) :
							$target = '_blank';
						endif;

						if ( $button['button_text'] ) :
							echo '<a class="course-sidebar-btn' . esc_attr( $button_class ) . '" href="' . esc_url( $href ) . '" target="' . esc_attr( $target ) . '">';
								echo esc_html( $button['button_text'] );
							echo '</a>';
						endif;
					endforeach;
				echo '</div>';
			endif;

			do_action( 'edublink_ms_course_meta_after' );
		echo '</ul>';
	}
endif;

/**
 * Breadcrumb Remove For Wishlist
 */
if ( ! function_exists( 'edublink_ms_breadcrumb_remove_at_wishlist' ) ) :
	function edublink_ms_breadcrumb_remove_at_wishlist() {
		if ( is_page( 'wishlist' ) ) :
			return true;
		endif;
		return false;
	}
endif;
add_filter( 'edublink_page_without_breadcrumb', 'edublink_ms_breadcrumb_remove_at_wishlist' );

/**
 * User Public Account Page Class
 */
if ( ! function_exists( 'edublink_ms_user_account_page_class' ) ) :
	function edublink_ms_user_account_page_class( $class ) {
		if ( is_page( 'user-public-account' ) ) :
			return ' eb-ms-user-public-page ' . $class;
		elseif ( is_page( 'user-account' ) ) :
			return ' eb-ms-user-account-page ' . $class;
		elseif ( is_page( 'wishlist' ) ) :
			return ' eb-ms-user-wishlist-page edublink-row ';
		endif;
		return $class;
	}
endif;
add_filter( 'edublink_main_content_inner', 'edublink_ms_user_account_page_class' );

/**
 * Related Courses
 */
if ( ! function_exists( 'edublink_ms_related_courses' ) ) :
	function edublink_ms_related_courses() {
		$related_courses = edublink_set_value( 'ms_related_courses', true );
		if ( isset( $_GET['disable_related_courses'] ) ) :
			$related_courses = false;
		endif;

		if ( $related_courses ) :
			STM_LMS_Templates::show_lms_template( 'custom/courses-related' );
		endif;
	}
endif;

/**
 * Course Author
 */
if ( ! function_exists( 'edublink_ms_course_author' ) ) :
	function edublink_ms_course_author() {
		$user_id = get_the_author_meta( 'ID' );
		$job  = get_the_author_meta( 'edublink_job', $user_id );
		if ( edublink_set_value( 'ms_course_author_box', true ) ) :
			echo '<div class="eb-course-author-box eb-ll-course-author-box edublink-course-author-wrapper">';
				echo '<div class="edublink-course-author-thumb">';
					echo get_avatar( get_the_author_meta( 'ID' ), 350 );
				echo '</div>';

				echo '<div class="edublink-course-author-details">';
					echo '<div class="edublink-author-bio-name">';
						echo '<h5>' . esc_html( get_the_author_meta( 'display_name', $user_id ) ) . '</h5>';
						// echo '<h5>' . esc_html( get_the_author() ) . '</h5>';
					echo '</div>';

					if( $job ) :
						echo '<div class="edublink-author-bio-designation">';
							echo '<span>' . wp_kses_post( $job ) . '</span>';
						echo '</div>';
					endif;

					echo '<div class="edublink-author-bio-details">';
						echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) );
					echo '</div>';
					
					echo '<div class="edublink-author-social-info">';
						edublink_user_social_icons( get_the_author_meta( 'ID' ) );
					echo '</div>';
				echo '</div>';
			echo '</div>';
		endif;
	}
endif;

/**
 * Course Rating
 */
if ( ! function_exists( 'edublink_ms_course_rating' ) ) :
	function edublink_ms_course_rating( $style = 'default' ) {
		$single_rating_text = edublink_set_value( 'text_for_rating', __( 'Rating', 'edublink' ) ) ? edublink_set_value( 'text_for_rating', __( 'Rating', 'edublink' ) ) : __( 'Rating', 'edublink' );
		$plural_rating_text = edublink_set_value( 'text_for_ratings', __( 'Ratings', 'edublink' ) ) ? edublink_set_value( 'text_for_ratings', __( 'Ratings', 'edublink' ) ) : __( 'Ratings', 'edublink' );
		$ratings = get_post_meta(get_the_ID(), 'course_marks', true);
		$percent = 0;
		$average_rating = '0.0';
		$rates = array(
			'5' => 0,
			'4' => 0,
			'3' => 0,
			'2' => 0,
			'1' => 0
		);

		if ( isset( $ratings ) && ! empty( $ratings ) && is_array( $ratings ) ) :
			$average_rating = round( array_sum( $ratings ) / count( $ratings ), 1 );
			$percent = $average_rating * 100 / 5;
			$average_rating = number_format( floatval( $average_rating ), 1 );

			foreach ( $ratings as $rating ) :
				$rates[$rating]++;
			endforeach;
		else :
			$ratings = [];
		endif;

		echo '<div class="eb-course-rating-content">';
			echo '<div class="eb-course-review-wrapper">';
				echo '<ul class="eb-course-review">';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
				echo '</ul>';
				
				echo '<ul class="eb-course-review eb-review-filled" style="width:' . esc_attr( $percent . '%' ) . '">';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
					echo '<li><span class="icon-23"></span></li>';
				echo '</ul>';
			echo '</div>';

			if ( 'text' === $style ) :
				echo '<span class="eb-rating-text">(';
					echo esc_html( $average_rating ) . '/ ';
					echo esc_html( count( $ratings ) ) . ' ';
					if ( (int)count( $ratings ) > 1 ) :
						echo esc_html( $plural_rating_text );
					else :
						echo esc_html( $single_rating_text );
					endif;
				echo ')</span>';
			elseif ( 'count' === $style ) :
				echo '<span class="eb-rating-text">(' . esc_html( $average_rating ) . ')</span>';
			endif;
		echo '</div>';
	}
endif;
